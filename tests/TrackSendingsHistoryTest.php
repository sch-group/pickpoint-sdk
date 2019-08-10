<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\State;

class TrackSendingsHistoryTest extends InitTest
{
    public function testSendingsHistory()
    {
        $invoice = $this->createInvoice();
        $invoiceNumber = $invoice->getInvoiceNumber();
        $response = $this->client->getInvoicesTrackHistory([$invoiceNumber]);
        $this->assertEmpty($response['ErrorCode']);
        $states = $this->client->getInvoiceStatesTrackHistory($invoiceNumber);
        $this->assertTrue(is_array($states));
        /**
         * @var State $state
         */
        $state = current($states);
        $this->assertTrue(is_string($state->getPrettyStateText()));

    }
}