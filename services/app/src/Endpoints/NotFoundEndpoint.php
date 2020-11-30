<?php

require_once("HTMLEndpoint.php");

class NotFoundEndpoint extends HTMLEndpoint
{
    public function render()
    {
?>
        <h1>Seite konnte nicht gefunden werden</h1>
<?php
    }
}
