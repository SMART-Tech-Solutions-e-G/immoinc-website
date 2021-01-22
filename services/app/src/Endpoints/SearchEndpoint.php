<?php


require_once("HTMLEndpoint.php");

class SearchEndpoint extends HTMLEndpoint
{
    public function render()
    {
        $livingSpaceMin = isset($_GET["livingSpaceMin"]) ? intval($_GET["livingSpaceMin"]) : 0;
        $livingSpaceMax = isset($_GET["livingSpaceMax"]) ? intval($_GET["livingSpaceMax"]) : 10000;

        $selectedCity = isset($_GET["city"]) && $_GET["city"] != "" ? $_GET["city"] : null;
        $selectedType = isset($_GET["type"]) && $_GET["type"] != "" ? $_GET["type"] : null;
        $ownershipLevel = isset($_GET["ownershipLevel"]) && $_GET["ownershipLevel"] != "" ? intval($_GET["ownershipLevel"]) : null;
        $sortOption = isset($_GET["sort"]) ? $_GET["sort"] : null;


        $realEstateAnnouncements = Database::getInstance()->searchRealEstateAnnouncements($livingSpaceMin, $livingSpaceMax, $selectedCity, $selectedType, $ownershipLevel, $sortOption);
?>
        <div class="wrapper">
            <div class="slim">
                <div class="slim-wrapper">

                    <div class="search">
                        <form class="filters" action="" method="get">
                            <div class="text-field inline">
                                <select class="input" name="type" id="type">
                                    <option></option>
                                    <option value="appartment" <?php if ($selectedType == "appartment") echo "selected" ?>>Wohnung</option>
                                    <option value="house" <?php if ($selectedType == "house") echo "selected" ?>>Haus</option>
                                </select>
                                <label for="type">Immobilientyp</label>
                            </div>

                            <div class="text-field inline">
                                <select class="input" name="ownershipLevel" id="ownershipLevel">
                                    <option></option>
                                    <option value="0" <?php if ($ownershipLevel === 0) echo "selected" ?>>Zum Kauf</option>
                                    <option value="1" <?php if ($ownershipLevel === 1) echo "selected" ?>>Zur Miete</option>
                                </select>
                                <label for="ownershipLevel">Kauf / Miete</label>
                            </div>

                            <div class="text-field inline">
                                <select class="input" name="city" id="city">
                                    <option></option>
                                    <?php

                                    $cities = Database::getInstance()->getAllCities();

                                    foreach ($cities as $city) {
                                    ?>
                                        <option <?php if ($city == $selectedCity) echo "selected" ?> value="<?php echo htmlspecialchars($city) ?>"><?php echo htmlspecialchars($city) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="city">Stadt</label>
                            </div>

                            <div class="text-field inline">
                                <input class="input" id="living-space-min" type="text" name="livingSpaceMin" value="<?php echo $livingSpaceMin ?>" placeholder=" " required>
                                <label for="living-space-min">Min. Wohnfläche (m²)</label>
                            </div>

                            <div class="text-field inline">
                                <input class="input" id="living-space-max" type="text" name="livingSpaceMax" value="<?php echo $livingSpaceMax ?>" placeholder=" " required>
                                <label for="living-space-max">Max. Wohnfläche (m²)</label>
                            </div>

                            <div class="text-field inline">
                                <select class="input" name="sort" id="sort">
                                    <option <?php if ($sortOption == "living_space") echo "selected" ?> value="living_space">Wohnfläche</option>
                                    <option <?php if ($sortOption == "price") echo "selected" ?> value="price">Preis</option>
                                    <option <?php if ($sortOption == "free_from") echo "selected" ?> value="free_from">Einzugsdatum</option>
                                    <option <?php if ($sortOption == "room_count") echo "selected" ?> value="room_count">Zimmerzahl</option>
                                    <option <?php if ($sortOption == "creation_date") echo "selected" ?> value="creation_date">Einstellungsdatum</option>
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
                            foreach ($realEstateAnnouncements as $realEstateAnnouncement) {
                                $realEstate = $realEstateAnnouncement->getRealEstate();

                                $imageUrl = "/assets/images/logo.jpeg"; // default image if no image exist

                                if (sizeof($realEstate->getImages()) > 0) $imageUrl = $realEstate->getImages()[0]->getPath();

                            ?>
                                <a href="/detailansicht?id=<?php echo $realEstateAnnouncement->getId() ?>">
                                    <div class="real-estate">
                                        <img class="image" src="<?php echo $imageUrl ?>">
                                        <p class="free-from-wrapper">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                            </svg>
                                            <span class="free-from"><?php echo $realEstateAnnouncement->getFreeFrom() != null ? $realEstateAnnouncement->getFreeFrom()->format("d.m.Y") : "sofort" ?></span>
                                        </p>
                                        <div class="wrapper">
                                            <p class="address-wrapper">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                                </svg>
                                                <span class="address">
                                                    <?php echo htmlspecialchars($realEstate->getAddressStreet()) ?>
                                                    <?php echo htmlspecialchars($realEstate->getAddressHousenumber()) ?>,
                                                    <?php echo htmlspecialchars($realEstate->getAddressZipCode()) ?>
                                                    <?php echo htmlspecialchars($realEstate->getAddressCity()) ?>
                                                </span>
                                            </p>
                                            <p class="living-space-wrapper">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                </svg>
                                                <span class="living-space"><?php echo number_format($realEstate->getLivingSpace()) ?> m²</span>
                                            </p>
                                            <p class="price"><?php echo number_format($realEstateAnnouncement->getPrice()) ?> € <?php if ($realEstateAnnouncement->getOwnershipLevel() === 1) { ?><span class="ownershipLevel">Monat</span><?php } ?></p>
                                        </div>
                                    </div>
                                </a>
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
