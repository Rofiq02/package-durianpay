<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Disbursement;

use RofiqDev\DurianPay\Http\Client as HttpClient;

class Disbursement
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
     * Retrieves the list of banks.
     *
     * @return \stdClass|false
     */
    public function fetchBankLists()
    {
        $endpoint = 'disbursements/banks';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Do a top-up amount to durianpay account.
     *
     * @param int $bankId
     * @param int $amount
     *
     * @return \stdClass|false
     */
    public function topUp(int $bankId, int $amount)
    {
        $endpoint = 'disbursements/topup';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [
            'bank_id' => $bankId,
            'amount' => (string) $amount,
        ];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Retrieves the details of the top-up created by ID.
     *
     * @param string $topUpId
     *
     * @return \stdClass|false
     */
    public function fetchTopUpDetailsById(string $topUpId)
    {
        $endpoint = 'disbursements/topup/' . $topUpId;
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Retrieves the balance in the durianpay account.
     *
     * @return \stdClass|false
     */
    public function fetchDurianPayBalance()
    {
        $endpoint = 'disbursements/topup/balance';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }
    /**
     * Rubmit a disbursement.
     *
     * @param string $name
     * @param string $description
     * @param Items  $items
     * @param string $idempotencyKey
     * @param bool   $forceDisburse
     *
     * @return \stdClass|false
     */
    public function submitDisbursement(
        string $name,
        string $description,
        Items $items,
        string $idempotencyKey,
        bool $forceDisburse = false
    ) {
        $forceDisburse = $forceDisburse ? 'true' : 'false';
        $endpoint = 'disbursements/submit?force_disburse=' . $forceDisburse;
        $headers = [
            'Content-Type' => 'application/json',
            'idempotency_key' => $idempotencyKey,
        ];

        $payloads = [
            'name' => $name,
            'description' => $description,
            'items' => $items->all(),
        ];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Approves a disbursement.
     *
     * @param string $disbursementId
     * @param bool   $ignoreInvalid
     *
     * @return \stdClass|false
     */
    public function approveDisbursement(string $disbursementId, bool $ignoreInvalid = false)
    {
        $ignoreInvalid = $ignoreInvalid ? 'true' : 'false';
        $endpoint = 'disbursements/' . $disbursementId. '/approve?ignore_invalid=' . $ignoreInvalid;
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }

    /**
     * Retrieves the details of disbursement items created.
     *
     * @param string $disbursementId
     *
     * @return \stdClass|false
     */
    public function fetchDisbursementItemsById(string $disbursementId)
    {
        $endpoint = 'disbursements/' . $disbursementId . '/items';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Retrieves the details of the disbursement created.
     *
     * @param string $disbursementId
     *
     * @return \stdClass|false
     */
    public function fetchDisbursementById(string $disbursementId)
    {
        $endpoint = 'disbursements/' . $disbursementId;
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->get($endpoint, $payloads, $headers);
    }

    /**
     * Deletes a disbursement.
     *
     * @param string $disbursementId
     *
     * @return \stdClass|false
     */
    public function deleteDisbursementById(string $disbursementId)
    {
        $endpoint = 'disbursements/' . $disbursementId;
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [];

        return $this->httpClient->delete($endpoint, $payloads, $headers);
    }

    /**
     * Fetch the bank account and account number validation.
     *
     * @param string $accountNumber
     * @param string $bankCode
     *
     * @return \stdClass|false
     */
    public function validateAccount(string $accountNumber, string $bankCode)
    {
        $endpoint = 'disbursements/validate';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [
            'account_number' => $accountNumber,
            'bank_code' => $bankCode,
        ];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }
}
