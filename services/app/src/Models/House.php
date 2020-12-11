<?php

require_once("RealEstate.php");

class House extends RealEstate
{
    private $constructionYear;

    public function getConstructionYear()
    {
        return $this->constructionYear;
    }

    public function setConstructionYear($constructionYear)
    {
        $this->constructionYear = $constructionYear;
    }
}
