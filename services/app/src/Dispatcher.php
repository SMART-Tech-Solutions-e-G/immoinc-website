<?php

session_start();

require("Config.php");
require("Database.php");
require("Endpoints/HTMLEndpoint.php");
require("Endpoints/StartEndpoint.php");
require("Endpoints/NotFoundEndpoint.php");
require("Endpoints/LoginEndpoint.php");
require("Endpoints/HandleLoginEndpoint.php");
require("Endpoints/DetailansichtEndpoint.php");
require("Endpoints/ImprintEndpoint.php");
require("Endpoints/SearchEndpoint.php");
require("Endpoints/EditRealEstateAnnouncementEndpoint.php");
require("Endpoints/HandleEditRealEstateAnnouncementEndpoint.php");
require("Endpoints/CreateRealEstateAnnouncementEndpoint.php");
require("Endpoints/HandleCreateRealEstateAnnouncementEndpoint.php");
require("Endpoints/UploadRealEstateImage.php");
require("Endpoints/DeleteRealEstateImage.php");
require("Endpoints/AdminEndpoint.php");


class Dispatcher
{
    private static $instance;

    public static function init()
    {
        if (self::$instance == null) {
            self::$instance = new Dispatcher();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $database = Database::getInstance();
        Config::getInstance()->load(__DIR__ . "/config.json");

        $config = Config::getInstance()->get();
        $database->connect($config->{"database"}->{"host"}, $config->{"database"}->{"username"}, $config->{"database"}->{"password"}, $config->{"database"}->{"database"});

        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        $endpoint = null;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            switch ($path) {
                case "/login":
                    $endpoint = new LoginEndpoint();
                    break;
                case "/imprint":
                    $endpoint = new ImprintEndpoint();
                    break;
                case "/search":
                    $endpoint = new SearchEndpoint();
                    break;
                case "/":
                    $endpoint = new StartEndpoint();
                    break;
                case "/detailansicht":
                    $endpoint = new DetailansichtEndpoint();
                    break;
                case "/real-estate-announcements/edit":
                    $endpoint = new EditRealEstateAnnouncementEndpoint();
                    break;
                case "/real-estate-announcements/create":
                    $endpoint = new CreateRealEstateAnnouncementEndpoint();
                    break;
                case "/real-estate-announcements":
                    $endpoint = new AdminEndpoint();
                    break;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            switch ($path) {
                case "/login":
                    $endpoint = new HandleLoginEndpoint();
                    break;
                case "/real-estate-announcements":
                    $endpoint = new AdminEndpoint();
                    break;
                case "/real-estate-announcements/edit":
                    $endpoint = new HandleEditRealEstateAnnouncementEndpoint();
                    break;
                case "/real-estate-announcements/create":
                    $endpoint = new HandleCreateRealEstateAnnouncementEndpoint();
                    break;
                case "/real-estate-announcements/images/upload":
                    $endpoint = new UploadRealEstateImage();
                    break;
                case "/real-estate-announcements/images/delete":
                    $endpoint = new DeleteRealEstateImage();
                    break;
            }
        }

        if ($endpoint == null) {
            http_response_code(404);
            $endpoint = new NotFoundEndpoint();
        }

        if ($endpoint instanceof HTMLEndpoint) $endpoint->_render();
        else if ($endpoint instanceof Endpoint) $endpoint->render();

        $database->close();
    }
}
