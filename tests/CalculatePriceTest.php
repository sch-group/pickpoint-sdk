<?php


namespace PickPointSdk\Tests;

use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\ReceiverDestination;

class CalculatePriceTest extends InitTest
{
    /**
     * PASS only with prod settings
     * @throws \PickPointSdk\Exceptions\PickPointMethodCallException
     */
    public function testCalculatePrice()
    {
        $packageSize = new PackageSize(30, 30, 30);
        $receiverDestination = new ReceiverDestination('Москва', 'Московская обл.', '7701-015');
        $prices = $this->client->calculatePrices($receiverDestination, null, $packageSize);
        $this->assertTrue(!empty($prices['Services']));

        $receiverDestination = new ReceiverDestination('Москва', 'Московская обл.');
        $prices = $this->client->calculatePrices($receiverDestination, null, $packageSize);
        $this->assertTrue(!empty($prices['Services']));

        $receiverDestination = new ReceiverDestination('Санкт-Петербург', 'Ленинградская обл.');
        $prices = $this->client->calculatePrices($receiverDestination);
        $this->assertTrue(!empty($prices['Services']));
    }

    /**
     * @expectedException \PickPointSdk\Exceptions\PickPointMethodCallException
     */
    public function testCalculateException()
    {
        $receiverDestination = new ReceiverDestination('Москва', 'Моско');
        $packageSize = new PackageSize(30, 30, 30);
        $price = $this->client->calculatePrices($receiverDestination, null, $packageSize);
        $this->expectException(\PickPointSdk\Exceptions\PickPointMethodCallException::class);
    }

    public function testCalculatePriceObject()
    {
        $receiverDestination = new ReceiverDestination('Москва', 'Московская обл.', '7701-015');
        $tariffPrice = $this->client->calculateObjectedPrices($receiverDestination);
        $commonStandardPrice = $tariffPrice->getStandardCommonPrice();
        $this->assertTrue($commonStandardPrice > 0);
        $this->assertFalse($tariffPrice->existsPriorityType());
        $this->assertTrue($tariffPrice->getPrice() > 0);

        echo "common price = " . $commonStandardPrice;
    }

}