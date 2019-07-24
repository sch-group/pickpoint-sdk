API PICKPOINT CONNECTOR

```bash
composer require sch-group/pickpoint
```
Example 

$config = [
 'host' => '',
 'login' => '',
 'password' => '',
 'ikn' => '',
];    

$defaultPackageSize = new PackageSize(20, 20,20); // может быть null

$senderDestination = new SenderDestination('Москва', 'Московская обл.'); // Адрес отправителя

$client = new PickPointConnector(new PickPointConf($config), $senderDestination, $defaultPackageSize);
 
$points = $client->getPoints(); // получить массив поставматов

// Цены за доставку

$receiverDestination = new ReceiverDestination('Санкт-Петербург', 'Ленинградская обл.');

$prices = $client->calculatePrices($receiverDestination); // вернет массив с ценами и тарифами

$tariffPrice = $client->calculateObjectedPrices($receiverDestination); // Вернет объект с ценами

$commonStandardPrice = $tariffPrice->getStandardCommonPrice(); // получить общую цену с тарифом стандарт

// Создание отправления 

$invoice = new Invoice();

$invoice->setSenderCode('order: 123456');

$invoice->setPostamatNumber('5602-009');

$invoice->setDescription('Custom zakaz');

$invoice->setRecipientName('Айнур');

$invoice->setMobilePhone('+79274269594');

$invoice->setEmail('ainur_ahmetgalie@mail.ru');

$invoice->setPostageType('unpiad');

$invoice->setGettingType('sc');

$invoice->setSum(500.00);

$invoice->setDeliveryMode('standard');

$packageSize = new PackageSize(20, 20, 20);

$invoice->setPackageSize($packageSize);

$product = new Product();

$product->setDescription('Test product');

$product->setPrice(200);

$product->setQuantity(1);

$product->setName('Tovar 1');

$product->setProductCode('1231');

$invoice->setProducts([$product]);

$address = new Address();

$address->setCityName('Казань');

$address->setPhoneNumber('+79274269594');

$invoice->setClientReturnAddress($address);

$response = $this->client->createShipment($invoice);

