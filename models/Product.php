<?php

class Product
{
    private $id;
    private $name;
    private $quantity;
    private $price;
    private $imgUrl;
    private $description;

    // Constructor
    public function __construct($id, $name, $quantity, $price, $imgUrl, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imgUrl = $imgUrl;
        $this->description = $description;
    }

    public function isAvailableInStock()
    {
        // Verifica si hay suficiente cantidad disponible en stock
        return $this->quantity > 0;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}
