<?php

require_once("Endpoint.php");

class DetailansichtEndpoint extends HTMLEndpoint
{

    public function render()
    {
        $id = $_GET['id'];
        $connection = Database::getInstance()->getConnection();
        $query = $connection->prepare("SELECT address_street, address_housenumber, address_city, address_zip_code, living_space, price, description, free_from FROM real_estate INNER JOIN real_estate_announcement ON real_estate_announcement.real_estate_id = real_estate.id WHERE real_estate_announcement.id = ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $real_estate = $query->fetch();

        $query = $connection->prepare("SELECT * FROM real_estate_image WHERE real_estate_id= ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $real_estate_image = $query->fetch();

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
                        <th>Adresse</th>
                        <th>Preis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $real_estate['living_space'] ?></td>
                        <td><?php echo $real_estate['address_street'] ?> <?php echo $real_estate['address_housenumber']; ?>, <?php echo $real_estate['address_zip_code']; ?> <?php echo $real_estate['address_city']; ?></td>
                        <td><?php echo $real_estate['price']; ?> €</td>
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
                        <td><?php echo $real_estate['free_from'] != null ? $real_estate['free_from'] : "sofort" ?></td>
                    </tr>
                </tbody>
            </table>
        </form>

<?php

    }
}
