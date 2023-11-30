<?php

class Order
{
    private $id;
    private $reference;
    private $date;
    private $total;
    private $userId;

    // Constructor
    public function __construct($id, $reference, $date, $total, $userId)
    {
        $this->id = $id;
        $this->reference = $reference;
        $this->date = $date;
        $this->total = $total;
        $this->userId = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}

?>
