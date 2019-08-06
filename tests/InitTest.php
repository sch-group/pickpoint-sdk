<?php

namespace PickPointSdk\Tests;

use Matomo\Ini\IniReader;
use PHPUnit\Framework\TestCase;
use PickPointSdk\Components\Invoice;
use PickPointSdk\Components\PackageSize;
use PickPointSdk\Components\Product;
use PickPointSdk\Components\SenderDestination;
use PickPointSdk\PickPoint\PickPointConf;
use PickPointSdk\PickPoint\PickPointConnector;

class InitTest extends TestCase
{
    /**
     * @var PickPointConnector $client
     */
    protected $client;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $reader = new IniReader();
        $config = $reader->readFile(__DIR__ . '/config.ini');
        $pickPointConf = new PickPointConf($config['host'], $config['login'], $config['password'], $config['ikn']);
        $defaultPackageSize = new PackageSize(20, 20,20);
        $senderDestination = new SenderDestination($config['city_from'], $config['region_from'], '', 1726, 'Чистопольская, 72 кв1');
        $redisConf = [
          'host' => $config['redis_host'],
          'port' => $config['redis_port']
        ];
        $this->client = new PickPointConnector($pickPointConf, $senderDestination, $defaultPackageSize, []);
    }

    protected function createInvoice() : Invoice
    {
        $senderCode = 'order:' .(new \DateTime('now'))->getTimestamp();
        $invoice = new Invoice();
        $invoice->setSenderCode($senderCode);
        $invoice->setPostamatNumber('5602-009');
        $invoice->setDescription('TEST TEST');
        $invoice->setRecipientName('TEST');
        $invoice->setMobilePhone('+79274269594');

        $invoice->setEmail('ainur_ahmetgalie@mail.ru');
        $invoice->setPostageType('unpiad');
        $invoice->setGettingType('sc');
        $invoice->setSum(10.00);
        $invoice->setDeliveryMode('priority');

        $packageSize = new PackageSize(20, 20, 20);
        $invoice->setPackageSize($packageSize);

        $product = new Product('number 234', 'Test', 2, 100);

        $invoice->setProducts([$product]);

        return $this->client->createShipmentWithInvoice($invoice);

    }

}