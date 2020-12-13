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
            foreach($real_estates as $real_estate) {
                ?> 
                
                <tr>
                <td><?php echo $real_estate["id"]?></td>

                <td><?php echo $real_estate["address_street"]?></td>
                
                <td><?php echo $real_estate["address_housenumber"]?></td>
                
                <td><?php echo $real_estate["address_zip_code"]?></td>

                <td><?php echo $real_estate["address_city"]?></td>
               
                <td><?php echo $real_estate["living_space"]?></td>

                <td><?php echo $real_estate["room_count"]?></td>
                
                <td><?php echo $real_estate["free_from"]?></td>
                
                <td><?php echo $real_estate["creation_date"]?></td>

                <td><?php echo $real_estate["type"]?></td>

                <td><?php echo '<a href=edit.php?id='.$real_estate['id'].'>Bearbeiten</a>' ?></td>

                <td><?php echo '<a href=delete.php?id='.$real_estate['id'].'>Löschen</a>' ?></td>
                </tr>
                
                <?php 
            }
            ?>
            </tbody>
        </table>
    




<?php
   

        }   
}