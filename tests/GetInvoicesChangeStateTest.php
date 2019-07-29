<?php


namespace PickPointSdk\Tests;


class GetInvoicesChangeStateTest extends InitTest
{
    public function testInvoicesDateRange()
    {
        $dateFrom = '01.06.2019 00:00';
        $daterTo = '27.07.2019 00:00';
        $invoices = $this->client->getInvoicesByDateRange($dateFrom, $daterTo);
        print_r($invoices);
        $this->assertNotEmpty($invoices[0]['BarCode']);

    }
}