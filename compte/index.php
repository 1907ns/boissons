<?php


session_start();
require "../data/config.php";
mysqli_report(MYSQLI_REPORT_ALL);

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

    //prenom de l'utilisateur
    if(isset($_SESSION["prenomuser"])){
        $prenom=$_SESSION["prenomuser"];
    }else{
        $prenom='Non renseigné';
    }

    //e-mail de l'utilisateur
    if(isset($_SESSION["emailuser"])){
        $email=$_SESSION["emailuser"];
    }else{
        $email='Non renseigné';
    }

    //numéro de téléphone de l'utilisateur
    if(isset($_SESSION["telephone"])){
        $tel=$_SESSION["telephone"];
    }else{
        $tel='Non renseigné';
    }

    //date de naissance de l'utilisateur
    if(isset($_SESSION["dnaissance"])){
        $dnaissance=$_SESSION["dnaissance"];
    }else{
        $dnaissance='Non renseigné';
    }

    //adresse de l'utilisateur
    if(isset($_SESSION["adresse"])){
        $adresse=$_SESSION["adresse"];
    }else{
        $adresse='Non renseigné';
    }

    //code postal de l'utilisateur
    if(isset($_SESSION["cpville"])){
        $cpville=$_SESSION["cpville"];
    }else{
        $cpville='Non renseigné';
    }

    //ville de l'utilisateur
    if(isset($_SESSION["ville"])){
        $ville=$_SESSION["ville"];
    }else{
        $ville='Non renseigné';
    }

    //sexe de l'utilisateur
    if(isset($_SESSION["sexe"])){
        $sexe=$_SESSION["sexe"];
    }else{
        $sexe='Non renseigné';
    }


    /********
     * PARTIE MODIFICATION DES DONNEES
     */
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Validation du pseudo
        if(empty(trim($_POST["pseudo"]))){
            $username_err = "Entrez un pseudo SVP.";
        } else{
            // Requête SQL
            $sql = "SELECT pseudo FROM users WHERE pseudo = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set les paramètres
                $param_username = trim($_POST["pseudo"]);


                if(mysqli_stmt_execute($stmt)){
                    /* enregistrement du résultat  */
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1 && $_SESSION["pseudo"] != trim($_POST["pseudo"])){
                        $username_err = "Ce pseudo est déjà utilisé.";
                    } else{
                        $username = trim($_POST["pseudo"]);
                    }
                } else{
                    echo "Erreur. Essayez ultérieurement.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Vaidation du mot de passe
        if(empty(trim($_POST["password"]))){
            $password_err = "Entrez un mot de passe SVP.";
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
        } else{
            $password = trim($_POST["password"]);
        }

        //Autres parametres
        $nomuser=trim($_POST["nomuser"]); //nom de l'utilisateur
        $prenomuser=trim($_POST["prenomuser"]); //prenom de l'utilisateur
        $emailuser=trim($_POST["emailuser"]); //adresse mail de l'utilisateur
        $dnaissance=trim($_POST["dnaissance"]); //date de naissance de l'utilisateur
        $telephone=trim($_POST["telephone"]); //numéro de téléphone de l'utilisateur
        $adresse=trim($_POST["adresse"]); //adresse de l'utilisateur
        $cpville=trim($_POST["cpville"]); //code postal de l'utilisateur
        $ville=trim($_POST["ville"]); //ville de l'utilisateur
        $sexe=trim($_POST["sexe"]); //sexe de l'utilisateur


        // Verifier s'il n'y a pas d'erreurs
        if(empty($username_err) && empty($password_err)){

            // Update de la BDD

            $sql= "UPDATE users SET pseudo =?, password = ?, nom=?, prenom=?, mail=?, birthdate=?, phone=?, adresse=?, cpville=?, ville=?, sexe=? WHERE id = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables
                mysqli_stmt_bind_param($stmt, "sssssssssssi", $param_username, $param_password,$nomuser, $prenomuser, $emailuser, $dnaissance, $telephone, $adresse, $cpville, $ville, $sexe, $param_id);

                // Set parametres
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_id=$_SESSION["id"];

                if(mysqli_stmt_execute($stmt)){

                    session_destroy();
                    header("location: ../connexion/index.php");
                    exit();
                } else{
                    echo "Erreur. Essayez ultérieurement.";
                }

                // Fermeture statement
                mysqli_stmt_close($stmt);
            }
        }else{
            echo $username_err. ' '. $password_err;
        }

        // Fermeture connexion
        mysqli_close($link);
    }
    

} ?>




<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Projet boissons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script  src="../data/liste.js"></script>
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
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
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i%22" rel="stylesheet">
</head>

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
                                        <a class="nav-link scroll" href="../recettes/index.php">Tous nos cocktails</a>
                                    </li>
                                    <li class="nav-item   mr-lg-3">
                                        <a class="nav-link scroll" href="../mes_favoris/index.php">Mes cocktails préférés</a>
                                    </li>
                                    <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
                                        <li class="nav-item active  mr-lg-3">
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
                        <label for="pseudo" class="col-form-label">Pseudo</label>
                        <input type="text" class="form-control border" value="<?php echo $pseudo ?>" name="pseudo" id="pseudo"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="nomuser" class="col-form-label">Nom</label>
                        <input type="text" class="form-control border" value="<?php echo $nom ?>" name="nomuser" id="nomuser"
                               >
                    </div>
                    <div class="form-group">
                        <label for="prenomuser" class="col-form-label">Prénom</label>
                        <input type="text" class="form-control border" value="<?php echo $prenom ?>" name="prenomuser" id="prenomuser"
                               >
                    </div>
                    <div class="form-group">
                        <label for="emailuser" class="col-form-label">Email</label>
                        <input type="email" class="form-control border" value="<?php echo $email ?>" name="emailuser"
                               id="emailuser" >
                    </div>
                    <div class="form-group">
                        <label for="telephone" class="col-form-label">Numéro de tél.</label>
                        <input type="tel" class="form-control border" value="<?php echo $tel ?>" name="telephone"
                               id="telephone" >
                    </div>
                    <div class="form-group">
                        <label for="dnaissance" class="col-form-label">Date de naissance</label>
                        <input type="text" class="form-control border" value="<?php echo $dnaissance ?>" name="dnaissance"
                               id="dnaissance" >
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="col-form-label">Adresse</label>
                        <input type="text" class="form-control border" value="<?php echo $adresse ?>" name="adresse"
                               id="adresse" >
                    </div>
                    <div class="form-group">
                        <label for="cpville" class="col-form-label">CP </label>
                        <input type="text" class="form-control border" value="<?php echo $cpville ?>" name="cpville"
                               id="cpville" >
                    </div>
                    <div class="form-group">
                        <label for="ville" class="col-form-label">Ville</label>
                        <input type="text" class="form-control border" value="<?php echo $ville ?>" name="ville"
                               id="ville" >
                    </div>
                    <div class="form-group">
                        <label for="sexe" class="col-form-label">Sexe:</label>

                        <select name="sexe" id="sexe" class="form-control border">
                            <option value="<?php echo $sexe ?>"><?php echo $sexe ?></option>
                            <option value="Non défini">Non défini</option>
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label">Choisissez un nouveau mot de passe, ou entrez l'actuel</label>
                        <input type="password" class="form-control border" placeholder="******" name="password" id="password"
                               required="">
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control bg-theme text-white" value="Modifier mes informations">
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    <!-- Template scripts-->
    <script src="../assets/js/responsiveslides.min.js"></script>
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

    <!-- Template scripts-->
    <script src="../assets/js/counter.js"></script>
    <!-- start-smooth-scrolling -->
    <script src="../assets/js/move-top.js"></script>
    <script src="../assets/js/easing.js"></script>
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