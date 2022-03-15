<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Customer;

class Address
{
    private $receiverName;
    private $receiverPhone;
    private $label;
    private $addressLine1;
    private $addressLine2;
    private $city;
    private $region;
    private $country;
    private $postalCode;
    private $landmark;

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    public function setReceiverName(string $receiverName)
    {
        $this->receiverName = $receiverName;
        return $this;
    }

    public function setReceiverPhone(string $receiverPhone)
    {
        $this->receiverPhone = $receiverPhone;
        return $this;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    public function setAddressLine1(string $addressLine1)
    {
        $this->addressLine1 = $addressLine1;
        return $this;
    }

    public function setAddressLine2(string $addressLine2)
    {
        $this->addressLine2 = $addressLine2;
        return $this;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }

    public function setRegion(string $region)
    {
        $this->region = $region;
        return $this;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
        return $this;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setLandmark(string $landmark)
    {
        $this->landmark = $landmark;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getReceiverName()
    {
        return $this->receiverName;
    }

    public function getReceiverPhone()
    {
        return $this->receiverPhone;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function getLandmark()
    {
        return $this->landmark;
    }

    public function all()
    {
        return [
            'receiver_name' => $this->getReceiverName(),
            'receiver_phone' => $this->getReceiverPhone(),
            'label' => $this->getLabel(),
            'address_line_1' => $this->getAddressLine1(),
            'address_line_2' => $this->getAddressLine2(),
            'city' => $this->getCity(),
            'region' => $this->getRegion(),
            'country' => $this->getCountry(),
            'landmark' => $this->getLandmark(),
        ];
    }
}
