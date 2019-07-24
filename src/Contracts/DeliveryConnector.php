<?php

namespace PickPointSdk\Contracts;

use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\ReceiverDestination;
use PickPointSdk\Components\SenderDestination;
use PickPointSdk\Components\TariffPrice;

interface DeliveryConnector
{
    /**
     * get delivery points
     * @return mixed
     */
    public function getPoints();

    /**
     * Returns invoice data and create shipment/order in delivery service
     * @param Invoice $invoice
     * @param bool $returnInvoiceNumberOnly
     * @return mixed
     */
    public function createShipment(Invoice $invoice);

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    public function createShipmentWithInvoice(Invoice $invoice) : Invoice;
    /**
     * Returns current delivery status
     * @param string $invoiceNumber
     * @param string $orderNumber
     * @return mixed
     */
    public function getStatus(string $invoiceNumber, string $orderNumber = '');

    /**
     * @param string $invoiceNumber
     * @return mixed
     */
    public function cancelInvoice(string $invoiceNumber);

    /**
     * @param ReceiverDestination $receiverDestination
     * @param SenderDestination|null $senderDestination
     * @param PackageSize|null $packageSize
     * @return mixed
     */
    public function calculatePrices(ReceiverDestination $receiverDestination, SenderDestination $senderDestination = null, PackageSize $packageSize = null) : array;

    /**
     * @param ReceiverDestination $receiverDestination
     * @param SenderDestination|null $senderDestination
     * @param PackageSize|null $packageSize
     * @return TariffPrice
     */
    public function calculateObjectedPrices(ReceiverDestination $receiverDestination, SenderDestination $senderDestination = null, PackageSize $packageSize = null) : TariffPrice;
    /**
     * Marks on packages
     * @param array $invoiceNumbers
     * @return mixed
     */
    public function printLabel(array $invoiceNumbers);

    /**
     * @param array $invoiceNumbers
     * @return mixed
     */
    public function makeReceipt(array $invoiceNumbers);

    /**
     * @param array $invoiceNumbers
     * @return mixed
     */
    public function makeReceiptAndPrint(array $invoiceNumbers);
    /**
     * Print reestr/receipt
     * @param string $identifier
     * @return mixed
     */
    public function printReceipt(string $identifier);

}