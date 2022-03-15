<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Payment;

use RofiqDev\DurianPay\Http\Client as HttpClient;
use RofiqDev\DurianPay\Customer\Info as CustomerInfo;

class Payment
{
    /**
     * HTTP requestor client.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Make a payment via Virtual Account.
     *
     * @param string $orderId
     * @param string $bankCode
     * @param string $name
     * @param int    $amount
     *
     * @return \stdClass|false
     */
    public function payVA(string $orderId, string $bankCode, string $name, int $amount)
    {
        $payloads = [
            'type' => 'VA',
            'request' => [
                'order_id' => $orderId,
                'bank_code' => $bankCode,
                'name' => $name, // Name Appear in ATM
                'amount' => (string) $amount,
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Make a payment via e-Wallet.
     *
     * @param string $orderId
     * @param int    $amount
     * @param string $mobile
     * @param string $walletType
     *
     * @return \stdClass|false
     */
    public function payEwallet(string $orderId, int $amount, string $mobile, string $walletType)
    {
        $payloads = [
            'type' => 'EWALLET',
            'request' => [
                'order_id' => $orderId,
                'amount' => (string) $amount,
                'mobile' => $mobile,
                'wallet_type' => $walletType,
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Make a payment via Retail Store.
     * Pass 'ALFAMART' or 'INDOMARET' into $bankCode.
     *
     * @param string $orderId
     * @param string $bankCode
     * @param string $name
     * @param int    $amount
     *
     * @return \stdClass|false
     */
    public function payRetailStore(string $orderId, string $bankCode, string $name, int $amount)
    {
        $payloads = [
            'type' => 'RETAILSTORE',
            'request' => [
                'order_id' => $orderId,
                'bank_code' => $bankCode,
                'name' => $name, // Name Appear in ATM
                'amount' => (string) $amount,
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Make a payment via Online Banking.
     *
     * @param string       $orderId
     * @param string       $type
     * @param string       $name
     * @param int          $amount
     * @param CustomerInfo $customer
     *
     * @return \stdClass|false
     */
    public function payOnlineBanking(string $orderId, string $type, string $name, int $amount, CustomerInfo $customer)
    {
        $endpoint = 'payments/charge';
        $payloads = [
            'type' => 'ONLINE_BANKING',
            'request' => [
                'order_id' => $orderId,
                'type' => $type,
                'amount' => $amount . '.00',
                'customer_info' => [
                    'email' => $customer->getEmail(),
                    'given_name' => $customer->getGivenName(),
                    'id' => $customer->getCustomerId(),
                ],
                'mobile' => $customer->getMobile(),
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    public function payBcaAggregator(string $orderId, string $name, int $amount, CustomerInfo $customer)
    {
        $payloads = [
            'type' => 'VA',
            'request' => [
                'order_id' => $orderId,
                'bank_code' => 'BCA',
                'name' => $name, // Name Appear in ATM
                'amount' => $amount . '.00',
                'customer_info' => [
                    'email' => $customer->getEmail(),
                    'given_name' => $customer->getGivenName(),
                    'id' => $customer->getCustomerId(),
                ],
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Make a payment via QRIS.
     *
     * @param string $orderId
     * @param int    $amount
     * @param string $mobile
     *
     * @return \stdClass|false
     */
    public function payQris(string $orderId, int $amount, string $mobile)
    {
        $payloads = [
            'type' => 'QRIS',
            'request' => [
                'order_id' => $orderId,
                'amount' => $amount . '.00',
                'mobile' => $mobile,
                'type' => 'QRIS',
            ],
        ];

        $endpoint = 'payments/charge';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }
}
