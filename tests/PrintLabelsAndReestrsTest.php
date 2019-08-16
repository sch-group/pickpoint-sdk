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

        $remove = $this->client->removeInvoiceFromReceipt($invoiceNumber);
        $this->assertEquals(0, $remove['ErrorCode']);

        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();
        $pdfByteCode = $this->client->makeReceiptAndPrint(array($invoiceNumber));
        print_r($pdfByteCode);

        $this->assertTrue(is_string($pdfByteCode));
        $this->assertNotEmpty($pdfByteCode);

    }



    public function testFindReestrNumberByInvoice()
    {
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();

        $this->client->makeReceipt(array($invoiceNumber));

        $reestrNumber = $this->client->findReestrNumberByInvoice($invoiceNumber);

        $this->assertNotEmpty($reestrNumber);

        $this->assertTrue(is_string($reestrNumber));

        $this->assertTrue(strlen($reestrNumber) > 2);

        echo "reestr = " . $reestrNumber;
    }
}