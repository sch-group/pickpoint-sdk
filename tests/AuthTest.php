<?php

namespace PickPointSdk\Tests;

use Matomo\Ini\IniReader;
use PickPointSdk\Components\SenderDestination;
use PickPointSdk\PickPoint\PickPointConf;
use PickPointSdk\PickPoint\PickPointConnector;

class AuthTest extends InitTest
{
    protected $pickPointConf;

    protected $client;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $reader = new IniReader();
        $config = $reader->readFile(__DIR__ . '/config.ini');
        $this->pickPointConf = new PickPointConf($config);
        $this->client = new PickPointConnector($this->pickPointConf, new SenderDestination($config['city_from'], $config['region_from']));
    }

    public function testPickPointAuthAndPostamatsGetting()
    {
        $postamats = $this->client->getPoints();
        $this->assertTrue(is_array($postamats));
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