<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\Address;
use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\Product;

class CreateInvoiceTest extends InitTest
{
    public function testCreateUnpaidInvoice()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setPostamatNumber('5602-009');
        $invoice->setDescription('TEST zakaz');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('unpaid');
        $invoice->setGettingType('sc');
        $invoice->setSum(10.00);
        $invoice->setDeliveryMode('standard');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100);

        $invoice->setProducts([$product]);

        $response = $this->client->createShipment($invoice);

        print_r($response);

        $this->assertEquals($response['CreatedSendings'][0]['SenderCode'], $senderCode);

    }

    public function testCreatePaidWithClientReturnAddressInvoice()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp() . 'TEST';
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setDescription('Test zakaz');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('paid');
        $invoice->setGettingType('sc');
        $invoice->setSum(0); // IMPORTANT
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100.00);

        $invoice->setProducts([$product]);

        $address = new Address();
        $address->setCityName('Казань');
        $address->setPhoneNumber('+79274269594');
        $invoice->setClientReturnAddress($address);

        $response = $this->client->createShipment($invoice);

        $this->assertEquals($response['CreatedSendings'][0]['SenderCode'], $senderCode);
    }

    // TODO tests for validate exceptions

    /**
     * @expectedException \PickPointSdk\Exceptions\ValidateException
     */
    public function testValidateWithoutSenderCodeExceptions()
    {
        $invoice = new Invoice();
        $invoice->setDescription('TEST Zkaz');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('paid');
        $invoice->setGettingType('sc');

        $invoice->setSum(0); // IMPORTANT
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100);

        $invoice->setProducts([$product]);
        $this->expectException(\PickPointSdk\Exceptions\ValidateException::class);

        $response = $this->client->createShipment($invoice);

    }
    /**
     * @expectedException \PickPointSdk\Exceptions\ValidateException
     */
    public function testValidateWithoutRecipientExceptions()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setDescription('TEST TEST');
//        $invoice->setRecipientName('Айнур');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setPostageType('paid');
        $invoice->setGettingType('sc');

        $invoice->setSum(0); // IMPORTANT
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100);

        $invoice->setProducts([$product]);
        $this->expectException(\PickPointSdk\Exceptions\ValidateException::class);

        $response = $this->client->createShipment($invoice);

    }

    public function testUnpaidPostageTypeButSumEqualsZero()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setDescription('TEST TEST');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setPostageType('unpaid');
        $invoice->setGettingType('courier');

        $invoice->setSum(0); // SUM MUST BE > 0 for unpaid
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $product = new Product('number 234', 'Test', 2, 100);


        $invoice->setProducts([$product]);
        $this->expectException(\PickPointSdk\Exceptions\ValidateException::class);
        $response = $this->client->createShipment($invoice);

    }

    public function testPaidPostageTypeButSumNotEqualsZero()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setDescription('TEST TEST');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setPostageType('paid');
        $invoice->setGettingType('courier');

        $invoice->setSum(10); // SUM MUST BE = 0 for paid
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $this->expectException(\PickPointSdk\Exceptions\ValidateException::class);
        $response = $this->client->createShipment($invoice);
    }

    public function testInvoiceWithoutProducts()
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp() . 'TEST';
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setDescription('Test zakaz');
        $invoice->setRecipientName('Test');
        $invoice->setMobilePhone('+79274269592');

        $invoice->setPostamatNumber('5602-009');
        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('paid');
        $invoice->setGettingType('sc');
        $invoice->setSum(0); // IMPORTANT
        $invoice->setPrepaymentSum(10);
        $invoice->setDeliveryMode('standard');

        $response = $this->client->createShipment($invoice);

        $this->assertEquals($response['CreatedSendings'][0]['SenderCode'], $senderCode);
    }

}