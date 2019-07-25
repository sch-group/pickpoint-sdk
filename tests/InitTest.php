<?php

namespace PickPointSdk\Tests;

use Matomo\Ini\IniReader;
use PHPUnit\Framework\TestCase;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\SenderDestination;
use PickPointSdk\PickPoint\PickPointConf;
use PickPointSdk\PickPoint\PickPointConnector;

class InitTest extends TestCase
{
    /**
     * @var PickPointConf $pickPointConf
     */
    protected $pickPointConf;

    /**
     * @var PickPointConnector $client
     */
    protected $client;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $reader = new IniReader();
        $config = $reader->readFile(__DIR__ . '/config.ini');
        $this->pickPointConf = new PickPointConf($config);
        $defaultPackageSize = new PackageSize(20, 20,20);
        $senderDestination = new SenderDestination($config['city_from'], $config['region_from']);
//        $redisConf = [
//          'host' => $config['redis_host'],
//          'port' => $config['redis_port']
//        ];
        $this->client = new PickPointConnector($this->pickPointConf, $senderDestination, $defaultPackageSize);
    }

}