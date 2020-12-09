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
?>

        <div class="main">
            <!-- Another variation with a button -->
            <div class="input-group">

                <form action="/search" method="get">
                    <select id="Place" name="standort">

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



                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Immobilientyp
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <select name="type">
                                <option value="house" class="dropdown-item">Haus</a>
                                <option value="appartment" class="dropdown-item">Appartment</a>
                            </select>
                        </div>

                    </div>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="b1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Category
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" value="house" onclick="change(this)"'>Haus</a>
                            <a class="dropdown-item" value="appartment" onclick="change(this)"'>Appartment</a>
                        </div>
                    </div>

                    <script>
                        function change(objButton) {
                            var btn = document.getElementById("b1");
                            if (objButton.innerText == "Haus") {
                                btn.innerHTML = "Haus";
                            } else {
                                btn.innerHTML = "Appartment";
                            }
                        }
                    </script>


                    <select name="type">
                        <option value="house">Haus</option>
                        <option value="appartment">Wohnung</option>
                    </select>

                    <input type="text" class="form-control" name="living_space_min" placeholder="Minimale Wohnfläche">
                    <input type="text" class="form-control" name="living_space_max" placeholder="Maximale Wohnfläche">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit" value="Button1" style="background-color: #f26522; border-color:#f26522 ">
                            <i class="fa fa-search"></i>
                        </button>
                </form>
            </div>
        </div>
<?php
    }
}
