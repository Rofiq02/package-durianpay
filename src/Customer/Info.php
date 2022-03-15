<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Customer;

use RofiqDev\DurianPay\Order\Metadata;

class Info
{
    private $refId;
    private $givenName;
    private $email;
    private $mobile;
    private $customerId;

    private $address;
    private $metadata;

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    public function setRefId(string $refId)
    {
        $this->refId = $refId;
        return $this;
    }

    public function setGivenName(string $givenName)
    {
        $this->givenName = $givenName;
        return $this;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function setMobile(string $mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }

    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getRefId()
    {
        return $this->refId;
    }

    public function getGivenName()
    {
        return $this->givenName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function all()
    {
        return [
            'customer_ref_id' => $this->getRefId(),
            'given_name' => $this->getGivenName(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'id' => $this->getCustomerId(),
        ];
    }
}
