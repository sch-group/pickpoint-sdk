<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\Product;
use PickPointSdk\Components\PackageSize;

class PrintLabelsAndReestrsTest extends InitTest
{
    public function testPrintLabel()
    {
        /**
         * Invoice $invoice
         */
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();
        $pdfByteCode = $this->client->printLabel(array($invoiceNumber));
        $this->assertTrue(is_string($pdfByteCode));
        $this->assertNotEmpty($pdfByteCode);
    }

    public function testMakeReestr()
    {
        /**
         * Invoice $invoice
         */
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();

        $reestr = $this->client->makeReceipt(array($invoiceNumber));
        $this->assertTrue(count($reestr) > 0);

        $pdfByteCode = $this->client->printReceipt($reestr[0]);
        $this->assertTrue(is_string($pdfByteCode));
        $this->assertNotEmpty($pdfByteCode);

        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();
        $pdfByteCode = $this->client->makeReceiptAndPrint(array($invoiceNumber));

        $this->assertTrue(is_string($pdfByteCode));
        $this->assertNotEmpty($pdfByteCode);

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

        $product = new Product();
        $product->setDescription('Test product');
        $product->setPrice(200);
        $product->setQuantity(1);
        $product->setName('Tovar 1');
        $product->setProductCode('1231');

        $invoice->setProducts([$product]);

        return $this->client->createShipmentWithInvoice($invoice);

    }
}