<?php

require '../vendor/autoload.php';

use RofiqDev\DurianPay\Http\Client as HttpClient;
use RofiqDev\DurianPay\Customer\Info;
use RofiqDev\DurianPay\Customer\Address;
use RofiqDev\DurianPay\Order\Items;
use RofiqDev\DurianPay\Order\Metadata;
use RofiqDev\DurianPay\Order\Order;
use RofiqDev\DurianPay\Order\Report;

/*
|--------------------------------------------------------------------------
| Create Order API
|--------------------------------------------------------------------------
*/

$httpClient = new HttpClient('dp_test_pfVvaBXtciKwmlTQ');

$address = (new Address())
    ->setReceiverName('Asep Balon')
    ->setReceiverPhone('6281234567890')
    ->setLabel('Rumah Asep')
    ->setAddressLine1('Jalan Buntu')
    ->setAddressLine2('Ngrambe')
    ->setCity('Ngawi')
    ->setRegion('Jawa Timur')
    ->setCountry('Indonesia')
    ->setPostalCode('12345')
    ->setLandmark('Lampu Merah Ngrambe');

$metadata = (new Metadata())
    ->set('foo', 'bar')
    ->set('baz', 'qux');

$customer = (new Info())
    ->setRefId('TRX-' . random_int(999, 99999))
    ->setGivenName('Tripay User')
    ->setEmail('tripay.user@gmail.com')
    ->setMobile('08521346571323')
    ->setAddress($address)
    ->setMetadata($metadata);

$order = new Order($httpClient, $customer, $address, $metadata);

$orderRefId = 'TRX-00000001';

$items = new Items();
$items->add('Sendal Jepit', 1, 20000, 'https://google.com/image.png')
    ->add('Sepatu Kuda', 6, 50000, 'https://google.com/image.png')
    ->add('Es Batu', 12, 2000, 'https://google.com/image.png')
    ->add('Bakso Cup', 4, 5000, 'https://google.com/image.png');

$response = $order->create($orderRefId, $items);

print_r($response);


/*
|--------------------------------------------------------------------------
| Orders Fetch API
|--------------------------------------------------------------------------
*/

$report = new Report($httpClient);

// Fetch all with start date, end date
$startDate = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$endDate = new DateTime('now + 2 days', new DateTimeZone('Asia/Jakarta'));

$response = $report->fetchAll($startDate, $endDate);

print_r($response);


// Fetch all with start date, end date, limit, skip
$limit = 30;
$skip = 10;

$response = $report->fetchAll($startDate, $endDate, $limit, $skip);

print_r($response);


// Fetch by ID
$orderId = 'ord_wUj30mpheQ5293';
$response = $report->fetchById($orderId);

print_r($response);

// Fetch by ID with expand
$orderId = 'ord_wUj30mpheQ5293';
$expands = ['customer', 'payments'];

$response = $report->fetchById($orderId, $expands);

print_r($response);


/*
|--------------------------------------------------------------------------
| Create Instapay/Payment Link API
|--------------------------------------------------------------------------
*/
$orderRefId = 'TRX-00000002';
$amount = 20000;

$response = $order->createLink($orderRefId, $amount, $customer);

print_r($response);
