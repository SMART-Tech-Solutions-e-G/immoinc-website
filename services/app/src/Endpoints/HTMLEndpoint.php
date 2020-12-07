<?php

require_once("Endpoint.php");

abstract class HTMLEndpoint extends Endpoint
{
    public function _render()
    {

?>
        <html>

        <head>
            <!-- basic -->
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- mobile metas -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="viewport" content="initial-scale=1, maximum-scale=1">
            <!-- site metas -->
            <title>Immo Inc. - Real Estate Online</title>
            <meta name="keywords" content="">
            <meta name="description" content="">
            <meta name="author" content="">
            <?php
            foreach (glob(__DIR__ . "/../assets/css/*.css") as $filename) {
            ?>
                <style>
                    <?php echo file_get_contents($filename) ?>
                </style>
            <?php
            }
            ?>
            <link rel="stylesheet" type="text/css" href="/assets/css_start/bootstrap.min.css">
            <!-- style css -->
            <link rel="stylesheet" type="text/css" href="/assets/css_start/style.css">
            <!-- Responsive-->
            <link rel="stylesheet" href="/assets/css_start/responsive.css">
            <!-- fevicon -->
            <link rel="icon" href="/assets/images/favicon.png" type="image/gif" />
            <!-- Scrollbar Custom CSS -->
            <link rel="stylesheet" href="/assets/css_start/jquery.mCustomScrollbar.min.css">
            <!-- Tweaks for older IEs-->
            <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
            <!-- fonts -->
            <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
            <!-- font awesome -->
            <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <!--  -->
            <!-- owl stylesheets -->
            <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
            <link rel="stylesheet" href="/assets/css_start/owl.carousel.min.css">
            <link rel="stylesoeet" href="/assets/css_start/owl.theme.default.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        </head>

        <body>


            <div class="banner_bg_main">
                <!-- header top section start -->
                <div class="container">
                    <div class="header_section_top">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="custom_menu">
                                    <ul>
                                        <li><a href="#">Most Viewed</a></li>
                                        <li><a href="#">Anbieter</a></li>
                                        <li><a href="#">New Releases</a></li>
                                        <li><a href="#">Today's Deals</a></li>
                                        <li><a href="#">Customer Service</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- header top section start -->
                <!-- logo section start -->
                <div class="logo_section">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="logo"><a href="index.html"><img src="/../assets/images/logo.jpeg" height="100" width="100"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- logo section end -->
                <!-- header section start -->
                <div class="header_section">
                    <div class="container">
                        <div class="containt_main">
                            <div id="mySidenav" class="sidenav">
                                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                                <a href="index.html">Home</a>
                                <a href="fashion.html">Fashion</a>
                                <a href="electronic.html">Electronic</a>
                                <a href="jewellery.html">Jewellery</a>
                            </div>
                            <span class="toggle_icon" onclick="openNav()"><img src="/../assets/images_start/toggle-icon.png"></span>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Category
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>

                        </div>
                        <div class="header_box">
                            <div class="login_menu">
                                <ul>
                                    <li><a href="#">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span class="padding_10">Cart</span></a>
                                    </li>
                                    <li><a href="#">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <span class="padding_10">Cart</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header section end -->
            <div class="header">
                <a href="/" class="logo">
                    <img src="/assets/images/logo.svg">
                    <span class="name">Immo Inc.</span>
                </a>
                <div class="links">
                    <a href="/impressum" class="link">Impressum</a>
                    <?php
                    try {
                        if (!isset($_SESSION["userId"])) throw new Exception("Not logged in");
                        $user = Database::getInstance()->getUser($_SESSION["userId"]);
                    } catch (Exception $err) {
                    ?>
                        <a href="/login" class="link">Anmelden</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="content">
                <?php $this->render() ?>
            </div>
            <!-- footer section start -->
            <div class="footer_section layout_padding">
                <div class="container">
                    <div class="footer_logo"><a href="index.html"><img src="/../assets/images/logo.jpeg" height="100" width="100"></a></div>
                    <div class="input_bt">
                        <input type="text" class="mail_bt" placeholder="Your Email" name="Your Email">
                        <span class="subscribe_bt" id="basic-addon2"><a href="#">Subscribe</a></span>
                    </div>
                    <div class="footer_menu">
                        <ul>
                            <li><a href="#">Most Viewed</a></li>
                            <li><a href="#">Anbieter</a></li>
                            <li><a href="#">New Releases</a></li>
                            <li><a href="#">Today's Deals</a></li>
                            <li><a href="#">Customer Service</a></li>
                        </ul>
                    </div>
                    <div class="location_main">Help Line Number : <a href="#">+1 1800 1200 1200</a></div>
                </div>
            </div>
            <!-- footer section end -->
            <!-- copyright section start -->
            <div class="copyright_section">
                <div class="container">
                    <p class="copyright_text">© 2020 All Rights Reserved. Design by <a href="https://html.design">Smart Tech Solutions e.G.</a></p>
                </div>
            </div>
            <!-- copyright section end -->
            <!-- Javascript files-->
            <script src="/../assets/js/jquery.min.js"></script>
            <script src="/../assets/js/popper.min.js"></script>
            <script src="/../assets/js/bootstrap.bundle.min.js"></script>
            <script src="/../assets/js/jquery-3.0.0.min.js"></script>
            <script src="/../assets/js/plugin.js"></script>
            <!-- sidebar -->
            <script src="/../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
            <script src="/../assets/js/custom.js"></script>
            <script>
                function openNav() {
                    document.getElementById("mySidenav").style.width = "250px";
                }

                function closeNav() {
                    document.getElementById("mySidenav").style.width = "0";
                }
            </script>
        </body>

        </html>
<?php
    }
}
