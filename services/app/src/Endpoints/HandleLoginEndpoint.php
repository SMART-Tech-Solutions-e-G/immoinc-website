<?php

require_once("Endpoint.php");

class HandleLoginEndpoint extends Endpoint
{
    public function render()
    {
        $email = "";
        $password = "";

        if (isset($_POST["email"])) $email = $_POST["email"];
        if (isset($_POST["password"])) $password = $_POST["password"];

        try {
            $user = Database::getInstance()->loginUser($email, $password);
            $_SESSION["userId"] = $user->getId();
            header("Location: /admin/immolist");
        } catch (Exception $err) {
            header("Location: /login?error&email=" . urlencode($email));
        }
    }
}
