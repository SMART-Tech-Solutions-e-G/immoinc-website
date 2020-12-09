<?php


require_once("HTMLEndpoint.php");

class SearchEndpoint extends HTMLEndpoint
{
    public function render()
    {
        $connection = Database::getInstance()->getConnection();
        $default_sort_option = "creation_date";

        $living_space_min = isset($_GET["living_space_min"]) ? intval($_GET["living_space_min"]) : -100000;
        $living_space_max = isset($_GET["living_space_max"]) ? intval($_GET["living_space_max"]) : 100000;

        $city = isset($_GET["city"]) && $_GET["city"] != "" ? $_GET["city"] : null;
        $type = isset($_GET["type"]) && $_GET["type"] != "" ? $_GET["type"] : null;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : $default_sort_option;

        $sort_options = ["living_space", "price", "free_from", "creation_date", "room_count"];

        if (!in_array($sort, $sort_options)) $sort = $default_sort_option;

        $query = $connection->prepare("SELECT living_space, type, address_city, address_street, address_housenumber, address_zip_code, price, room_count, free_from FROM real_estate_announcement INNER JOIN real_estate ON real_estate_announcement.real_estate_id=real_estate.id WHERE living_space >= ? AND living_space <= ? AND (address_city = ? OR ? IS NULL) AND (type = ? OR ? IS NULL) ORDER BY $sort DESC");
        $query->bindParam(1, $living_space_min, PDO::PARAM_INT);
        $query->bindParam(2, $living_space_max, PDO::PARAM_INT);
        $query->bindParam(3, $city, PDO::PARAM_STR);
        $query->bindParam(4, $city, PDO::PARAM_STR);
        $query->bindParam(5, $type, PDO::PARAM_STR);
        $query->bindParam(6, $type, PDO::PARAM_STR);

        $query->execute();

        $real_estates = [];

        while ($row = $query->fetch()) {
            array_push($real_estates, $row);
        }
?>
        <div class="wrapper">
            <div class="slim">
                <div class="slim-wrapper">

                    <div class="search">
                        <form class="filters" action="" method="get">
                            <div class="text-field inline">
                                <select class="input" name="type" id="type">
                                    <option></option>
                                    <option value="appartment" <?php if ($type == "appartment") echo "selected" ?>>Wohnung</option>
                                    <option value="house" <?php if ($type == "house") echo "selected" ?>>Haus</option>
                                </select>
                                <label for="type">Immobilientyp</label>
                            </div>

                            <div class="text-field inline">
                                <select class="input" name="city" id="city">
                                    <option></option>
                                    <?php

                                    $query = $connection->prepare("SELECT DISTINCT address_city FROM real_estate INNER JOIN real_estate_announcement ON real_estate_announcement.real_estate_id = real_estate.id");
                                    $query->execute();

                                    while ($row = $query->fetch()) {
                                    ?>
                                        <option <?php if ($city == $row["address_city"]) echo "selected" ?> value="<?php echo $row["address_city"] ?>"><?php echo $row["address_city"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="city">Stadt</label>
                            </div>

                            <div class="text-field inline">
                                <input class="input" id="living-space-min" type="text" name="living_space_min" value="<?php echo $living_space_min ?>" placeholder=" " required>
                                <label for="living-space-min">Min. Wohnfläche (m²)</label>
                            </div>

                            <div class="text-field inline">
                                <input class="input" id="living-space-max" type="text" name="living_space_max" value="<?php echo $living_space_max ?>" placeholder=" " required>
                                <label for="living-space-max">Max. Wohnfläche (m²)</label>
                            </div>

                            <div class="text-field inline">
                                <select class="input" name="sort" id="sort">
                                    <option <?php if ($sort == "living_space") echo "selected" ?> value="living_space">Wohnfläche</option>
                                    <option <?php if ($sort == "price") echo "selected" ?> value="price">Preis</option>
                                    <option <?php if ($sort == "free_from") echo "selected" ?> value="free_from">Einzugsdatum</option>
                                    <option <?php if ($sort == "room_count") echo "selected" ?> value="room_count">Zimmerzahl</option>
                                    <option <?php if ($sort == "creation_date") echo "selected" ?> value="creation_date">Einstellungsdatum</option>
                                </select>
                                <label for="sort">Sortieren nach</label>
                            </div>

                            <button class="button" type="submit">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                                <span class="name">Suchen</span>
                            </button>
                        </form>
                        <div class="real-estates-list">
                            <?php
                            foreach ($real_estates as $real_estate) {
                            ?>
                                <div class="real-estate">
                                    <div class="wrapper">
                                        <p class="address">
                                            <?php echo $real_estate["address_street"] ?>
                                            <?php echo $real_estate["address_housenumber"] ?>,
                                            <?php echo $real_estate["address_zip_code"] ?>
                                            <?php echo $real_estate["address_city"] ?>
                                        </p>
                                        <p class="room-count"><?php echo $real_estate["room_count"] ?></p>
                                        <p class="free_from"><?php if ($real_estate["free_from"] != null) echo date("d.m.Y", strtotime($real_estate["free_from"])) ?></p>
                                        <p class="living-space"><?php echo $real_estate["living_space"] ?> m²</p>
                                        <p class="price"><?php echo $real_estate["price"] ?> €</p>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
