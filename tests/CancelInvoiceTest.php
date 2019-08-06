<?php


namespace PickPointSdk\Tests;


class CancelInvoiceTest extends  InitTest
{
    public function testCancelInvoice()
    {
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();

        $canceledInvoice = $this->client->cancelInvoice($invoiceNumber);
        $this->assertEquals($canceledInvoice['Result'], 1);
        $this->assertEquals($canceledInvoice['ErrorCode'], 0);

        $invoice = $this->createInvoice();
        $senderCode = $invoice->getSenderCode();
        $canceledInvoice = $this->client->cancelInvoice('', $senderCode);
        print_r($canceledInvoice);
        $this->assertEquals($canceledInvoice['Result'], 1);
        $this->assertEquals($canceledInvoice['ErrorCode'], 0);

    }


    public function testException()
    {
        $this->expectException(\PickPointSdk\Exceptions\PickPointMethodCallException::class);
        $canceledInvoice = $this->client->cancelInvoice("234234234");
        print_r($canceledInvoice);
    }
}