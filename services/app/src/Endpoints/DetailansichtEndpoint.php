<?php

require_once("Endpoint.php");

class DetailansichtEndpoint extends HTMLEndpoint
{

    public function render()
    {
        $id = $_GET['id'];
        $connection = Database::getInstance()->getConnection();
        $query = $connection->prepare("SELECT * FROM real_estate WHERE id = ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $real_estate = $query->fetch();

        $query = $connection->prepare("SELECT * FROM real_estate_image WHERE real_estate_id= ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $real_estate_image = $query->fetch();

        $query = $connection->prepare("SELECT price FROM real_estate_announcement WHERE real_estate_id= ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query-> execute();
        $real_estate_announcement = $query->fetch();

?>

        <form action="" method="get">
            Nähere Informationen zum Objekt <b> <?php echo $real_estate['address_street'] ?> <?php echo $real_estate['address_housenumber'] ?> </b> in <b> <?php echo $real_estate['address_city'] ?> </b> <br>

            <div style="width:100%;">
                <?php while ($real_estate_image = $query->fetch()) { ?>
                    <img src="<?php echo $real_estate_image['path'] ?>" style="margin-left:10px;">
                <?php } ?>
            </div>
            
            <textarea readonly cols="70" rows="9" tyle="margin-right:18px;"><?php echo $real_estate['description'] ?></textarea> </select>

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
                        <th>Wohnfläche</th>
                        <th>Strasse</th>
                        <th>Hausnummer</th>
                        <th>Preis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $real_estate['living_space'] ?></td>
                        <td><?php echo $real_estate['address_street'] ?></td>
                        <td><?php echo $real_estate['address_housenumber']; ?></td>
                        <td><?php echo $real_estate_announcement['price']; ?></td>
                    </tr>
                </tbody>
            </table>
            
            <table>
                <thead>
                    <tr>
                        <th>Bezugsfertig zum </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $real_estate['free_from'] ?></td>
                    </tr>
                </tbody>
            </table>
        </form>

<?php

    }
}
