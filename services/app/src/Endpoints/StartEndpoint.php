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
            <div class="text-field inline">
                <select class="input" name="city" id="test">

                    <?php

                    foreach ($array_real_estate as $real_estate) {
                    ?>
                        <option value=" <?php echo $real_estate['address_city'] ?> "> <?php echo $real_estate['address_city'] ?> </option> ;
                    <?php
                    }
                    ?>
                </select>
                <label for="test">Stadt</label>
            </div>
            <input type="hidden" name="aktion" value="suchen">
            <div class="text-field inline">
                <input class="input" type="text" name="suchbegriff" id="suchbegriff" placeholder=" " required>
                <label for="suchbegriff">Gewünschte fläche</label>
            </div>
            <input type="submit" value="Suchen">
        </form>

        <?php


        if (isset($_GET['suchbegriff']) and trim($_GET['suchbegriff']) != '') {
            $suchbegriff = trim($_GET['suchbegriff']);
            //  echo "<p>Gesucht wird nach: <b>$suchbegriff</b></p>";
            $suche_nach = "%{$suchbegriff}%";

            $suche = $connection->prepare("SELECT id, address_street, address_housenumber FROM real_estate WHERE living_space LIKE ?");

            $suche->bindParam(1, $suche_nach);

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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($daten as $inhalt) {
                    ?>
                        <tr>
                            <td><?php echo $inhalt['id'] ?></td>
                            <td><?php echo $inhalt['address_street'] ?></td>
                            <td><?php echo $inhalt['address_housenumber']; ?></td>
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
