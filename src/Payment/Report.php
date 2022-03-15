<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Payment;

use RofiqDev\DurianPay\Http\Client as HttpClient;
use DateTime;
use DateTimeZone;

class Report
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
     * Fetch all created payment details.
     *
     * @param int $limit
     * @param int $skip
     *
     * @return \stdClass|false
     */
    public function fetchAll(DateTime $startDate, DateTime $endDate = null, int $limit = 25, int $skip = 0)
    {
        $endDate = is_null($endDate) ? new DateTime('now') : $endDate;
        $endDate = $endDate->setTimezone(new DateTimeZone('Asia/Jakarta'))->getTimestamp();
        $startDate = $startDate->setTimezone(new DateTimeZone('Asia/Jakarta'))->getTimestamp();

        if ($startDate > $endDate) {
            $this->httpClient->addError('Payment report fetchAll: startDate cannot be greater than endDate');
            return false;
        }

        $limit = ($limit < 1) ? 1 : $limit;
        $skip = ($skip < 0) ? 0 : $skip;

        $payloads = [
            'from' => $startDate,
            // 'to' => $endDate, // Kalo ada 'to' data gak keluar.
            'limit' => $limit,
            'skip' => $skip,
        ];

        $endpoint = 'payments';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Fetch spesific payment details.
     *
     * @param string $paymentId
     *
     * @return \stdClass|false
     */
    public function fetchById(string $paymentId)
    {
        $payloads = [];
        $endpoint = 'payments/' . $paymentId;
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Check payment status.
     *
     * @param string $paymentId
     *
     * @return \stdClass|false
     */
    public function checkPaymentStatus(string $paymentId)
    {
        $payloads = [];
        $endpoint = 'payments/' . $paymentId . '/status';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Verify a payment status.
     *
     * @param string $paymentId
     * @param string $verificationSignature
     *
     * @return \stdClass|false
     */
    public function verifyPayment(string $paymentId, string $verificationSignature)
    {
        $payloads = [
            'verification_signature' => $verificationSignature,
        ];

        $endpoint = 'payments/' . $paymentId . '/verify';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Cancel a payment.
     *
     * @param string $value
     *
     * @return \stdClass|false
     */
    public function cancelPayment(string $paymentId)
    {
        $payloads = [];
        $endpoint = 'payments/' . $paymentId . '/cancel';
        $headers = ['Content-Type' => 'application/json'];

        return $this->httpClient->put($endpoint, $payloads, $headers);
    }
}
