<?php

require_once("HTMLEndpoint.php");

class LoginEndpoint extends HTMLEndpoint
{
    public function render() {
        if(isset($_POST)) {
            echo "Login erfolgreich";
        } else {
?>
<form method="POST">
    <input type="email">
    <input type="password">
    <input type="submit" value="Login">
</form>
<?php
        }
    }
}