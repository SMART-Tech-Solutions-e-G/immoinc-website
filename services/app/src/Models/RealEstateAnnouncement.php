<?php

class RealEstateAnnouncment
{
    private $id;
    private $ownershipLevel;
    private $price;
    private $freeFrom;
    private $realEstate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getOwnershipLevel()
    {
        return $this->ownershipLevel;
    }

    public function setOwnershipLevel($ownershipLevel)
    {
        $this->ownershipLevel = $ownershipLevel;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getFreeFrom()
    {
        return $this->freeFrom;
    }

    public function setFreeFrom($freeFrom)
    {
        $this->freeFrom = $freeFrom;
    }

    public function getRealEstate()
    {
        return $this->realEstate;
    }

    public function setRealEstate($realEstate)
    {
        $this->realEstate = $realEstate;
    }
}
