<?php

require_once("Endpoint.php");

class UploadRealEstateImage extends Endpoint
{
    public function render()
    {
        $realEstateAnnouncementId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
        $realEstateAnnouncement = Database::getInstance()->getRealEstateAnnouncement($realEstateAnnouncementId);

        $realEstateId = $realEstateAnnouncement->getRealEstate()->getId();

        if (isset($_FILES["image"])) {
            if ($_FILES["image"]["size"] <= 1024 * 1024 * 10) { // images cannot be larger than 10 MB
                $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if ($fileExtension == "png" || $fileExtension == "jpg" || $fileExtension == "jpeg") {
                    $relativePath = "/assets/images/real-estate-images/" . md5(date("Y-m-d H:i:s.u") . bin2hex(random_bytes(5))) . "." . $fileExtension;
                    Database::getInstance()->createRealEstateImage($realEstateId, $relativePath);
                    $absolutePath = $_SERVER["DOCUMENT_ROOT"] . $relativePath;


                    if (!file_exists($absolutePath)) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $absolutePath);
                    } else {
                        throw new Exception("File at '" . $absolutePath . "' already exists.");
                    }
                } else {
                    throw new Exception("Your file is not an image");
                }
            } else {
                throw new Exception("Image exceeds more than 10 MB");
            }
        }

        header("Location: /real-estate-announcements/edit?id=" . $realEstateAnnouncementId);
    }
}
