<?php

require_once("HTMLEndpointStart.php");

class StartEndpoint extends HTMLEndpointStart
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
            <select id="Place" name="standort">
                <?php
                if (!empty($array_real_estate)) {
                    foreach ($array_real_estate as $real_estate) {
                ?>

                        <option value="<?php
                                        echo $real_estate['address_city'] ?>" <?php if ($_GET['standort'] == $real_estate['address_city'])
                                                                                    echo 'selected' ?>>
                            <?php echo $real_estate['address_city']
                            ?> </option>;
                <?php
                    }
                }
                ?>
            </select>
            <input type="hidden" name="aktion" value="suchen">
            <input type="text" name="suchbegriff" id="suchbegriff" placeholder="Gewünschte Fläche">
            <input type="submit" value="Suchen">
        </form>

        <?php


        if (isset($_GET['suchbegriff']) and trim($_GET['suchbegriff']) != '') {
            
            $suchbegriff = trim($_GET['suchbegriff']);
            
            $suche_nach = "{$suchbegriff}";
            
            $suche = $connection->prepare("SELECT id, address_street, address_housenumber, living_space, address_city FROM real_estate WHERE living_space >= ? AND address_city = ?");

            $suche->bindParam(1, $suche_nach, PDO::PARAM_INT);
            $suche->bindParam(2, $_GET['standort']);

            $suche->execute();

            $daten = [];

            while ($row = $suche->fetch()) {
                array_push($daten, $row);
            }
        ?>
            <style>
                table,
                th,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
            </style>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Strasse</th>
                        <th>Hausnummer</th>
                        <th>Wohnort</th>
                        <th>Quadratmeter</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($daten as $inhalt) {
                    ?>
                        <tr>
                            <td><?php echo $inhalt['id'] ?></td>
                            <td><?php echo $inhalt['address_street'] ?></td>
                            <td><?php echo $inhalt['address_city'] ?></td>
                            <td><?php echo $inhalt['address_housenumber'] ?></td>
                            <td><?php echo $inhalt['living_space'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
<?php
        }
    }
}
