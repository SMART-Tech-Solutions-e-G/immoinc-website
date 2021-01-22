<?php

require_once("HTMLEndpoint.php");

class EditRealEstateAnnouncementEndpoint extends HTMLEndpoint
{
    public function render()
    {
        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");

        $realEstateAnnouncement = Database::getInstance()->getRealEstateAnnouncement(intval($_GET["id"]));
?>
        <div class="wrapper edit-real-estate-announcement">
            <div class="slim">
                <div class="slim-wrapper">
                    <form method="POST">
                        <h1>Immobilienanzeige #<?php echo $realEstateAnnouncement->getId() ?></h1>
                        <h2>Anzeigendetails</h2>
                        <div class="text-field inline">
                            <select class="input" name="ownershipLevel" id="ownershipLevel" required>
                                <option value="0">Zum Kauf</option>
                                <option value="1" <?php if ($realEstateAnnouncement->getOwnershipLevel() === 1) echo "selected" ?>>Zur Miete</option>
                            </select>
                            <label for="ownershipLevel">Kauf / Miete</label>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="0.1" name="price" id="price" value="<?php echo $realEstateAnnouncement->getPrice() ?>" placeholder=" " required>
                            <label for="price">Preis in €</label>
                        </div>
                        <div class="text-field inline">
                            <select class="input" name="freeFromOption" id="freeFromOption" required>
                                <option value="0">sofort</option>
                                <option value="1" <?php if ($realEstateAnnouncement->getFreeFrom() != null) echo "selected" ?>>angegeben Datum</option>
                            </select>
                            <label for="freeFromOption">Erstbezugbezug ab</label>
                        </div>
                        <div class="text-field inline" id="freeFrom">
                            <input class="input" type="date" name="freeFromDate" id="freeFromDate" value="<?php if ($realEstateAnnouncement->getFreeFrom() != null) echo $realEstateAnnouncement->getFreeFrom()->format("Y-m-d") ?>">
                            <label for="freeFromDate">Erstbezugsdatum</label>
                        </div>
                        <h2>Immobiliendetails</h2>
                        <p>Immoblientyp:
                            <b>
                                <?php
                                if ($realEstateAnnouncement->getRealEstate() instanceof House) {
                                ?>
                                    <span>Haus</span>
                                <?php
                                } else if ($realEstateAnnouncement->getRealEstate() instanceof Appartment) {
                                ?>
                                    <span>Wohnung</span>
                                <?php
                                }
                                ?>
                            </b>
                        </p>
                        <div>
                            <div class="text-field inline">
                                <input class="input" type="text" name="addressStreet" id="addressStreet" value="<?php echo htmlspecialchars($realEstateAnnouncement->getRealEstate()->getAddressStreet()) ?>" placeholder=" " required>
                                <label for="addressStreet">Straße</label>
                            </div>
                            <div class="text-field inline">
                                <input class="input" size="10" type="text" name="addressHousenumber" id="addressHousenumber" value="<?php echo htmlspecialchars($realEstateAnnouncement->getRealEstate()->getAddressHousenumber()) ?>" placeholder=" " required>
                                <label for="addressHousenumber">Hausnummer</label>
                            </div>
                            <br>
                            <div class="text-field inline">
                                <input class="input" type="text" size="10" name="addressZipCode" id="addressZipCode" value="<?php echo htmlspecialchars($realEstateAnnouncement->getRealEstate()->getAddressZipCode()) ?>" placeholder=" " equired>
                                <label for="addressZipCode">PLZ</label>
                            </div>
                            <div class="text-field inline">
                                <input class="input" type="text" name="addressCity" id="addressCity" value="<?php echo htmlspecialchars($realEstateAnnouncement->getRealEstate()->getAddressCity()) ?>" placeholder=" " required>
                                <label for="addressCity">Stadt</label>
                            </div>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="0.1" name="livingSpace" id="livingSpace" value="<?php echo ($realEstateAnnouncement->getRealEstate()->getLivingSpace()) ?>" placeholder=" " required>
                            <label for="livingSpace">Wohnfläche in m²</label>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="1" min="1" name="roomCount" id="roomCount" value="<?php echo ($realEstateAnnouncement->getRealEstate()->getRoomCount()) ?>" placeholder=" " required>
                            <label for="roomCount">Zimmerzahl</label>
                        </div>
                        <?php
                        if ($realEstateAnnouncement->getRealEstate() instanceof House) {
                        ?>
                            <div class="text-field inline">
                                <input class="input" type="number" id="constructionYear" name="constructionYear" value="<?php echo $realEstateAnnouncement->getRealEstate()->getConstructionYear() ?>" placeholder=" " required>
                                <label for="constructionYear">Baujahr</label>
                            </div>
                        <?php
                        } else if ($realEstateAnnouncement->getRealEstate() instanceof Appartment) {
                        ?>
                            <div class="text-field inline">
                                <input class="input" type="number" size="5" id="floor" name="floor" value="<?php echo $realEstateAnnouncement->getRealEstate()->getFloor() ?>" placeholder=" " required>
                                <label for="floor">Stockwerk</label>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-field">
                            <textarea class="input" id="description" name="description"><?php echo htmlspecialchars($realEstateAnnouncement->getRealEstate()->getDescription()) ?></textarea>
                            <label for="description">Beschreibung</label>
                        </div>
                        <div class="button-black">
                            <input type="submit" value="Änderungen speichern">
                        </div>
                    </form>
                    <div class="real-estate-images">
                        <?php
                        foreach ($realEstateAnnouncement->getRealEstate()->getImages() as $realEstateImage) {
                        ?>
                            <div class="real-estate-image">
                                <img class="image" src="<?php echo $realEstateImage->getPath() ?>">
                                <form method="POST" action="images/delete?id=<?php echo $realEstateAnnouncement->getId() ?>">
                                    <input type="hidden" name="imageId" value="<?php echo $realEstateImage->getId() ?>">
                                    <button class="delete-button" type="submit">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0z" fill="none" />
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <div>
                            <form method="POST" enctype="multipart/form-data" action="images/upload?id=<?php echo $realEstateAnnouncement->getId() ?>">
                                <input type="file" name="image">
                                <div class="button-black">
                                    <input type="submit" value="Bild hochladen">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
    }
}
