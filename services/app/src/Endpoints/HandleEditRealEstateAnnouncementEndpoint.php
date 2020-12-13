<?php

require_once("Endpoint.php");

class HandleEditRealEstateAnnouncementEndpoint extends Endpoint
{
    public function render()
    {
        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");

        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
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

        $constructionYear = isset($_POST["constructionYear"]) ? intval($_POST["constructionYear"]) : null;
        $floor = isset($_POST["floor"]) ? intval($_POST["floor"]) : null;



        if ($id !== null) Database::getInstance()->editRealEstateAnnouncement($id, $ownershipLevel, $price, $addressStreet, $addressHousenumber, $addressZipCode, $addressCity, $livingSpace, $roomCount, $freeFrom, $description, $constructionYear, $floor);

        header("Location: ?id=" . $id);
    }
}
