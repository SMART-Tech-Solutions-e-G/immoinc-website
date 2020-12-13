<?php

require_once("Endpoint.php");

class HandleCreateRealEstateAnnouncementEndpoint extends Endpoint
{
    public function render()
    {
        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");

        $ownershipLevel = isset($_POST["ownershipLevel"]) ? (intval($_POST["ownershipLevel"]) === 1 ? 1 : 0) : null;
        $price = isset($_POST["price"]) ? doubleval($_POST["price"]) : null;
        $addressStreet = isset($_POST["addressStreet"]) ? $_POST["addressStreet"] : null;
        $addressHousenumber = isset($_POST["addressHousenumber"]) ? $_POST["addressHousenumber"] : null;
        $addressZipCode = isset($_POST["addressZipCode"]) ? $_POST["addressZipCode"] : null;
        $addressCity = isset($_POST["addressCity"]) ? $_POST["addressCity"] : null;
        $livingSpace = isset($_POST["livingSpace"]) ? doubleval($_POST["livingSpace"]) : null;
        $roomCount = isset($_POST["roomCount"]) ? intval($_POST["roomCount"]) : null;
        $freeFrom = isset($_POST["freeFromDate"]) && isset($_POST["freeFromOption"]) && intval($_POST["freeFromOption"]) === 1 ? date("Y-m-d", strtotime($_POST["freeFromDate"])) : null;
        $description = isset($_POST["description"]) ? $_POST["description"] : null;

        $type = isset($_POST["type"]) ? $_POST["type"] : null;

        $constructionYear = isset($_POST["constructionYear"]) ? intval($_POST["constructionYear"]) : null;
        $floor = isset($_POST["floor"]) ? intval($_POST["floor"]) : null;


        $realEstateAnnouncement = new RealEstateAnnouncment();
        $realEstateAnnouncement->setOwnershipLevel($ownershipLevel);
        $realEstateAnnouncement->setPrice($price);
        $realEstateAnnouncement->setFreeFrom($freeFrom);

        $realEstate = null;

        switch ($type) {
            case "house":
                $realEstate = new House();
                $realEstate->setConstructionYear($constructionYear);
                break;
            case "appartment":
                $realEstate = new Appartment();
                $realEstate->setFloor($floor);
                break;
        }

        $realEstate->setAddressStreet($addressStreet);
        $realEstate->setAddressHousenumber($addressHousenumber);
        $realEstate->setAddressZipCode($addressZipCode);
        $realEstate->setAddressCity($addressCity);
        $realEstate->setLivingSpace($livingSpace);
        $realEstate->setRoomCount($roomCount);
        $realEstate->setDescription($description);

        $realEstateAnnouncement->setRealEstate($realEstate);

        $realEstateAnnouncement = Database::getInstance()->createRealEstateAnnouncement($realEstateAnnouncement);

        header("Location: edit?id=" . $realEstateAnnouncement->getId());
    }
}
