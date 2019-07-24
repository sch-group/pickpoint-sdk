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
     * @var string
     */
    private $cellStorageType;

    /**
     * @param string $name
     * @return int
     */
    public function getPostageByName($name = 'paid')
    {
        return $name == 'paid' ? self::POSTAGE_TYPE_STANDARD : self::POSTAGE_TYPE_STANDARD_NP;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getGettingTypeByName($name = 'courier')
    {
        return $name == 'courier' ? self::GETTING_TYPE_COURIER : self::GETTING_TYPE_SC;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getDeliveryModeByName($name = 'standard')
    {
        return $name == 'standard' ? self::DELIVERY_MODE_STANDARD : self::DELIVERY_MODE_PRIORITY;
    }

    /**
     * @return array
     */
    public function getPostageTypes()
    {
        return [
            self::POSTAGE_TYPE_STANDARD => 'Стандарт. Оплаченный заказ.',
            self::POSTAGE_TYPE_STANDARD_NP => 'Стандарт НП Отправление с наложенным платежом.',
        ];
    }

    /**
     * @return array
     */
    public function getGettingTypes()
    {
        return [
            self::GETTING_TYPE_COURIER => 'Курьер',
            self::GETTING_TYPE_SC => 'СЦ',
        ];
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param mixed $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return mixed
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * @param mixed $barCode
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;
    }

    /**
     * @return mixed
     */
    public function getSenderCode()
    {
        return $this->senderCode;
    }

    /**
     * @param mixed $senderCode
     */
    public function setSenderCode($senderCode)
    {
        $this->senderCode = $senderCode;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * @param mixed $recipientName
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    /**
     * @return mixed
     */
    public function getPostamatNumber()
    {
        return $this->postamatNumber;
    }

    /**
     * @param mixed $postamatNumber
     */
    public function setPostamatNumber($postamatNumber)
    {
        $this->postamatNumber = $postamatNumber;
    }

    /**
     * @return mixed
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param mixed $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPostageType()
    {
        return $this->postageType;
    }

    /**
     * @param mixed $postageType
     */
    public function setPostageType($postageType = 'paid')
    {
        $this->postageType = $this->getPostageByName($postageType);
    }

    /**
     * @return mixed
     */
    public function getGettingType()
    {
        return $this->gettingType;
    }

    /**
     * @param mixed $gettingType
     */
    public function setGettingType($gettingType = 'courier')
    {
        $this->gettingType = $this->getGettingTypeByName($gettingType);
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getPrepaymentSum()
    {
        return $this->prepaymentSum;
    }

    /**
     * @param mixed $prepaymentSum
     */
    public function setPrepaymentSum($prepaymentSum)
    {
        $this->prepaymentSum = $prepaymentSum;
    }

    /**
     * @return mixed
     */
    public function getDeliveryVat()
    {
        return $this->deliveryVat;
    }

    /**
     * @param mixed $deliveryVat
     */
    public function setDeliveryVat($deliveryVat)
    {
        $this->deliveryVat = $deliveryVat;
    }

    /**
     * @return mixed
     */
    public function getDeliveryFee()
    {
        return $this->deliveryFee;
    }

    /**
     * @param mixed $deliveryFee
     */
    public function setDeliveryFee($deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;
    }

    /**
     * @return SenderDestination
     */
    public function getSenderDestination()
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
    public function getClientReturnAddress()
    {
        return $this->clientReturnAddress != null ? $this->clientReturnAddress->getArray() : [];
    }

    /**
     * @param Address $clientReturnAddress
     */
    public function setClientReturnAddress($clientReturnAddress)
    {
        $this->clientReturnAddress = $clientReturnAddress;
    }

    /**
     * @return array
     */
    public function getUnclaimedReturnAddress()
    {

        return $this->unclaimedReturnAddress != null ? $this->unclaimedReturnAddress->getArray() : [];
    }

    /**
     * @param Address $unclaimedReturnAddress
     */
    public function setUnclaimedReturnAddress($unclaimedReturnAddress)
    {
        $this->unclaimedReturnAddress = $unclaimedReturnAddress;
    }

    /**
     * @return PackageSize
     */
    public function getPackageSize()
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
    public function getProducts()
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
     * @return mixed
     */
    public function getDeliveryMode()
    {
        return $this->deliveryMode;
    }

    /**
     * @param mixed $deliveryMode
     */
    public function setDeliveryMode($deliveryMode = 'standard')
    {
        $this->deliveryMode = $this->getDeliveryModeByName($deliveryMode);
    }

    /**
     * @return mixed
     */
    public function getConsultantNumber()
    {
        return $this->consultantNumber;
    }

    /**
     * @param mixed $consultantNumber
     */
    public function setConsultantNumber($consultantNumber)
    {
        $this->consultantNumber = $consultantNumber;
    }

    /**
     * @return mixed
     */
    public function getGcBarCode()
    {
        return $this->gcBarCode;
    }

    /**
     * @param mixed $gcBarCode
     */
    public function setGcBarCode($gcBarCode)
    {
        $this->gcBarCode = $gcBarCode;
    }

    /**
     * @return mixed
     */
    public function getCellStorageType()
    {
        return $this->cellStorageType;
    }

    /**
     * @param mixed $cellStorageType
     */
    public function setCellStorageType($cellStorageType)
    {
        $this->cellStorageType = $cellStorageType;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getEdtn()
    {
        if(empty($this->edtn)) {
            return (new \DateTime('now'))->getTimestamp();
        }
        return $this->edtn;
    }

    /**
     * @param $edtn
     */
    public function setEdtn($edtn)
    {
        $this->edtn = $edtn;
    }

}