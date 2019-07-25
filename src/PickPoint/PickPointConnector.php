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
     * @var \Predis\Client $redisCache
     */
    private $redisCache;

    /**
     * PickPointConnector constructor.
     * @param PickPointConf $pickPointConf
     * @param SenderDestination|null $senderDestination
     * @param PackageSize|null $packageSize
     * @param array $predisConf
     */
    public function __construct(
        PickPointConf $pickPointConf,
        SenderDestination $senderDestination,
        PackageSize $packageSize = null,
        array $predisConf = []
    )
    {
        $this->client = new Client();
        $this->pickPointConf = $pickPointConf;
        $this->senderDestination = $senderDestination;
        $this->defaultPackageSize = $packageSize;
        $this->redisCache = !empty($predisConf) ? new \Predis\Client($predisConf) : null;
    }

    /**
     * @return string
     * @throws PickPointMethodCallException
     */
    private function auth()
    {
        if (!empty($this->redisCache) && !empty($this->redisCache->get(self::CACHE_SESSION_KEY))) {
            return $this->redisCache->get(self::CACHE_SESSION_KEY);
        }
        $loginUrl = $this->pickPointConf->getHost() . '/login';

        try {
            $request = $this->client->post($loginUrl, [
                'json' => [
                    'Login' => $this->pickPointConf->getLogin(),
                    'Password' => $this->pickPointConf->getPassword(),
                ],
            ]);
            $response = json_decode($request->getBody()->getContents(), true);

            if (!empty($this->redisCache)) {
                $this->redisCache->setex(self::CACHE_SESSION_KEY,  self::CACHE_SESSION_LIFE_TIME, $response['SessionId']);
            }

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
        $url = $this->pickPointConf->getHost() . '/clientpostamatlist';

        $request = $this->client->post($url, [
            'json' => [
                'SessionId' => $this->auth(),
                'IKN' => $this->pickPointConf->getIKN(),
            ],
        ]);
        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * @param PackageSize $packageSize
     * @param ReceiverDestination $receiverDestination
     * @param SenderDestination|null $senderDestination
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function calculatePrices(ReceiverDestination $receiverDestination, SenderDestination $senderDestination = null, PackageSize $packageSize = null): array
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
            "FromCity" => $senderDestination != null ? $senderDestination->getCity() : '',
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
     * Returns invoice data and create shipment/order in delivery service
     * @param Invoice $invoice
     * @param bool $returnInvoiceNumberOnly
     * @return mixed
     * @throws PickPointMethodCallException
     * @throws ValidateException
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
                                "Depth" => isset($packageSize) ? $packageSize->getDepth() : 0,
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
     * @param Invoice $invoice
     * @return mixed|void
     * @throws PickPointMethodCallException
     * @throws ValidateException
     */
    public function createShipmentWithInvoice(Invoice $invoice): Invoice
    {
        $response = $this->createShipment($invoice);

        if (!empty($response['CreatedSendings'])) {
            $invoice->setInvoiceNumber($response['CreatedSendings'][0]['InvoiceNumber']);
            $invoice->setBarCode($response['CreatedSendings'][0]['Barcode']);
        }
        return $invoice;
    }

    /**
     * Returns current delivery status
     * @param string $invoiceNumber
     * @param string $orderNumber
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function getStatus(string $invoiceNumber, string $orderNumber = '')
    {

        $url = $this->pickPointConf->getHost() . '/tracksending';
        $request = $this->client->post($url, [
            'json' => [
                'SessionId' => $this->auth(),
                "InvoiceNumber" => $invoiceNumber,
                "SenderInvoiceNumber" => $orderNumber
            ],
        ]);

        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        return $response[0] ?? [];
    }

    /**
     * @param string $invoiceNumber
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function cancelInvoice(string $invoiceNumber)
    {
        $url = $this->pickPointConf->getHost() . '/cancelInvoice';
        $request = $this->client->post($url, [
            'json' => [
                'SessionId' => $this->auth(),
                "IKN" => $this->pickPointConf->getIKN(),
                "InvoiceNumber" => $invoiceNumber
            ],
        ]);
        $response = $request->getBody()->getContents();

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * Marks on packages
     * @param array $invoiceNumbers
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function printLabel(array $invoiceNumbers)
    {
        $invoices = !empty($invoices) ? $invoices : [];

        $url = $this->pickPointConf->getHost() . '/makelabel';
        $request = $this->client->post($url, [
            'json' => [
                'SessionId' => $this->auth(),
                "Invoices" => $invoices,
            ],
        ]);
        $response = $request->getBody()->getContents();

        $this->checkMethodException($response, $url);

        return $response;
    }


    /**
     * @param array $invoiceNumbers
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function makeReceipt(array $invoiceNumbers)
    {

        $url = $this->pickPointConf->getHost() . '/makereestrnumber';
        $array = [
            'SessionId' => $this->auth(),
            "CityName" => $this->senderDestination->getCity(),
            "RegionName" => $this->senderDestination->getRegion(),
            "DeliveryPoint" => $this->senderDestination->getPostamatNumber(),
            "Invoices" => $invoiceNumbers,
        ];
        $request = $this->client->post($url, [
            'json' => $array,
        ]);

        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        if (!empty($response['ErrorMessage'])) {
            throw new PickPointMethodCallException($url, $response['ErrorMessage']);
        }
        return $response['Numbers'] ?? [];

    }

    /**
     * Returns byte code pdf
     * @param string $identifier
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function printReceipt(string $identifier)
    {
        $url = $this->pickPointConf->getHost() . '/getreestr';
        $array = [
            'SessionId' => $this->auth(),
            "ReestrNumber" => $identifier
        ];
        $request = $this->client->post($url, [
            'json' => $array,
        ]);
        $response = $request->getBody()->getContents();

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * @param array $invoiceNumbers
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function makeReceiptAndPrint(array $invoiceNumbers)
    {
        $url = $this->pickPointConf->getHost() . '/makereestr';
        $array = [
            'SessionId' => $this->auth(),
            "CityName" => $this->senderDestination->getCity(),
            "RegionName" => $this->senderDestination->getRegion(),
            "DeliveryPoint" => $this->senderDestination->getPostamatNumber(),
            "Invoices" => $invoiceNumbers,
        ];
        $request = $this->client->post($url, [
            'json' => $array,
        ]);

        $response = $request->getBody()->getContents();

        $this->checkMethodException($response, $url);

        return $response;
    }

    /**
     * @param string $invoiceNumber
     * @return mixed
     * @throws PickPointMethodCallException
     */
    public function removeInvoiceFromReceipt(string $invoiceNumber)
    {
        $url = $this->pickPointConf->getHost() . '/removeinvoicefromreestr';
        $array = [
            'SessionId' => $this->auth(),
            'IKN' => $this->pickPointConf->getIKN(),
            "InvoiceNumber" => $invoiceNumber,
        ];
        $request = $this->client->post($url, [
            'json' => $array,
        ]);

        $response = json_decode($request->getBody()->getContents(), true);

        $this->checkMethodException($response, $url);

        return $response;
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


}