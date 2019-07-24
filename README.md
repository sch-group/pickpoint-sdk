API PICKPOINT CONNECTOR

```bash
composer require sch-group/pickpoint
```
Примеры: 

```
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
$invoice->setRecipientName('Айнур');
$invoice->setMobilePhone('+79274269594');
$invoice->setEmail('ainur_ahmetgalie@mail.ru');
$invoice->setPostageType('unpiad'); // paid or unpaid
$invoice->setGettingType('sc'); // courier or sc
$invoice->setSum(500.00);
$invoice->setDeliveryMode('standard'); // stanadard or priority
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
$pdfByteCode = $this->client->makeReceiptAndPrint(array($invoiceNumber));
```
Проверка статуса отправлений

```
$invoiceNumber = $invoice->getInvoiceNumber();
$status = $client->getStatus($invoiceNumber);
```