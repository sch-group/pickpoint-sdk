<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\State;

class TrackSendingsHistoryTest extends InitTest
{
    /**
     * @throws \PickPointSdk\Exceptions\PickPointMethodCallException
     */
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

    /**
     * @throws \PickPointSdk\Exceptions\PickPointMethodCallException
     */
    public function testSendingsArrayHistory()
    {
        $invoice = $this->createInvoice();
        $invoiceNumberOne = $invoice->getInvoiceNumber();
        $invoice = $this->createInvoice();
        $invoiceNumberTwo = $invoice->getInvoiceNumber();
        $invoiceNumbers = array($invoiceNumberOne, $invoiceNumberTwo);
        $pdfByteCode = $this->client->makeReceiptAndPrint([$invoiceNumberOne]);

        $finalStates = $this->client->getInvoicesLastStates($invoiceNumbers);
        /**
         * @var State $finalStateOne
         */
        $finalStateOne = $finalStates[$invoiceNumberOne];
        $finalStateTwo = $finalStates[$invoiceNumberTwo];
        $this->assertEquals($finalStateOne->getStateCode(), 102);
        $this->assertEquals($finalStateTwo->getStateCode(), 101);

    }

}