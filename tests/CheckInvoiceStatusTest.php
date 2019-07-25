<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\Product;

class CheckInvoiceStatusTest extends InitTest
{
    public function testCheckStatus()
    {
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();
        $status = $this->client->getStatus($invoiceNumber);
        $this->assertNotEmpty($status['State']);
        $this->assertNotEmpty($status['StateMessage']);
    }

    private function createInvoice()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setPostamatNumber('5602-009');
        $invoice->setDescription('Custom zakaz');
        $invoice->setRecipientName('Айнур');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('unpiad');
        $invoice->setGettingType('sc');
        $invoice->setSum(500.00);
        $invoice->setDeliveryMode('priority');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100);

        $invoice->setProducts([$product]);

        return $this->client->createShipmentWithInvoice($invoice);

    }
}