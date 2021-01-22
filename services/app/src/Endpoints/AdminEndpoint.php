<?php

require_once("HTMLEndpoint.php");

class AdminEndpoint extends HTMLEndpoint
{
    public function render()
    {
        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");

        $connection = Database::getInstance()->getConnection();

        if (isset($_POST["delete-me"])) {
            $deleteId = $_POST["delete-me"];
            // delete real estate based on id
            $query = $connection->prepare("DELETE FROM real_estate WHERE id = :id");
            $query->bindParam(":id", $deleteId, PDO::PARAM_INT);
            $query->execute();
        }

        $query = $connection->prepare("SELECT real_estate_announcement.id AS id, real_estate.id AS real_estate_id, address_street, address_housenumber, address_city, address_zip_code, living_space, free_from, room_count, creation_date, type FROM real_estate_announcement INNER JOIN real_estate ON real_estate_announcement.real_estate_id = real_estate.id");

        $query->execute();

        $real_estates = [];

        while ($row = $query->fetch()) {
            array_push($real_estates, $row);
        }
?>

        <form method="post" action="/real-estate-announcements">
            <div class="wrapper">
                <div class="slim">
                    <div class="slim-wrapper">
                        <table border>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Strasse</th>
                                    <th>Hausnummer</th>
                                    <th>Postleitzahl</th>
                                    <th>Stadt</th>
                                    <th>Wohnfläche</th>
                                    <th>Zimmeranzahl</th>
                                    <th>Frei ab</th>
                                    <th>Einstellungsdatum</th>
                                    <th>Typ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($real_estates as $real_estate) {
                                ?>

                                    <tr>
                                        <td><?php echo $real_estate["id"] ?></td>

                                        <td><?php echo $real_estate["address_street"] ?></td>

                                        <td><?php echo $real_estate["address_housenumber"] ?></td>

                                        <td><?php echo $real_estate["address_zip_code"] ?></td>

                                        <td><?php echo $real_estate["address_city"] ?></td>

                                        <td><?php echo $real_estate["living_space"] ?></td>

                                        <td><?php echo $real_estate["room_count"] ?></td>

                                        <td><?php echo $real_estate["free_from"] ?></td>

                                        <td><?php echo $real_estate["creation_date"] ?></td>

                                        <td><?php echo $real_estate["type"] ?></td>

                                        <td><?php echo "<a href=/real-estate-announcements/edit?id=" . $real_estate["id"] . ">Bearbeiten</a>" ?></td>

                                        <td><button type="submit" name="delete-me" value="<?php echo $real_estate["real_estate_id"]; ?>">Löschen</button></td>
                                    </tr>

        </form>
    <?php

                                }
    ?>
    </tbody>
    </table>
    <a href="/real-estate-announcements/create">
        <div class="button-black">
            <input type="button" value="Immobilie erstellen">
        </div>
    </a>
    </div>
    </div>
    </div>

<?php


    }
}
