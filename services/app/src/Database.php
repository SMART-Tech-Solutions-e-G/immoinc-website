<?php

require_once("Models/User.php");
require_once("Models/RealEstateAnnouncement.php");
require_once("Models/Appartment.php");
require_once("Models/House.php");
require_once("Models/RealEstateImage.php");


class Database
{
    private static $instance;
    private $connection;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function connect($host, $username, $password, $database)
    {
        $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        $this->connection = null;
    }

    public function loginUser($email, $password)
    {
        $query = $this->connection->prepare("SELECT id, firstname, lastname, email, password FROM user WHERE email = :email");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();

        $row = $query->fetch();

        if ($row) {
            $user = new User();

            $user->setId($row["id"]);
            $user->setFirstname($row["firstname"]);
            $user->setLastname($row["lastname"]);
            $user->setEmail($row["email"]);
            $user->setPassword($row["password"]);

            if (password_verify($password, $user->getPassword()) === false) throw new Exception("Password mismatch");

            return $user;
        } else throw new Exception("Could not find user");
    }

    public function getUser($id)
    {
        $query = $this->connection->prepare("SELECT id, firstname, lastname, email, password FROM user WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch();

        if ($row) {
            $user = new User();

            $user->setId($row["id"]);
            $user->setFirstname($row["firstname"]);
            $user->setLastname($row["lastname"]);
            $user->setEmail($row["email"]);
            $user->setPassword($row["password"]);
            return $user;
        } else throw new Exception("Could not find user");
    }

    public function getRealEstateAnnouncement($id)
    {
        $query = $this->connection->prepare("SELECT real_estate_announcement.id AS real_estate_announcement_id, ownership_level, ownership_level, price, free_from, real_estate.id AS real_estate_id, address_street, address_housenumber, address_zip_code, address_city, living_space, room_count, type, description, creation_date, construction_year, floor FROM real_estate_announcement INNER JOIN real_estate ON real_estate.id = real_estate_announcement.real_estate_id LEFT JOIN house ON real_estate.id = house.real_estate_id LEFT JOIN appartment ON real_estate.id = appartment.real_estate_id WHERE real_estate_announcement.id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch();

        if ($row) {
            $realEstateAnnouncement = new RealEstateAnnouncment();
            $realEstateAnnouncement->setId($row["real_estate_announcement_id"]);
            $realEstateAnnouncement->setOwnershipLevel(intval($row["ownership_level"]));
            $realEstateAnnouncement->setPrice(doubleval($row["price"]));
            if ($row["free_from"] != null) $realEstateAnnouncement->setFreeFrom(new DateTime($row["free_from"]));

            $realEstate = null;

            switch ($row["type"]) {
                case "house":
                    $realEstate = new House();
                    $realEstate->setConstructionYear($row["construction_year"]);
                    break;
                case "appartment":
                    $realEstate = new Appartment();
                    $realEstate->setFloor($row["floor"]);
                    break;
                default:
                    $realEstate = new RealEstate();
            }

            $realEstate->setId($row["real_estate_id"]);
            $realEstate->setAddressStreet($row["address_street"]);
            $realEstate->setAddressHousenumber($row["address_housenumber"]);
            $realEstate->setAddressZipCode($row["address_zip_code"]);
            $realEstate->setAddressCity($row["address_city"]);
            $realEstate->setLivingSpace($row["living_space"]);
            $realEstate->setRoomCount($row["room_count"]);
            $realEstate->setDescription($row["description"]);
            $realEstate->setCreationDate(new DateTime($row["creation_date"]));

            $realEstateId = $realEstate->getId();

            $query = $this->connection->prepare("SELECT id, path FROM real_estate_image WHERE real_estate_id = :id");
            $query->bindParam(":id", $realEstateId, PDO::PARAM_INT);
            $query->execute();

            $images = [];

            while ($row = $query->fetch()) {
                $image = new RealEstateImage();
                $image->setId($row["id"]);
                $image->setPath($row["path"]);
                array_push($images, $image);
            }

            $realEstate->setImages($images);
            $realEstateAnnouncement->setRealEstate($realEstate);

            return $realEstateAnnouncement;
        } else throw new Exception("Could not find real estate announcement");
    }


    public function getAllCities()
    {
        $query = $this->connection->prepare("SELECT DISTINCT address_city AS city FROM real_estate INNER JOIN real_estate_announcement ON real_estate_announcement.real_estate_id = real_estate.id");
        $query->execute();

        $cities = [];

        while ($row = $query->fetch()) {
            array_push($cities, $row["city"]);
        }

        return $cities;
    }

    public function searchRealEstateAnnouncements($livingSpaceMin = 0, $livingSpaceMax = 10000, $city = null, $type = null, $ownershipLevel = null, $sortOption = "creation_date")
    {
        $sortOptions = ["living_space", "price", "free_from", "creation_date", "room_count"];
        if (!in_array($sortOption, $sortOptions)) $sortOption = "creation_date";

        $query = $this->connection->prepare("SELECT real_estate_announcement.id AS real_estate_announcement_id, ownership_level, ownership_level, price, free_from, real_estate.id AS real_estate_id, address_street, address_housenumber, address_zip_code, address_city, living_space, room_count, type, description, creation_date, construction_year, floor FROM real_estate_announcement INNER JOIN real_estate ON real_estate.id = real_estate_announcement.real_estate_id LEFT JOIN house ON real_estate.id = house.real_estate_id LEFT JOIN appartment ON real_estate.id = appartment.real_estate_id WHERE living_space >= ? AND living_space <= ? AND (address_city = ? OR ? IS NULL) AND (type = ? OR ? IS NULL) AND (ownership_level = ? OR ? IS NULL) ORDER BY $sortOption DESC");
        $query->bindParam(1, $livingSpaceMin, PDO::PARAM_INT);
        $query->bindParam(2, $livingSpaceMax, PDO::PARAM_INT);
        $query->bindParam(3, $city, PDO::PARAM_STR);
        $query->bindParam(4, $city, PDO::PARAM_STR);
        $query->bindParam(5, $type, PDO::PARAM_STR);
        $query->bindParam(6, $type, PDO::PARAM_STR);
        $query->bindParam(7, $ownershipLevel, PDO::PARAM_INT);
        $query->bindParam(8, $ownershipLevel, PDO::PARAM_INT);
        $query->execute();

        $realEstateAnnouncements = [];

        while ($row = $query->fetch()) {
            $realEstateAnnouncement = new RealEstateAnnouncment();
            $realEstateAnnouncement->setId($row["real_estate_announcement_id"]);
            $realEstateAnnouncement->setOwnershipLevel(intval($row["ownership_level"]));
            $realEstateAnnouncement->setPrice(doubleval($row["price"]));
            if ($row["free_from"] != null) $realEstateAnnouncement->setFreeFrom(new DateTime($row["free_from"]));

            $realEstate = null;

            switch ($row["type"]) {
                case "house":
                    $realEstate = new House();
                    $realEstate->setConstructionYear($row["construction_year"]);
                    break;
                case "appartment":
                    $realEstate = new Appartment();
                    $realEstate->setFloor($row["floor"]);
                    break;
                default:
                    $realEstate = new RealEstate();
            }

            $realEstate->setId($row["real_estate_id"]);
            $realEstate->setAddressStreet($row["address_street"]);
            $realEstate->setAddressHousenumber($row["address_housenumber"]);
            $realEstate->setAddressZipCode($row["address_zip_code"]);
            $realEstate->setAddressCity($row["address_city"]);
            $realEstate->setLivingSpace($row["living_space"]);
            $realEstate->setRoomCount($row["room_count"]);
            $realEstate->setDescription($row["description"]);
            $realEstate->setCreationDate(new DateTime($row["creation_date"]));

            $realEstateAnnouncement->setRealEstate($realEstate);

            array_push($realEstateAnnouncements, $realEstateAnnouncement);
        }

        foreach ($realEstateAnnouncements as $realEstateAnnouncement) {
            $realEstateId = $realEstateAnnouncement->getRealEstate()->getId();
            $query = $this->connection->prepare("SELECT id, path FROM real_estate_image WHERE real_estate_id = :id");
            $query->bindParam(":id", $realEstateId, PDO::PARAM_INT);
            $query->execute();

            $images = [];

            while ($row = $query->fetch()) {
                $image = new RealEstateImage();
                $image->setId($row["id"]);
                $image->setPath($row["path"]);
                array_push($images, $image);
            }

            $realEstateAnnouncement->getRealEstate()->setImages($images);
        }

        return $realEstateAnnouncements;
    }

    public function createRealEstateAnnouncement($realEstateAnnouncement)
    {
        //$this->connection->beginTransaction();

        $addressStreet = $realEstateAnnouncement->getRealEstate()->getAddressStreet();
        $addressHousenumber = $realEstateAnnouncement->getRealEstate()->getAddressHousenumber();
        $addresseZipCode = $realEstateAnnouncement->getRealEstate()->getAddressZipCode();
        $addressCity = $realEstateAnnouncement->getRealEstate()->getAddressCity();
        $livingSpace = $realEstateAnnouncement->getRealEstate()->getLivingSpace();
        $roomCount = $realEstateAnnouncement->getRealEstate()->getRoomCount();
        $description = $realEstateAnnouncement->getRealEstate()->getDescription();
        $type = null;

        if ($realEstateAnnouncement->getRealEstate() instanceof House) {
            $type = "house";
        } else if ($realEstateAnnouncement->getRealEstate() instanceof Appartment) {
            $type = "appartment";
        }

        $query = $this->connection->prepare("INSERT INTO real_estate (address_street, address_housenumber, address_zip_code, address_city, living_space, room_count, type, description, creation_date) VALUES(:address_street, :address_housenumber, :address_zip_code, :address_city, :living_space, :room_count, :type, :description, NOW())");
        $query->bindParam(":address_street", $addressStreet, PDO::PARAM_STR);
        $query->bindParam(":address_housenumber", $addressHousenumber, PDO::PARAM_STR);
        $query->bindParam(":address_zip_code", $addresseZipCode, PDO::PARAM_STR);
        $query->bindParam(":address_city", $addressCity, PDO::PARAM_STR);
        $query->bindParam(":living_space", $livingSpace, PDO::PARAM_INT);
        $query->bindParam(":room_count", $roomCount, PDO::PARAM_INT);
        $query->bindParam(":type", $type, PDO::PARAM_STR);
        $query->bindParam(":description", $description, PDO::PARAM_STR);
        $query->execute();

        $realEstateId = $this->connection->lastInsertId();
        $realEstateAnnouncement->getRealEstate()->setId($realEstateId);

        if ($realEstateAnnouncement->getRealEstate() instanceof House) {
            $constructionYear = $realEstateAnnouncement->getRealEstate()->getConstructionYear();
            $query =  $this->connection->prepare("INSERT INTO house (real_estate_id, construction_year) VALUES(:real_estate_id, :construction_year)");
            $query->bindParam(":real_estate_id", $realEstateId, PDO::PARAM_INT);
            $query->bindParam(":construction_year", $constructionYear, PDO::PARAM_INT);
            $query->execute();
        } else if ($realEstateAnnouncement->getRealEstate() instanceof Appartment) {
            $floor = $realEstateAnnouncement->getRealEstate()->getFloor();
            $query =  $this->connection->prepare("INSERT INTO appartment (real_estate_id, floor) VALUES(:real_estate_id, :floor)");
            $query->bindParam(":real_estate_id", $realEstateId, PDO::PARAM_INT);
            $query->bindParam(":floor", $floor, PDO::PARAM_INT);
            $query->execute();
        }

        $ownershipLevel = $realEstateAnnouncement->getOwnershipLevel();
        $price = $realEstateAnnouncement->getPrice();
        $freeFrom = $realEstateAnnouncement->getFreeFrom();

        $query = $this->connection->prepare("INSERT INTO real_estate_announcement (real_estate_id, ownership_level, price, free_from) VALUES(:real_estate_id, :ownership_level, :price, :free_from)");
        $query->bindParam(":real_estate_id", $realEstateId, PDO::PARAM_INT);
        $query->bindParam(":ownership_level", $ownershipLevel, PDO::PARAM_INT);
        $query->bindParam(":price", $price, PDO::PARAM_INT);
        $query->bindParam(":free_from", $freeFrom, PDO::PARAM_STR);
        $query->execute();

        $realEstateAnnouncement->setId($this->connection->lastInsertId());

        //$this->connection->commit();

        return $realEstateAnnouncement;
    }

    public function editRealEstateAnnouncement($id, $ownershipLevel, $price, $addressStreet, $addressHousenumber, $addresseZipCode, $addressCity, $livingSpace, $roomCount, $freeFrom, $description, $constructionYear = null, $floor = null)
    {

        //$this->connection->beginTransaction();

        $query = $this->connection->prepare("UPDATE real_estate_announcement SET ownership_level = :ownershipLevel, price = :price, free_from = :free_from WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->bindParam(":ownershipLevel", $ownershipLevel, PDO::PARAM_INT);
        $query->bindParam(":price", $price, PDO::PARAM_INT);
        $query->bindParam(":free_from", $freeFrom, PDO::PARAM_STR);
        $query->execute();

        $query = $this->connection->prepare("SELECT real_estate_id, type FROM real_estate_announcement INNER JOIN real_estate ON real_estate_announcement.real_estate_id = real_estate.id WHERE real_estate_announcement.id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch();
        if ($row == null) {
            $this->connection->rollBack();
            throw new Exception("Real estate announcement does not have a real_estate_referecened");
        }

        $realEstateId = $row["real_estate_id"];
        $realEstateType = $row["type"];

        $query = $this->connection->prepare("UPDATE real_estate SET address_street = :address_street, address_housenumber = :address_housenumber, address_zip_code = :address_zip_code, address_city = :address_city, living_space = :living_space, room_count = :room_count, description = :description WHERE id = :id");
        $query->bindParam(":id", $realEstateId, PDO::PARAM_INT);
        $query->bindParam(":address_street", $addressStreet, PDO::PARAM_STR);
        $query->bindParam(":address_housenumber", $addressHousenumber, PDO::PARAM_STR);
        $query->bindParam(":address_zip_code", $addresseZipCode, PDO::PARAM_STR);
        $query->bindParam(":address_city", $addressCity, PDO::PARAM_STR);
        $query->bindParam(":living_space", $livingSpace, PDO::PARAM_INT);
        $query->bindParam(":room_count", $roomCount, PDO::PARAM_INT);
        $query->bindParam(":description", $description, PDO::PARAM_STR);
        $query->execute();


        if ($realEstateType == "house") {
            $query = $this->connection->prepare("UPDATE house SET construction_year = :constructon_year WHERE real_estate_id = :id");
            $query->bindParam(":id", $realEstateId, PDO::PARAM_INT);
            $query->bindParam(":constructon_year", $constructionYear, PDO::PARAM_INT);
            $query->execute();
        } else if ($realEstateType == "appartment") {
            $query = $this->connection->prepare("UPDATE appartment SET floor = :floor WHERE real_estate_id = :id");
            $query->bindParam(":id", $realEstateId, PDO::PARAM_INT);
            $query->bindParam(":floor", $floor, PDO::PARAM_INT);
            $query->execute();
        }

        //$this->connection->commit();
    }

    public function getRealEstateImage($id)
    {
        $query = $this->connection->prepare("SELECT id, path FROM real_estate_image WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch();

        if ($row) {
            $realEstateImage = new RealEstateImage();
            $realEstateImage->setId($row["id"]);
            $realEstateImage->setPath($row["path"]);

            return $realEstateImage;
        } else throw new Exception("Image does not exist");
    }

    public function createRealEstateImage($realEstateId, $path)
    {
        $query = $this->connection->prepare("INSERT INTO real_estate_image (real_estate_id, path) VALUES(:real_estate_id, :path)");
        $query->bindParam(":real_estate_id", $realEstateId, PDO::PARAM_INT);
        $query->bindParam(":path", $path, PDO::PARAM_STR);
        $query->execute();
    }

    public function deleteRealEstateImage($id)
    {
        $query = $this->connection->prepare("DELETE FROM real_estate_image WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
    }
}
