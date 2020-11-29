<?php

require("Config.php");
require("Database.php");
require("Endpoints/HomeEndpoint.php");
require("Endpoints/StartEndpoint.php");

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

        switch ($path) {
            case "/":
                $endpoint = new HomeEndpoint();
                break;
        }
        switch ($path) {
            case "/start":
                $endpoint = new StartEndpoint();
                break;
        }

        if($endpoint != null) $endpoint->render();
        else {
            // File not found - replace with custom 404 page
            echo "Endpoint not found";
        }
    }
}