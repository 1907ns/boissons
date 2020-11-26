<?php


session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    $pseudo=" ";
    $nom= " ";
    $prenom= " ";
    $email=" ";
    $tel= " ";
    $dnaissance=" ";
    $adresse=" ";
    $cpville = " ";
    $ville =" ";
    $sexe=" ";
    $password=" ";

    //pseudo
    if(isset($_SESSION["pseudo"])){
        $pseudo=$_SESSION["pseudo"];
    }else{
        $pseudo='Non renseigné';
    }

    //nom de l'utilisateur
    if(isset($_SESSION["nomuser"])){
        $nom=$_SESSION["nomuser"];
    }else{
        $nom='Non renseigné';
    }

    if(isset($_SESSION["prenomuser"])){
        $prenom=$_SESSION["prenomuser"];
    }else{
        $prenom='Non renseigné';
    }

    if(isset($_SESSION["emailuser"])){
        $email=$_SESSION["emailuser"];
    }else{
        $email='Non renseigné';
    }

    if(isset($_SESSION["telephone"])){
        $tel=$_SESSION["telephone"];
    }else{
        $tel='Non renseigné';
    }

    if(isset($_SESSION["dnaissance"])){
        $dnaissance=$_SESSION["pseudo"];
    }else{
        $dnaissance='Non renseigné';
    }

    if(isset($_SESSION["adresse"])){
        $adresse=$_SESSION["adresse"];
    }else{
        $adresse='Non renseigné';
    }

    if(isset($_SESSION["cpville"])){
        $cpville=$_SESSION["cpville"];
    }else{
        $cpville='Non renseigné';
    }

    if(isset($_SESSION["ville"])){
        $ville=$_SESSION["ville"];
    }else{
        $ville='Non renseigné';
    }

    if(isset($_SESSION["sexe"])){
        $sexe=$_SESSION["sexe"];
    }else{
        $sexe='Non renseigné';
    }


} ?>





<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Projet boissons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <!-- Portfolio-->
    <link href="../css/portfolio.css" type="text/css" rel="stylesheet" media="all">
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- font-awesome icons -->
    <link href="../css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i%22" rel="stylesheet">
</head>
<!-- Login modal -->
<body>

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
                                    <li class="nav-item  mr-lg-3">
                                        <a class="nav-link scroll" href="../index.php">Accueil
                                            <span class="sr-only">(current)</span>
                                        </a>
                                    </li>
                                    <li class="nav-item   mr-lg-3">
                                        <a class="nav-link scroll" href="#">Tous nos cocktails</a>
                                    </li>
                                    <li class="nav-item   mr-lg-3">
                                        <a class="nav-link scroll" href="#">Mes cocktails préférés</a>
                                    </li>
                                    <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
                                        <li class="nav-item active  mr-lg-3">
                                            <a class="nav-link scroll" href="../compte/index.php">Mon Compte</a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item   mr-lg-3 ">
                                        <form action="" class="nav-link">
                                            <input type="text" placeholder="Jus d'orange.." class="form-control border" name="search">
                                            <button type="submit" href="#"><i class="fa fa-search"></i></button>
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

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header  bg-theme2">
                <h5 class="modal-title" id="exampleModalLabel1">Mes informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="new_pseudo" class="col-form-label">Pseudo</label>
                        <input type="text" class="form-control border" value="<?php echo $pseudo ?>" name="new_pseudo" id="new_pseudo"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="new_nomuser" class="col-form-label">Nom</label>
                        <input type="text" class="form-control border" value="<?php echo $nom ?>" name="new_nomuser" id="new_nomuser"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="new_prenomuser" class="col-form-label">Prénom</label>
                        <input type="text" class="form-control border" value="<?php echo $prenom ?>" name="new_prenomuser" id="new_prenomuser"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="new_emailuser" class="col-form-label">Email</label>
                        <input type="email" class="form-control border" value="<?php echo $email ?>" name="new_emailuser"
                               id="new_emailuser" required="">
                    </div>
                    <div class="form-group">
                        <label for="new_telephone" class="col-form-label">Numéro de tél.</label>
                        <input type="tel" class="form-control border" value="<?php echo $tel ?>" name="new_telephone"
                               id="new_telephone" >
                    </div>
                    <div class="form-group">
                        <label for="new_dnaissance" class="col-form-label">Date de naissance</label>
                        <input type="text" class="form-control border" value="<?php echo $tel ?>" name="new_dnaissance"
                               id="new_dnaissance" required="">
                    </div>
                    <div class="form-group">
                        <label for="new_adresse" class="col-form-label">Adresse</label>
                        <input type="text" class="form-control border" value="<?php echo $adresse ?>" name="new_adresse"
                               id="new_adresse" required="">
                    </div>
                    <div class="form-group">
                        <label for="new_cpville" class="col-form-label">CP </label>
                        <input type="text" class="form-control border" value="<?php echo $cpville ?>" name="new_cpville"
                               id="new_cpville" required="">
                    </div>
                    <div class="form-group">
                        <label for="new_ville" class="col-form-label">Ville</label>
                        <input type="text" class="form-control border" value="<?php echo $ville ?>" name="new_ville"
                               id="new_ville" required="">
                    </div>
                    <div class="form-group">
                        <label for="new_sexe" class="col-form-label">Sexe:</label>

                        <select name="new_sexe" id="new_sexe" class="form-control border">
                            <option value="current"><?php echo $sexe ?></option>
                            <option value="NF">Non défini</option>
                            <option value="M">M</option>
                            <option value="M">F</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="col-form-label">Mot de passe</label>
                        <input type="password" class="form-control border" placeholder="********" name="new_password" id="new_password"
                               required="">
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control bg-theme text-white" value="Modifier mes informations">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- js -->
    <script src="../js/jquery-2.2.3.min.js"></script>
    <!-- //js -->
    <!-- testimonials  Responsiveslides -->
    <script src="../js/responsiveslides.min.js"></script>
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
    <script src="../js/jquery.picEyes.js"></script>
    <script>
        $(function () {
            //picturesEyes($('.demo li'));
            $('.demo li').picEyes();
        });
    </script>
    <!-- //Portfolio -->
    <!-- script for password match -->
    <script>
        window.onload = function () {
            document.getElementById("password1").onchange = validatePassword;
            document.getElementById("password2").onchange = validatePassword;
        }
        function validatePassword() {
            var pass2 = document.getElementById("password2").value;
            var pass1 = document.getElementById("password1").value;
            if (pass1 != pass2)
                document.getElementById("password2").setCustomValidity("Passwords Don't Match");
            else
                document.getElementById("password2").setCustomValidity('');
            //empty string means no validation error
        }
    </script>
    <!-- script for password match -->
    <script src="../js/counter.js"></script>
    <!-- start-smooth-scrolling -->
    <script src="../js/move-top.js"></script>
    <script src="../js/easing.js"></script>
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
    <script src="../js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/bootstrap.js"></script>
</body>