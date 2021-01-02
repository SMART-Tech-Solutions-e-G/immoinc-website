<?php

require_once("HTMLEndpoint.php");

class AdminEndpoint extends HTMLEndpoint
{
    public function render()
    {
        $connection = Database::getInstance()->getConnection();
        $query = $connection->prepare("SELECT * FROM real_estate");

        $query->execute();

        $real_estates = [];

        while ($row = $query->fetch()) {
            array_push($real_estates, $row);
        }
        ?>
     
     <?php
        
        
        if(isset($_POST['delete-me'])){
            $deleteId = $_POST['delete-me'];
                // delete user based on id
             $dquery = $connection->prepare("DELETE FROM real_estate WHERE id='".$deleteId."'");
             $dquery -> execute();
            
}
    ?>
        
        <form method="post" action="/real-estate-announcements" >
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

                                    <td><?php echo '<a href=/real-estate-announcements/edit?id=' . $real_estate['id'] . '>Bearbeiten</a>' ?></td>

                                    <td><button type="submit" name="delete-me" value="<?php echo $real_estate["id"];?>">Löschen</button></td>
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