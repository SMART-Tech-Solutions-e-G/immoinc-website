<?php

require_once("Endpoint.php");

class DeleteRealEstateImage extends Endpoint
{
    public function render()
    {
        $realEstateAnnouncementId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        $imageId = isset($_POST["imageId"]) ? intval($_POST["imageId"]) : 0;

        $realEstateImage = Database::getInstance()->getRealEstateImage($imageId);


        unlink($_SERVER["DOCUMENT_ROOT"] . $realEstateImage->getPath());

        Database::getInstance()->deleteRealEstateImage($imageId);

        header("Location: /real-estate-announcements/edit?id=" . $realEstateAnnouncementId);
    }
}
