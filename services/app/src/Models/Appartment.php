<?php

require_once("RealEstate.php");

class Appartment extends RealEstate
{
    private $floor;

    public function getFloor()
    {
        return $this->floor;
    }

    public function setFloor($floor)
    {
        $this->floor = $floor;
    }
}
