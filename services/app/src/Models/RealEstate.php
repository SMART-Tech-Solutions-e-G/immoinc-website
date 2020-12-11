<?php

class RealEstate
{
    private $id;
    private $addressStreet;
    private $addressHousenumber;
    private $addressZipCode;
    private $addressCity;
    private $livingSpace;
    private $roomCount;
    private $description;
    private $creationDate;
    private $images;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAddressStreet()
    {
        return $this->addressStreet;
    }

    public function setAddressStreet($addressStreet)
    {
        $this->addressStreet = $addressStreet;
    }

    public function getAddressHousenumber()
    {
        return $this->addressHousenumber;
    }

    public function setAddressHousenumber($addressHousenumber)
    {
        $this->addressHousenumber = $addressHousenumber;
    }

    public function getAddressZipCode()
    {
        return $this->addressZipCode;
    }

    public function setAddressZipCode($addressZipCode)
    {
        $this->addressZipCode = $addressZipCode;
    }

    public function getAddressCity()
    {
        return $this->addressCity;
    }
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;
    }

    public function getLivingSpace()
    {
        return $this->livingSpace;
    }

    public function setLivingSpace($livingSpace)
    {
        $this->livingSpace = $livingSpace;
    }

    public function getRoomCount()
    {
        return $this->roomCount;
    }

    public function setRoomCount($roomCount)
    {
        $this->roomCount = $roomCount;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }
}
