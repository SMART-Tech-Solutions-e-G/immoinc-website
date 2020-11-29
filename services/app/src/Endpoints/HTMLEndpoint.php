<?php

require("Endpoint.php");

abstract class HTMLEndpoint extends Endpoint
{
    public function _render()
    {

?>
        <html>

        <head>
            <?php
            foreach (glob(__DIR__ . "/../assets/css/*.css") as $filename) {
            ?>
                <style>
                    <?php echo file_get_contents($filename) ?>
                </style>
            <?php
            }
            ?>
        </head>

        <body>
            <div class="header">
                <a href="/" class="logo">
                    <img src="/assets/images/logo.svg">
                    <span class="name">Immo Inc.</span>
                </a>
                <div class="links">
                    <a href="/impressum" class="link">Impressum</a>
                    <?php
                    try {
                        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");
                        $user = Database::getInstance()->getUser($_SESSION["userId"]);
                    } catch (Exception $err) {
                    ?>
                        <a href="/login" class="link">Anmelden</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="content">
                <?php $this->render() ?>
            </div>
            <div class="footer"></div>
        </body>

        </html>
<?php
    }
}
