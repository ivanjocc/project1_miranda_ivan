<?php

class Address
{
    private $id;
    private $streetName;
    private $streetNumber;
    private $city;
    private $province;
    private $zipCode;
    private $country;

    // Constructor
    public function __construct($id, $streetName, $streetNumber, $city, $province, $zipCode, $country)
    {
        $this->id = $id;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->province = $province;
        $this->zipCode = $zipCode;
        $this->country = $country;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getStreetName()
    {
        return $this->streetName;
    }

    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }
}

?>
