<?php
session_start();
?>
<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />

    <!-- Custom Theme files -->
    <link href="../assets/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <!-- Portfolio-->
    <link href="../assets/css/portfolio.css" type="text/css" rel="stylesheet" media="all">
    <link href="../assets/css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- font-awesome icons -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script  src="../data/liste.js"></script>
    <script  src="../data/nom_image.js"></script>
    <script  src="../data/GestionFavoris.js"></script>
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <title><?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Toutes nos recettes";}?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>



<!-- header -->

<header class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-flex align-items-center justify-content-center">
                <h1>
                    <a class="navbar-brand" href="../index.php">
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
                                      onclick="location.href='../deconnexion/index.php' ">Se déconnecter
                            </button>
                        <?php }  else{ ?><button type="button" class="btn  wthree-link-bnr bg-transparent text-secondary"
                                                 onclick="location.href='../connexion/index.php' ">Se connecter
                        </button>
                            <button type="button"  onclick="location.href='../creation_compte/index.php' "class="btn  ml-2 wthree-link-bnr" data-toggle="modal" data-target="#exampleModal1">Créer un compte</button>
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
                                <li class="nav-item mr-lg-3">
                                    <a class="nav-link" href="../index.php">Accueil
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item   mr-lg-3">
                                    <a class="nav-link scroll" href="../recettes/index.php">Tous nos cocktails</a>
                                </li>
                                <li class="nav-item   mr-lg-3">
                                    <a class="nav-link scroll active" href="index.php">Mes cocktails préférés</a>
                                </li>
                                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
                                    <li class="nav-item   mr-lg-3">
                                        <a class="nav-link scroll" href="../compte/index.php">Mon Compte</a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item mr-lg-3 ">
                                    <form action="../recherche/index.php" method="get" class="nav-link scroll" >
                                        <input type="text" placeholder="Jus d'orange.." class="form-control border" name="name" id="search" list="liste" oninput="liste('../data/TraitementRecettes.php', '../data/TraitementHierarchie.php')">
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

<!-- On charge les favoris à l'aide de la fonction getFav -->
<body onload="getFav()">
<div class="justify-content-center" id="ResFav"></div>



<!-- footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 footer-logo mb-lg-0 mb-4 text-lg-left text-center">
                <h2>
                    <a href="../index.php">Cocktailand</a>
                </h2>
            </div>
            <div class="col-lg-6 cpy-right text-lg-right text-center">
                <p>© 2018 Cafe. All rights reserved | Design by
                    <a href="http://w3layouts.com"> W3layouts.</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- //footer -->

<!--Template scripts -->
    <script src="../assets/js/counter.js"></script>
    <!-- start-smooth-scrolling -->
    <script src="../assets/js/move-top.js"></script>
    <script src="../assets/js/easing.js"></script>
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
    <script src="../assets/js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/bootstrap.js"></script>

</body>
</html>

