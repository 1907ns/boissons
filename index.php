<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
  //Initialisation de la session
  session_start();
  ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Projet boissons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <!-- Portfolio-->
    <link href="css/portfolio.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <script  src="data/liste.js"></script>
</head>

<body>
    <!-- header -->
        <header class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 d-flex align-items-center justify-content-center">
                        <h1>
                            <a class="navbar-brand" href="#">
                                Cocktailand
                            </a>
                        </h1>
                    </div>
                    <div class="col-lg-9 header-bottom-wthree">
                        <div class="d-md-flex justify-content-lg-end justify-content-center header-right">
                            <div class="right_nav">
                                <?php
                                if(isset($_SESSION['pseudo'])) {
                                    echo "Bienvenue " . $_SESSION['pseudo'];
                                    ?><button type="button" class="btn  wthree-link-bnr bg-transparent text-secondary"
                                              onclick="location.href='deconnexion/index.php' ">Se déconnecter
                                    </button>
                                <?php }  else{ ?><button type="button" class="btn  wthree-link-bnr bg-transparent text-secondary"
                                    onclick="location.href='connexion/index.php' ">Se connecter
                                </button>
                                <button type="button"  onclick="location.href='creation_compte/index.php' "class="btn  ml-2 wthree-link-bnr" data-toggle="modal" data-target="#exampleModal1">Créer un compte</button>
                                <?php } ?>
                            </div>
                        </div>
                        <nav class="navbar second navbar-expand-lg navbar-light">
                            <button class="navbar-toggler mx-auto mt-lg-0 mt-sm-4" type="button" data-toggle="collapse"
                                data-target=".navbar-toggle" aria-controls="navbarNavAltMarkup1" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup1">
                                <div class="navbar-nav secondfix ml-lg-auto">
                                    <ul class="navbar-nav text-center">
                                        <li class="nav-item active  mr-lg-3">
                                            <a class="nav-link" href="#">Accueil
                                                <span class="sr-only">(current)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item   mr-lg-3">
                                            <a class="nav-link scroll" href="recettes/index.php">Tous nos cocktails</a>
                                        </li>
                                        <li class="nav-item   mr-lg-3">
                                            <a class="nav-link scroll" href="#">Mes cocktails préférés</a>
                                        </li>
                                        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
                                            <li class="nav-item   mr-lg-3">
                                                <a class="nav-link scroll" href="compte/index.php">Mon Compte</a>
                                            </li>
                                        <?php } ?>
                                        <li class="nav-item mr-lg-3 ">
                                            <form action="recherche/index.php" method="get" class="nav-link scroll" >
                                                <input type="text" placeholder="Jus d'orange.." class="form-control border" name="name" id="search" list="liste" oninput="liste('data/TraitementRecettes.php', 'data/TraitementHierarchie.php')">
                                                <datalist id="liste"></datalist>
                                                <button type="submit" onclick="window.location='recherche/index.php'"><i class="fa fa-search"></i></button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    <!-- //header -->
    <!-- banner -->
    <div class="banner">
        <div class="container">
            <div class="banner-text">
                <h3>Trouvez le cocktail de vos rêves!
                </h3>
                <p>Cocktailand est une plateforme où vous pourrez découvrir de nombreux cocktails!</p>
                <a href="#populaires" class="scroll text-capitalize serv_link btn bg-theme2">cocktails populaires</a>
            </div>
        </div>
    </div>
    <!-- //banner -->


    <!-- populaires -->
    <section class="portfolio-wthree align-w3" id="populaires">
        <div class="container-fluid">
            <div class="title-w3ls text-center">
                <h4 class="w3pvt-title">Nos recettes populaires</h4>
            </div>
            <div class="pb-lg-5 pb-sm-4">
                <ul class="demo row">
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Raifortissimo.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">RAIFOTISSIMO</h6>
                                <a href="./recettes/index.php?nom=Raifortissimo" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Bora_bora.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">BORA BORA</h6>
                                <a href="./recettes/index.php?nom=Bora bora" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Builder.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">BUILDER</h6>
                                <a href="./recettes/index.php?nom=Builder" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Screwdriver.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">SCREWDRIVER</h6>
                                <a href="./recettes/index.php?nom=Screwdriver" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Le_vandetta.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">LE VANDETTA</h6>
                                <a href="./recettes/index.php?nom=Le vandetta" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-4">
                        <div class="img-grid">
                            <div class="Portfolio-grid1 align-content-center">
                                <img style="width: 50%; height: 50%;" src="Projet/Photos/Coconut_kiss.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="port-desc text-center">
                                <h6 class="main-title-w3pvt text-center">COCONUT KISS</h6>
                                <a href="./recettes/index.php?nom=Coconut kiss" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- //populaire -->


    <!-- js -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- //js -->
    <!-- testimonials  Responsiveslides -->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        // You can also use"$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider3").responsiveSlides({
                auto: true,
                pager: true,
                nav: false,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>
    <!-- //testimonials  Responsiveslides -->
    <!-- Portfolio -->
    <!-- //Portfolio -->
    <!-- script for password match -->

    <!-- script for password match -->
    <script src="js/counter.js"></script>
    <!-- start-smooth-scrolling -->
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>
    <!--<script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();

                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script> -->
    <!-- //end-smooth-scrolling -->
    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function () {
            /*
            var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
            };
            */

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
</body>

</html>