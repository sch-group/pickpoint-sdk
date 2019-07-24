<?php

namespace PickPointSdk\Tests;

use PickPointSdk\Components\SenderDestination;
use PickPointSdk\PickPoint\PickPointConf;
use PickPointSdk\PickPoint\PickPointConnector;

class AuthTest extends InitTest
{
    protected $client;

    public function testPickPointAuthAndPostamatsGetting()
    {
        $points = $this->client->getPoints();
        $this->assertTrue(is_array($points));
        $this->assertNotEmpty($points[0]['Region']);
    }
    /**
     * @expectedException \PickPointSdk\Exceptions\PickPointMethodCallException
     */
    public function testAuthException()
    {
        $client = new PickPointConnector(new PickPointConf([]), new SenderDestination('',''));
        $client->getPoints();
        $this->expectException(\PickPointSdk\Exceptions\PickPointMethodCallException::class);
    }
}