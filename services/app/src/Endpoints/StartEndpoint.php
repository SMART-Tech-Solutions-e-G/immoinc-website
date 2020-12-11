<?php
class StartEndpoint extends HTMLEndpoint
{
    public function render()
    {
        $connection = Database::getInstance()->getConnection();

        $query = $connection->prepare("SELECT DISTINCT address_city FROM real_estate");

        $query->execute();

        $array_real_estate = [];

        while ($row = $query->fetch()) {
            array_push($array_real_estate, $row);
        }

        $query = $connection->prepare("SELECT living_space, type, address_city, 
        address_street, address_housenumber, address_zip_code, price, room_count, free_from 
        FROM real_estate_announcement INNER JOIN real_estate 
        ON real_estate_announcement.real_estate_id=real_estate.id");

        $query->execute();

        $real_estates = [];

        while ($row = $query->fetch()) {
            array_push($real_estates, $row);
        }

?>
        <div class="start">
            <div class="background">
                <form class="form" action="/search" method="GET">
                    <div class="text-field inline box">
                        <select class="input" id="Place" name="standort">
                            <?php
                            if (!empty($array_real_estate)) {
                                foreach ($array_real_estate as $real_estate) {
                            ?>
                                    <option value="<?php
                                                    echo $real_estate['address_city'] ?>">
                                        <?php echo $real_estate['address_city']
                                        ?> </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label for="standort">Standort</label>
                    </div>
                    <div class="dropdown box">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="text-field inline">
                                <select class="input" name="type">
                                    <option value="house" class="dropdown-item">Haus</a>
                                    <option value="appartment" class="dropdown-item">Appartment</a>
                                </select>
                                <label for="type">Immobilientyp</label>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="text-field inline">
                            <input type="text" class="input" name="living_space_min" placeholder="Minimale Wohnfläche">
                            <label for="living_space_min">Minimale Wohnfläche</label>
                        </div>
                    </div>
                    <div class="text-field inline">
                        <input type="text" class="input" name="living_space_max" placeholder="Maximale Wohnfläche">
                        <label for="living_space_max">Maximale Wohnfläche</label>
                    </div>
                    <button class="button" type="submit">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                        <span class="name">Suchen</span>
                    </button>
                </form>
            </div>
            <div class="body">
                <div class="d1">Unsere Neuheiten</div>
                    <div class="grid">
                        <?php
                        foreach ($real_estates as $real_estate) {
                        ?>
                            <div >
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
