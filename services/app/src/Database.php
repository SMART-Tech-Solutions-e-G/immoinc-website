<?php

require_once("Models/User.php");

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

            if ($user->getPassword() != $password) throw new Exception("Password mismatch");

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
}
