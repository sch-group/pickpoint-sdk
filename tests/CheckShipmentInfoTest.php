<?php


namespace PickPointSdk\Tests;


class CheckShipmentInfoTest extends InitTest
{
    public function testShipmentInfo()
    {
        $invoice = $this->createInvoice();

        $invoiceNumber = $invoice->getInvoiceNumber();
        $senderCode = $invoice->getSenderCode();

        $response = $this->client->shipmentInfo($invoiceNumber);

        $this->assertTrue(is_string($response[0]['FIO']));
        $this->assertNotEmpty($response[0]['CreateDate']);

        $response = $this->client->shipmentInfo('', $senderCode);

        $this->assertTrue(is_string($response[0]['FIO']));
        $this->assertNotEmpty($response[0]['CreateDate']);
    }

    public function testEmptyInfo()
    {
        $shipmentInfo = $this->client->shipmentInfo('', 'asdfa');
        $this->assertEmpty($shipmentInfo);
    }
}