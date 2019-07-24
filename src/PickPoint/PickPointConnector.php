<?php

namespace PickPointSdk\PickPoint;

use GuzzleHttp\Client;
use phpDocumentor\Reflection\Types\Null_;
use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\InvoiceValidator;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\ReceiverDestination;
use PickPointSdk\Components\SenderDestination;
use PickPointSdk\Components\TariffPrice;
use PickPointSdk\Contracts\DeliveryConnector;
use PickPointSdk\Exceptions\PickPointMethodCallException;
use PickPointSdk\Exceptions\ValidateException;

class PickPointConnector implements DeliveryConnector
{
    const CACHE_SESSION_KEY = 'pickpoint_session_id';

    const CACHE_SESSION_LIFE_TIME = 60;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var PickPointConf
     */
    private $pickPointConf;

    /**
     * @var SenderDestination
     */
    private $senderDestination;

    /**
     * @var PackageSize
     */
    private $defaultPackageSize;

    /**
     * PickPointConnector constructor.
     * @param PickPointConf $pickPointConf
     * @param SenderDestination|null $senderDestination
     * @param PackageSize|null $packageSize
     */
    public function __construct(PickPointConf $pickPointConf, SenderDestination $senderDestination, PackageSize $packageSize = null)
    {
        $this->client = new Client();
        $this->pickPointConf = $pickPointConf;
        $this->senderDestination = $senderDestination;
        $this->defaultPackageSize = $packageSize;
    }

    /**
     * @return string
     * @throws PickPointMethodCallException
     */
    private function auth()
    {
        $loginUrl = $this->pickPointConf->getHost() . '/login';
        try {
            $request = $this->client->post($loginUrl, [
                'json' => [
                    'Login' => $this->pickPointConf->getLogin(),
                    'Password' => $this->pickPointConf->getPassword(),
                ],
            ]);
            $response = json_decode($request->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new PickPointMethodCallException($loginUrl, $exception->getMessage());
        }

        return $response['SessionId'];
    }


    /**
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function getPoints()
    {
        $sessionId = $this->auth();
        $postamatsUrl = $this->pickPointConf->getHost() . '/clientpostamatlist';

        $request = $this->client->post($postamatsUrl, [
            'json' => [
                'SessionId' => $sessionId,
                'IKN' => $this->pickPointConf->getIKN(),
            ],
        ]);
        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $postamatsUrl);

        return $response;
    }

    /**
     * @param PackageSize $packageSize
     * @param ReceiverDestination $receiverDestination
     * @param SenderDestination|null $senderDestination
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function calculatePrices(ReceiverDestination $receiverDestination, SenderDestination $senderDestination = null, PackageSize $packageSize = null) : array
    {
        $url = $this->pickPointConf->getHost() . '/calctariff';
        /**
         * SenderDestination $senderDestination
         */
        $senderDestination = $senderDestination ?? $this->senderDestination;
        /**
         * PackageSize $packageSize
         */
        $packageSize = $packageSize ?? $this->defaultPackageSize;

        $requestArray = [
                'SessionId' => $this->auth(),
                "IKN" => $this->pickPointConf->getIKN(),
                "FromCity" =>  $senderDestination != null ? $senderDestination->getCity() : '',
                "FromRegion" => $senderDestination != null ? $senderDestination->getRegion() : '',
                "ToCity" => $receiverDestination->getCity(),
                "ToRegion" => $receiverDestination->getRegion(),
                "PtNumber" => $receiverDestination->getPostamatNumber(),
                "Length" => $packageSize != null ? $packageSize->getLength() : '',
                "Depth" => $packageSize != null ? $packageSize->getDepth() : '',
                "Width" => $packageSize != null ? $packageSize->getWidth() : '',
                "Weight" => $packageSize != null ? $packageSize->getWeight() : ''
        ];

        $request = $this->client->post($url, [
            'json' => $requestArray,
        ]);

        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * @param ReceiverDestination $receiverDestination
     * @param SenderDestination|null $senderDestination
     * @param PackageSize|null $packageSize
     * @return TariffPrice
     * @throws PickPointMethodCallException
     */
    public function calculateObjectedPrices(ReceiverDestination $receiverDestination, SenderDestination $senderDestination = null, PackageSize $packageSize = null): TariffPrice
    {
        $response = $this->calculatePrices($receiverDestination, $senderDestination, $packageSize);
        $tariffPrice = new TariffPrice($response);
        return $tariffPrice;
    }


    /**
     * @param $response
     * @param $urlCall
     * @return mixed
     * @throws PickPointMethodCallException
     */
    private function checkMethodException($response, $urlCall)
    {
        if (!empty($response['ErrorCode'])) {
            $errorCode = $response['ErrorCode'];
            $errorMessage = $response['Error'] ?? "";
            throw new PickPointMethodCallException($urlCall, $errorMessage, $errorCode);
        }
    }


    /**
     * Returns invoice data and create shipment/order in delivery service
     * @param Invoice $invoice
     * @return mixed
     * @throws PickPointMethodCallException
     * @throws \PickPointSdk\Exceptions\ValidateException
     */
    public function createShipment(Invoice $invoice)
    {

        $url = $this->pickPointConf->getHost() . '/CreateShipment';
        $packageSize = $invoice->getPackageSize();
        InvoiceValidator::validateInvoice($invoice);

        $arrayRequest = [
            "SessionId" => $this->auth(),
            "Sendings" => [
                [
                    "EDTN" => $invoice->getEdtn(),
                    "IKN" => $this->pickPointConf->getIKN(),
                    "Invoice" => [
                        "SenderCode" => $invoice->getSenderCode(), // required
                        "Description" => $invoice->getDescription(), // required
                        "RecipientName" => $invoice->getRecipientName(), // required
                        "PostamatNumber" => $invoice->getPostamatNumber(), // required
                        "MobilePhone" => $invoice->getMobilePhone(), // required
                        "Email" => $invoice->getEmail() ?? '',
                        "ConsultantNumber" => $invoice->getConsultantNumber() ?? '',
                        "PostageType" => $invoice->getPostageType(), // required
                        "GettingType" => $invoice->getGettingType(), // required
                        "PayType" => Invoice::PAY_TYPE,
                        "Sum" => $invoice->getSum(), // required
                        "PrepaymentSum" => $invoice->getPrepaymentSum() ?? 0,
                        "DeliveryVat" => $invoice->getDeliveryVat() ?? 0,
                        "DeliveryFee" => $invoice->getDeliveryFee() ?? 0,
                        "DeliveryMode" => $invoice->getDeliveryMode(), // required
                        "SenderCity" => [
                            "CityName" => $this->senderDestination->getCity(),
                            "RegionName" => $this->senderDestination->getRegion()
                        ],
                        "ClientReturnAddress" => $invoice->getClientReturnAddress() ?? [],
                        "UnclaimedReturnAddress" => $invoice->getUnclaimedReturnAddress() ?? [],
                        "Places" => [
                            [
                                "Width" => isset($packageSize) ? $packageSize->getWidth() : 0,
                                "Height" => isset($packageSize) ? $packageSize->getLength() : 0,
                                "Depth" =>  isset($packageSize) ? $packageSize->getDepth() : 0,
                                "Weight" => isset($packageSize) ? $packageSize->getWeight() : 1,
                                "GSBarCode" => $invoice->getGcBarCode() ?? '',
                                "CellStorageType" => 0,
                                "SumEncloses" => [
                                    $invoice->getProducts() // required
                                ]
                            ]
                        ],
                    ]
                ],
            ]
        ];

        $request = $this->client->post($url, [
            'json' => $arrayRequest,
        ]);

        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * Returns current delivery status
     * @param string $invoiceNumber
     * @return mixed
     */
    public function getStatus(string $invoiceNumber)
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * @param string $invoiceNumber
     * @return mixed
     */
    public function cancelInvoice(string $invoiceNumber)
    {
        // TODO: Implement cancelInvoice() method.
    }

    /**
     * Marks on packages
     * @param array $invoiceNumbers
     * @return mixed
     */
    public function printLabel(array $invoiceNumbers)
    {
        // TODO: Implement printLabel() method.
    }

    /**
     * Print reestr/receipt
     * @param string $identifier
     * @return mixed
     */
    public function printReceipt(string $identifier)
    {
        // TODO: Implement printReceipt() method.
    }

}