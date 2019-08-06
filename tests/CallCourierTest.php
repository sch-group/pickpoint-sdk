<?php


namespace PickPointSdk\Tests;

use PickPointSdk\Components\CourierCall;

class CallCourierTest extends InitTest
{
    /**
     * PASS only with prod settings
     * @throws \PickPointSdk\Exceptions\PickPointMethodCallException
     * @throws \Exception
     */
    public function testCallCourier()
    {
        $senderDestination = $this->client->getSenderDestination();

        $courierCall = new CourierCall(
            $senderDestination->getCity(),
            $senderDestination->getCityId(),
            $senderDestination->getAddress(),
            'Тестов Тест',
            '+79274269594',
            new \DateTime('tomorrow + 1 day'),
            12 * 60, // from 12:00,
            17 * 60, // to 17:00
            1, // 500 заказов,
            1, // 10 кг
            'Это тестовый вызов, пожалуйста не приезжайте'
        );

        $callCourier = $this->client->callCourier($courierCall);

        $this->assertTrue(is_string($callCourier->getCallOrderNumber()));

        $cancelResponse = $this->client->cancelCourierCall($callCourier->getCallOrderNumber());

        $this->assertTrue($cancelResponse['Canceled']);

    }

    /**
     * @expectedException \PickPointMethodCallException
     * @throws \Exception
     */
    public function testCallCourierException()
    {
        $senderDestination = $this->client->getSenderDestination();

        $courierCall = new CourierCall(
            $senderDestination->getCity(),
            $senderDestination->getCityId(),
            $senderDestination->getAddress(),
            'Тестов Тест',
            '+79274269594',
            new \DateTime('now - 1 day'),
            12 * 60, // from 12:00,
            18 * 60, // to 17:00
            1, // 500 заказов,
            1, // 10 кг
            'Это тестовый вызов, пожалуйста не приезжайте'
        );
        $this->expectException(\PickPointSdk\Exceptions\PickPointMethodCallException::class);

        $callCourier = $this->client->callCourier($courierCall);
    }

}