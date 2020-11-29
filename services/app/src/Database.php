<?php

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
    
}