<?php

namespace PickPointSdk\Components;

class Invoice
{
    const POSTAGE_TYPE_STANDARD = 10001; #Стандарт. Оплаченный заказ. При этом поле «Sum=0»

    const POSTAGE_TYPE_STANDARD_NP = 10003; # Стандарт НП Отправление с наложенным платежом. Поле «Sum>0»

    const GETTING_TYPE_COURIER = 101;

    const GETTING_TYPE_SC = 102;

    const PAY_TYPE = 1;

    const DELIVERY_MODE_STANDARD = 1;

    const DELIVERY_MODE_PRIORITY = 2;

    /**
     * @var string
     */
    private $invoiceNumber;

    /**
     * @var string
     */
    private $barCode;

    /**
     * @var string
     */
    private $edtn;

    /**
     * @var string
     */
    private $senderCode; // required

    /**
     * @var string
     */
    private $description;  // required

    /**
     * @var string
     */
    private $recipientName;  // required

    /**
     * @var string
     */
    private $postamatNumber;  // required

    /***
     * @var string
     */
    private $mobilePhone;  // required

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $consultantNumber;

    /**
     * @var string
     */
    private $postageType;  // required

    /**
     * @var string
     */
    private $gettingType;  // required

    /**
     * @var float
     */
    private $sum;  // required

    /**
     * @var float
     */
    private $prepaymentSum;

    /**
     * @var float
     */
    private $deliveryVat;

    /**
     * @var float
     */
    private $deliveryFee;

    /**
     * @var string
     */
    private $deliveryMode;

    /**
     * @var SenderDestination
     */
    private $senderDestination;

    /**
     * @var Address $clientReturnAddress
     */
    private $clientReturnAddress;

    /**
     * @var Address $unclaimedReturnAddress
     */
    private $unclaimedReturnAddress;

    /**
     * @var PackageSize $packageSize
     */
    private $packageSize;  // required

    /**
     * @var array
     */
    private $products;  // required

    /**
     * @var string
     */
    private $gcBarCode;

    /**
     * @var int
     */
    private $cellStorageType;

    /**
     * @return array
     */
    public function getPostageTypes() : array
    {
        return [
            self::POSTAGE_TYPE_STANDARD => 'Стандарт. Оплаченный заказ.',
            self::POSTAGE_TYPE_STANDARD_NP => 'Стандарт НП Отправление с наложенным платежом.',
        ];
    }

    /**
     * @return array
     */
    public function getGettingTypes() : array
    {
        return [
            self::GETTING_TYPE_COURIER => 'Курьер',
            self::GETTING_TYPE_SC => 'СЦ',
        ];
    }

    /**
     * @return string
     */
    public function getInvoiceNumber() : string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber(string $invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return string
     */
    public function getBarCode() : string
    {
        return $this->barCode;
    }

    /**
     * @param string $barCode
     */
    public function setBarCode(string $barCode)
    {
        $this->barCode = $barCode;
    }

    /**
     * @return string
     */
    public function getSenderCode() : string
    {
        return $this->senderCode;
    }

    /**
     * @param string $senderCode
     */
    public function setSenderCode(string $senderCode)
    {
        $this->senderCode = $senderCode;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description ?? '';
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRecipientName() : string
    {
        return $this->recipientName;
    }

    /**
     * @param string $recipientName
     */
    public function setRecipientName(string $recipientName)
    {
        $this->recipientName = $recipientName;
    }

    /**
     * @return string
     */
    public function getPostamatNumber() : string
    {
        return $this->postamatNumber;
    }

    /**
     * @param string $postamatNumber
     */
    public function setPostamatNumber(string $postamatNumber)
    {
        $this->postamatNumber = $postamatNumber;
    }

    /**
     * @return string
     */
    public function getMobilePhone() : string
    {
        return $this->mobilePhone;
    }

    /**
     * @param string$mobilePhone
     */
    public function setMobilePhone(string $mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPostageType() : string
    {
        return $this->postageType;
    }

    /**
     * @param string $postageType
     */
    public function setPostageType(string $postageType = 'paid')
    {
        $this->postageType = $postageType == 'paid' ? self::POSTAGE_TYPE_STANDARD : self::POSTAGE_TYPE_STANDARD_NP;;
        if ($this->postageType == self::POSTAGE_TYPE_STANDARD) {
            $this->setSum(0);
        }
    }

    /**
     * @return string
     */
    public function getGettingType() : string
    {
        return $this->gettingType;
    }

    /**
     * @param string $gettingType
     */
    public function setGettingType(string $gettingType = 'courier')
    {
        $this->gettingType = $gettingType == 'courier' ? self::GETTING_TYPE_COURIER : self::GETTING_TYPE_SC;
    }

    /**
     * @return float
     */
    public function getSum() : float
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return float
     */
    public function getPrepaymentSum() : float
    {
        return $this->prepaymentSum;
    }

    /**
     * @param float $prepaymentSum
     */
    public function setPrepaymentSum(float $prepaymentSum)
    {
        $this->prepaymentSum = $prepaymentSum;
    }

    /**
     * @return float
     */
    public function getDeliveryVat() : float
    {
        return $this->deliveryVat ?? 0;
    }

    /**
     * @param float $deliveryVat
     */
    public function setDeliveryVat(float $deliveryVat)
    {
        $this->deliveryVat = $deliveryVat;
    }

    /**
     * @return float
     */
    public function getDeliveryFee() : float
    {
        return $this->deliveryFee ?? 0;
    }

    /**
     * @param float $deliveryFee
     */
    public function setDeliveryFee(float $deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;
    }

    /**
     * @return SenderDestination
     */
    public function getSenderDestination() : SenderDestination
    {
        return $this->senderDestination;
    }

    /**
     * @param SenderDestination $senderDestination
     */
    public function setSenderDestination(SenderDestination $senderDestination)
    {
        $this->senderDestination = $senderDestination;
    }

    /**
     * @return array
     */
    public function getClientReturnAddress() : array
    {
        return $this->clientReturnAddress != null ? $this->clientReturnAddress->transformToArray() : [];
    }

    /**
     * @param Address $clientReturnAddress
     */
    public function setClientReturnAddress(Address $clientReturnAddress)
    {
        $this->clientReturnAddress = $clientReturnAddress;
    }

    /**
     * @return array
     */
    public function getUnclaimedReturnAddress(): array
    {
        return $this->unclaimedReturnAddress != null ? $this->unclaimedReturnAddress->transformToArray() : [];
    }

    /**
     * @param Address $unclaimedReturnAddress
     */
    public function setUnclaimedReturnAddress(Address $unclaimedReturnAddress)
    {
        $this->unclaimedReturnAddress = $unclaimedReturnAddress;
    }

    /**
     * @return PackageSize
     */
    public function getPackageSize(): PackageSize
    {
        return $this->packageSize;
    }

    /**
     * @param PackageSize $packageSize
     */
    public function setPackageSize(PackageSize $packageSize)
    {
        $this->packageSize = $packageSize;
    }

    /**
     * @return array
     */
    public function getProducts() : array
    {
        $products = [];
        foreach ($this->products as $product) {
            /**
             * @var Product $product
             */
            $products[] = $product->getProductArray();
        }
        return $products;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products)
    {
        $this->products = $products;
    }

    /**
     * @return string
     */
    public function getDeliveryMode() : string
    {
        return $this->deliveryMode;
    }

    /**
     * @param string $deliveryMode
     */
    public function setDeliveryMode(string $deliveryMode = 'standard')
    {
        $this->deliveryMode = $deliveryMode == 'standard' ? self::DELIVERY_MODE_STANDARD : self::DELIVERY_MODE_PRIORITY;
    }

    /**
     * @return string
     */
    public function getConsultantNumber()
    {
        return $this->consultantNumber ?? '';
    }

    /**
     * @param string $consultantNumber
     */
    public function setConsultantNumber(string $consultantNumber)
    {
        $this->consultantNumber = $consultantNumber;
    }

    /**
     * @return string
     */
    public function getGcBarCode()
    {
        return $this->gcBarCode ?? '';
    }

    /**
     * @param mixed $gcBarCode
     */
    public function setGcBarCode($gcBarCode)
    {
        $this->gcBarCode = $gcBarCode;
    }

    /**
     * @return int
     */
    public function getCellStorageType() : int
    {
        return $this->cellStorageType ?? 0;
    }

    /**
     * @param int $cellStorageType
     */
    public function setCellStorageType(int $cellStorageType)
    {
        $this->cellStorageType = $cellStorageType;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getEdtn()
    {
        if (empty($this->edtn)) {
            return (new \DateTime('now'))->getTimestamp();
        }
        return $this->edtn;
    }

    /**
     * @param string $edtn
     */
    public function setEdtn(string $edtn)
    {
        $this->edtn = $edtn;
    }

}