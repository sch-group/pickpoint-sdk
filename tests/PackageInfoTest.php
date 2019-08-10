<?php


namespace PickPointSdk\Tests;


class PackageInfoTest extends InitTest
{
    public function testEncloseInfo()
    {
        $invoice = $this->createInvoice();

        echo "bar code =" . $invoice->getBarCode();

    }
}