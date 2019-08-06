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

        $state = $this->client->getState($invoiceNumber);
        $this->assertNotEmpty($state->getState());
        $this->assertNotEmpty($state->getStateText());
        $this->assertEquals(101, $state->getState());
        $this->assertEquals('Зарегистрирован', $state->getStateText());

    }
}