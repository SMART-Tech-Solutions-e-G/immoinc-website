<?php

class Config
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function load($filepath)
    {
        $this->config = json_decode(file_get_contents($filepath));
    }

    public function get()
    {
        return $this->config;
    }
}