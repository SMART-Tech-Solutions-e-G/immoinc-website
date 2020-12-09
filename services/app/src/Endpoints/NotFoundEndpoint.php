<?php

require_once("HTMLEndpoint.php");

class NotFoundEndpoint extends HTMLEndpoint
{
    public function render()
    {
?>
        <div class="wrapper">
            <div class="slim">
                <div class="slim-wrapper">
                    <h1>404 Fehler</h1>
                    <p>Die angeforderte Seite konnte nicht gefunden werden.</p>
                </div>
            </div>
        </div>
<?php
    }
}
