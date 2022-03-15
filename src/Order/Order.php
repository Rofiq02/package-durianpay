<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Order;

use RofiqDev\DurianPay\Http\Client as HttpClient;
use RofiqDev\DurianPay\Customer\Info;
use RofiqDev\DurianPay\Customer\Address;

class Order
{
    /**
     * HTTP requestor client.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Customer basic info.
     *
     * @var CustomerInfo
     */
    private $customer;

    /**
     * Customer address info.
     *
     * @var CustomerAddress
     */
    private $address;

    /**
     * Constructor.
     *
     * @param HttpClient      $httpClient
     * @param CustomerInfo    $customer
     * @param CustomerAddress $address
     */
    public function __construct(HttpClient $httpClient, Info $customer, Address $address = null, Metadata $metadata = null)
    {
        $this->httpClient = $httpClient;
        $this->customer = $customer;
        $this->address = $address;
        $this->metadata = $metadata;
    }

    /**
     * Creates an order.
     *
     * @param string $orderRefId
     * @param Items  $items
     *
     * @return \stdClass|false
     */
    public function create(string $orderRefId, Items $items)
    {
        if ($items->empty()) {
            $this->httpClient->addError('Unable to create order: item is empty.');
            return false;
        }

        $all = $items->all();
        $amount = 0;

        foreach ($all as $item) {
            $amount += $item['price'] * $item['qty'];
        }

        $customer = $this->customer;
        $address = $this->address;
        $metadata = $this->metadata;

        $payloads = [
            'amount' => $amount.'.00',
            'payment_option' => 'full_payment',
            'currency' => 'IDR',
            'order_ref_id' => $orderRefId,
            'customer' => [
                'customer_ref_id' => $customer->getRefId(),
                'given_name' => $customer->getGivenName(),
                'email' => $customer->getEmail(),
                'mobile' => $customer->getMobile(),
            ],
            'items' => $items->all(),
        ];

        if (! is_null($address)) {
            $payloads['customer']['address'] =  [
                'receiver_name' => $address->getReceiverName(),
                'receiver_phone' => $address->getReceiverPhone(),
                'label' => $address->getLabel(),
                'address_line_1' => $address->getAddressLine1(),
                'address_line_2' => $address->getAddressLine2(),
                'city' => $address->getCity(),
                'region' => $address->getRegion(),
                'country' => $address->getCountry(),
                'postal_code' => $address->getPostalCode(),
                'landmark' => $address->getLandmark(),
            ];
        }

        if (! is_null($metadata)) {
            $payloads['metadata'] = $metadata->all();
        }

        $endpoint = 'orders';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Create an Instapay link.
     *
     * @param string       $orderRefId
     * @param int          $amount
     * @param CustomerInfo $customer
     *
     * @return \stdClass|false
     */
    public function createLink(string $orderRefId, int $amount, Info $customer)
    {
        $payloads = [
            'amount' => (string) $amount,
            'currency' => 'IDR',
            'order_ref_id' => $orderRefId,
            'is_payment_link' => true,
            'customer' => [
                'email' => $customer->getEmail(),
            ],
        ];

        $endpoint = 'orders';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }
}
