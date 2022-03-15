<?php

require '../vendor/autoload.php';

use RofiqDev\DurianPay\Http\Client as HttpClient;
use RofiqDev\DurianPay\Disbursement\Disbursement;
use RofiqDev\DurianPay\Disbursement\Items;

$httpClient = new HttpClient('dp_test_pfVvaBXtciKwmlTQ', true);
$disbursement = new Disbursement($httpClient);

/*
|--------------------------------------------------------------------------
| Fetch bank list
|--------------------------------------------------------------------------
*/

$response = $disbursement->fetchBankLists();


$data =  '-----+-----------+--------------------------' . PHP_EOL;
$data .= 'ID   | CODE      |  BANK NAME               ' . PHP_EOL;
$data .= '-----+-----------+--------------------------' . PHP_EOL;
foreach ($response->data as $key => $value) {
    $data .= $value->id . '   ' . $value->code . '   ' . $value->name.PHP_EOL;
}

file_put_contents('banks.txt', $data);

print_r($response);

/*
|--------------------------------------------------------------------------
| Top-up Amount
|--------------------------------------------------------------------------
*/

// ERROR: top-up not allowed in sandbox mode (Code: DPAY_INTERNAL_ERROR)
$response = $disbursement->topUp(16, 100000);

print_r($response);


/*
|--------------------------------------------------------------------------
| Fetch top-up detail by ID API
|--------------------------------------------------------------------------
*/

$topUpId = ''; // Bingung dapet dari mana.
$response = $disbursement->fetchTopUpDetailsById($topUpId);

print_r($response);


/*
|--------------------------------------------------------------------------
| Fetch durianpay balance API
|--------------------------------------------------------------------------
*/

// ERROR: merchant not configured properly with a provider in database. Please ensure is_active = TRUE
// $response = $disbursement->fetchDurianPayBalance();

// print_r($response);


/*
|--------------------------------------------------------------------------
| Submit Disbursement API
|--------------------------------------------------------------------------
*/

$name = 'Disbursement 1';
$description = 'Test disbursement 1';

$items = (new Items())
    ->add('Account 1', 'BRI', 100000, '1111111', 'account1@gmail.com', '0852111111', 'Untuk account 1')
    ->add('Account 2', 'BRI', 200000, '2222222', 'account2@gmail.com', '0852222222', 'Untuk account 2')
    ->add('Account 3', 'BRI', 300000, '3333333', 'account3@gmail.com', '0852333333', 'Untuk account 3');

$idempotencyKey = 'DISBTRX-00001';
$forceDisburse = false;

$response = $disbursement->submitDisbursement($name, $description, $items, $idempotencyKey, $forceDisburse);

print_r($response);
