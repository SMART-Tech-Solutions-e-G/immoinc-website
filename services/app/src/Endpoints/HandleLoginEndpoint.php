<?php

require_once("Endpoint.php");

class HandleLoginEndpoint extends Endpoint
{
    public function render()
    {
        try {
            $user = Database::getInstance()->loginUser($_POST["email"], $_POST["password"]);
            $_SESSION["userId"] = $user->getId();
            header("Location: /admin/immolist");
        } catch (Exception $err) {
            header("Location: /login?error");
        }
    }
}
