<?php


namespace PickPointSdk\Components;


use PickPointSdk\Exceptions\ValidateException;

class InvoiceValidator
{
    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    public static function validateInvoice(Invoice $invoice)
    {
        self::validateSenderCode($invoice);

        self::validateDescription($invoice);

        self::validateRecipientName($invoice);

        self::validatePostamatNumber($invoice);

        self::validateMobilePhone($invoice);

        self::validateEmail($invoice);

        self::validatePostageType($invoice);

        self::validateGettingType($invoice);

        self::validateProducts($invoice);

    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateSenderCode(Invoice $invoice)
    {
        if (strlen($invoice->getSenderCode()) > 50 || empty($invoice->getSenderCode())) {
            throw new ValidateException('SenderCode is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateDescription(Invoice $invoice)
    {
        if (strlen($invoice->getDescription()) > 200 || empty($invoice->getDescription())) {
            throw new ValidateException('Description is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateRecipientName(Invoice $invoice)
    {
        if (strlen($invoice->getRecipientName()) > 150 || empty($invoice->getRecipientName())) {
            throw new ValidateException('RecipientName is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validatePostamatNumber(Invoice $invoice)
    {

        if (strlen($invoice->getPostamatNumber()) > 8 || empty($invoice->getPostamatNumber())) {
            throw new ValidateException('PostamatNumber is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateMobilePhone(Invoice $invoice)
    {
        if (strlen($invoice->getMobilePhone()) > 100) {
            throw new ValidateException('MobilePhone is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateEmail(Invoice $invoice)
    {
        if (strlen($invoice->getEmail()) > 256) {
            throw new ValidateException('Email is not correct');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validatePostageType(Invoice $invoice)
    {
        if (!array_key_exists($invoice->getPostageType(), $invoice->getPostageTypes())) {
            throw new ValidateException('PostageType is not correct');
        }
        if ($invoice->getPostageType() == Invoice::POSTAGE_TYPE_STANDARD && $invoice->getSum() != 0) {
            throw new ValidateException('Sum is not correct for this postage type');
        }
        if ($invoice->getPostageType() == Invoice::POSTAGE_TYPE_STANDARD_NP && $invoice->getSum() <= 0) {
            throw new ValidateException('Sum is not correct for this postage type');
        }
    }

    /**
     * @param Invoice $invoice
     * @throws ValidateException
     */
    private static function validateGettingType(Invoice $invoice)
    {
        if (!array_key_exists($invoice->getGettingType(), $invoice->getGettingTypes())) {
            throw new ValidateException('GettingType is not correct');
        }
    }

    private static function validateProducts(Invoice $invoice)
    {
        $products = $invoice->getProducts();
        if(count($products) == 0) {
            throw new ValidateException('Products (SubEncloses field) is empty');
        }
    }

}