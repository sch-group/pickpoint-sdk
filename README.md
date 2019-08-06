API PICKPOINT CONNECTOR

```bash
composer require sch-group/pickpoint
```
Примеры: 

Инициализация
```
$config = [
 'host' => '',
 'login' => '',
 'password' => '',
 'ikn' => '',
];    

$pickPointConf = new PickPointConf($config['host'], $config['login'], $config['password'], $config['ikn']);

$defaultPackageSize = new PackageSize(20, 20,20); // может быть null

$senderDestination = new SenderDestination('Москва', 'Московская обл.'); // Адрес отправителя

$client = new PickPointConnector($pickPointConf, $senderDestination, $defaultPackageSize);
 
 
Так же можно добавить кэширование, для ускорения запроса на авторизацию 
$redisCacheConf = [
 'host' => '127.0.0.1',
 'port' => 6379
];

$client = new PickPointConnector($pickPointConf, $senderDestination, $defaultPackageSize, $redisCacheConf);

 
```

Получение массива постаматов

```
$points = $client->getPoints(); // get postamats list

```
Цены за доставку

```
$receiverDestination = new ReceiverDestination('Санкт-Петербург', 'Ленинградская обл.');

$prices = $client->calculatePrices($receiverDestination); // вернет массив с ценами и тарифами

$tariffPrice = $client->calculateObjectedPrices($receiverDestination); // Вернет объект с ценами

$commonStandardPrice = $tariffPrice->getStandardCommonPrice(); // получить общую цену с тарифом стандарт
```
Создание отправления 
```
$invoice = new Invoice();
$invoice->setSenderCode('order: 123456');
$invoice->setPostamatNumber('5602-009');
$invoice->setDescription('Custom zakaz');
$invoice->setRecipientName('Саша');
$invoice->setMobilePhone('+79274269590');
$invoice->setEmail('kek@mail.ru');
$invoice->setPostageType('unpiad'); // paid or unpaid
$invoice->setGettingType('sc'); // courier or sc
$invoice->setSum(500.00);
$invoice->setDeliveryMode('standard'); // stanadard or priority
$packageSize = new PackageSize(20, 20, 20);
$invoice->setPackageSize($packageSize);

$product = new Product('number 234', 'Test', 2, 100);

$address = new Address();
$address->setCityName('Казань');
$address->setPhoneNumber('+79274269590');
$invoice->setClientReturnAddress($address);
$response = $client->createShipment($invoice);
```
Печать наклейки
```
$invoice = $client->createShipmentWithInvoice($invoice);
$invoiceNumber = $invoice->getInvoiceNumber();
$pdfByteCode = $client->printLabel(array($invoiceNumber));
```
Создание реестра и печать
```
$invoice = $client->createShipmentWithInvoice($invoice);
$invoiceNumber = $invoice->getInvoiceNumber();

$reestr = $client->makeReceipt(array($invoiceNumber));
$pdfByteCode = $client->rintReceipt($reestr[0]);

```
Одновременное создание реестра и печать
```
$invoice = $client->createShipmentWithInvoice($invoice);
$invoiceNumber = $invoice->getInvoiceNumber();
$pdfByteCode = $client->makeReceiptAndPrint(array($invoiceNumber));
```
Удалить инвойс из реестра
```
 $remove = $client->removeInvoiceFromReceipt($invoiceNumber);
```
Проверка статуса отправлений

```
$invoiceNumber = $invoice->getInvoiceNumber();
$status = $client->getStatus($invoiceNumber);
$status->getState();
$status->getStateText();
```
Получить все статусы

```
$states = $client->getStates();
```

Отмена отправления 

```
$senderCode = $invoice->getSenderCode(); // order id
$cancelResponse = $client->cancelInvoice($invoiceNumber);
или 
$cancelResponse = $client->cancelInvoice('', $senderCode); // отмена с собственным id заказа

```
Информация об отправлении 

```
$response = $client->shipmentInfo($invoiceNumber);
$response = $client->shipmentInfo('', $senderCode);
```
Вызов курьера

```
$senderDestination = new SenderDestination('Москва', 'Московская обл.', '', 992); 

$courierCall = new CourierCall(
    $senderDestination->getCity(),
    $senderDestination->getCityId(),
    $senderDestination->getAddress(),
   'Тестов Тест',
    '+79274269594',
    new \DateTime('tomorrow + 1 day'),
    12 * 60, // from 12:00,
    17 * 60, // to 17:00
    1, // 1 заказ,
    1, // 10 кг
    'Это тестовый вызов, пожалуйста не приезжайте'
 );

$callCourier = $client->callCourier($courierCall);
$courierOrderNumber = $callCourier->getCallOrderNumber();
```
Отмена вызова курьера
```

$cancelResponse = $client->cancelCourierCall($courierOrderNumber);

```

