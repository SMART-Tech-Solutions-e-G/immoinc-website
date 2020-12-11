<?php

require_once("HTMLEndpoint.php");

class CreateRealEstateAnnouncementEndpoint extends HTMLEndpoint
{
    public function render()
    {
        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");
?>
        <div class="wrapper create-real-estate-announcement">
            <div class="slim">
                <div class="slim-wrapper">
                    <form method="POST">
                        <h1>Immobilienanzeige erstellen</h1>
                        <h2>Anzeigendetails</h2>
                        <div class="text-field inline">
                            <select class="input" name="ownershipLevel" id="ownershipLevel" required>
                                <option value="0">Zum Kauf</option>
                                <option value="1">Zur Miete</option>
                            </select>
                            <label for="ownershipLevel">Kauf / Miete</label>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="0.1" name="price" id="price" placeholder=" " required>
                            <label for="price">Preis in €</label>
                        </div>
                        <div class="text-field inline">
                            <select class="input" name="freeFromOption" id="freeFromOption" required>
                                <option value="0">sofort</option>
                                <option value="1">angegeben Datum</option>
                            </select>
                            <label for="freeFromOption">Erstbezugbezug ab</label>
                        </div>
                        <div class="text-field inline" id="freeFrom">
                            <input class="input" type="date" name="freeFromDate" id="freeFromDate">
                            <label for="freeFromDate">Erstbezugsdatum</label>
                        </div>
                        <h2>Immobiliendetails</h2>
                        <div class="text-field inline">
                            <select class="input" name="type" id="type" required>
                                <option value="house">Haus</option>
                                <option value="appartment">Wohnung</option>
                            </select>
                            <label for="type">Immobilientyp</label>
                        </div>
                        <div>
                            <div class="text-field inline">
                                <input class="input" type="text" name="addressStreet" id="addressStreet" placeholder=" " required>
                                <label for="addressStreet">Straße</label>
                            </div>
                            <div class="text-field inline">
                                <input class="input" size="10" type="text" name="addressHousenumber" id="addressHousenumber" placeholder=" " required>
                                <label for="addressHousenumber">Hausnummer</label>
                            </div>
                            <br>
                            <div class="text-field inline">
                                <input class="input" type="text" size="10" name="addressZipCode" id="addressZipCode" placeholder=" " required>
                                <label for="addressZipCode">PLZ</label>
                            </div>
                            <div class="text-field inline">
                                <input class="input" type="text" name="addressCity" id="addressCity" placeholder=" " required>
                                <label for="addressCity">Stadt</label>
                            </div>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="0.1" name="livingSpace" id="livingSpace" placeholder=" " required>
                            <label for="livingSpace">Wohnfläche in m²</label>
                        </div>
                        <div class="text-field inline">
                            <input class="input" type="number" step="1" min="1" name="roomCount" id="roomCount" placeholder=" " required>
                            <label for="roomCount">Zimmerzahl</label>
                        </div>
                        <div class="text-field inline" id="constructionYearWrapper">
                            <input class="input" type="number" id="constructionYear" name="constructionYear" placeholder=" " required>
                            <label for="constructionYear">Baujahr</label>
                        </div>
                        <div class="text-field inline" id="floorWrapper">
                            <input class="input" type="number" size="5" id="floor" name="floor" placeholder=" " required>
                            <label for="floor">Stockwerk</label>
                        </div>
                        <div class="text-field">
                            <textarea class="input" id="description" name="description"></textarea>
                            <label for="description">Beschreibung</label>
                        </div>
                        <div class="button-black">
                            <input type="submit" value="Anzeige erstellen">
                        </div>
                    </form>
                </div>
            </div>
    <?php
    }
}
