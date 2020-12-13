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

?>

        <form action="" method="get">
            Nähere Informationen zum Objekt <?php echo $real_estate['address_street'] ?> <?php echo $real_estate['address_housenumber'] ?>

            <textarea cols="20" rows="4" tyle="margin-right:10px;"><?php echo $real_estate['description'] ?></textarea>
            </select>

            <div style="width:100%;">
                <?php while ($real_estate_image = $query->fetch()) { ?>
                    <img src="<?php echo $real_estate_image['path'] ?>" style="margin-left:10px;">
                <?php } ?>
            </div>

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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $real_estate['living_space'] ?></td>
                        <td><?php echo $real_estate['address_street'] ?></td>
                        <td><?php echo $real_estate['address_housenumber']; ?></td>
                    </tr>
                </tbody>
            </table>
        </form>

<?php

    }
}
