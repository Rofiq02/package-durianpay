<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Disbursement;

class Items
{
    /**
     * Item basket.
     *
     * @var array
     */
    private $items = [];

    /**
     * Add an item.
     *
     * @param string      $accountOwnerName
     * @param string      $bankCode
     * @param int         $amount
     * @param string      $accountNumber
     * @param string      $emailRecipient
     * @param string      $phoneNumber
     * @param string|null $notes
     */
    public function add(
        string $accountOwnerName,
        string $bankCode,
        int $amount,
        string $accountNumber,
        string $emailRecipient,
        string $phoneNumber,
        string $notes = null
    ) {
        $this->items[] = [
            'account_owner_name' => $accountOwnerName,
            'bank_code' => $bankCode,
            'amount' => (string) $amount,
            'account_number' => $accountNumber,
            'email_recipient' => $emailRecipient,
            'phone_number' => $phoneNumber,
            'notes' => is_null($notes) ? '-' : $notes,
        ];

        return $this;
    }

    /**
     * Fetch all items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Check if item is empty.
     *
     * @return bool
     */
    public function empty()
    {
        return count($this->items) <= 0;
    }

    /**
     * Reset item basket.
     *
     * @return self
     */
    public function reset()
    {
        $this->items = [];

        return $this;
    }
}
