<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\Invoice;

class UpdateShipmentTest extends InitTest
{
    public function testUpdate()
    {
        $invoice = $this->createInvoice();

        $updateInvoice = new Invoice();
        $updateInvoice->setInvoiceNumber($invoice->getInvoiceNumber());
        $newFio = "Кек чебурек";
        $newSum = 20.32;
        $updateInvoice->setRecipientName($newFio);
        $updateInvoice->setSum($newSum);
        $updateInvoice->setMobilePhone('+745642411');
        $response = $this->client->updateShipment($updateInvoice);

        $invoiceInfo = $this->client->shipmentInfo($invoice->getInvoiceNumber());

        $this->assertEquals($invoiceInfo['FIO'], $newFio);
        $this->assertEquals(floatval(str_replace(',', '.',$invoiceInfo['Sum'])), $newSum);

    }
}