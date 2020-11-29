<?php

require_once("HTMLEndpoint.php");

class StartEndpoint extends HTMLEndpoint
{
    public function render()
    {
        $connection = Database::getInstance()->getConnection();
        $query = $connection->prepare("SELECT * FROM appartment");

        $query->execute();

        $array_appartment = [];

        while ($row = $query->fetch()) {
            array_push($array_appartment, $row);
        }

        $query = $connection->prepare("SELECT DISTINCT address_city FROM real_estate");

        $query->execute();

        $array_real_estate = [];

        while ($row = $query->fetch()) {
            array_push($array_real_estate, $row);
        }
        ?>

        <form action="" method="get">
            Jetzt nach Ihrer Traumimmobilie suchen!
            <select name="Standort">

                <?php

                foreach ($array_real_estate as $real_estate) {
                ?>
                    <option value=" <?php echo $real_estate['address_city'] ?> "> <?php echo $real_estate['address_city'] ?> </option> ;
                <?php
                }
                ?>
            </select>
            <input type="hidden" name="aktion" value="suchen">
            <input type="text" name="suchbegriff" id="suchbegriff">
            <input type="submit" value="suchen">
        </form>

        <?php
    }
}     