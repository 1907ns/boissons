
<?php
//Initialisation de la session
ini_set('error_reporting',-1);
ini_set('display_errors', 1);
session_start();


// Vérifier si l'utilisateur est déjà connecté, si oui le rediriger vers la page d'accueil
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}

// Inclusion du fichier de configuration
require "../data/config.php";
mysqli_report(MYSQLI_REPORT_ALL);

// Definition et initialisation des variables
$username = $password = "";
$username_err = $password_err = "";

// Récupération des données du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Vérifier si le champ pseudo est vide
    if(empty(trim($_POST["pseudo"]))){
        $username_err = "Entrez un pseudo.";
    } else{
        $username = trim($_POST["pseudo"]);
    }

    // Vérifier si le champ mot de passe est vide
    if(empty(trim($_POST["password"]))){
        $password_err = "Entrez votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validation des infos récupérées
    if(empty($username_err) && empty($password_err)){
        // Requête SQL pour choisir le bon utilisateur
        $sql = "SELECT id, pseudo, password, nom, prenom, mail, phone, birthdate, adresse, cpville, ville, sexe, favoris FROM users WHERE pseudo = ?";
        $hashed_password= "SELECT password FROM users WHERE pseudo = ?";
        $nom="SELECT nom FROM users WHERE pseudo = ?";
        $favoris="SELECT favoris FROM users WHERE pseudo = ?";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt){
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set les paramètres
            $param_username = $username;


            if(mysqli_stmt_execute($stmt)){
                // Récupération du résultat
                mysqli_stmt_store_result($stmt);

                // Verifier si le pseudo existe
                if(mysqli_stmt_num_rows($stmt) == 1){

                    // Bind les variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password,$nom, $prenom, $mail, $phone, $birthdate, $adresse, $cpville, $ville, $sexe, $favoris);
                    if(mysqli_stmt_fetch($stmt)){

                        //Vérifier sue le mot de passe saisie correspons au hash
                        if(password_verify($password, $hashed_password)){

                        // Le mot de pase est correct, start d'une nouvelle session
                            session_start();

                            // Enregistrement des données dans les cookies
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["pseudo"] = $username;
                            $_SESSION["nomuser"]=$nom;
                            $_SESSION["prenomuser"]=$prenom;
                            $_SESSION["emailuser"]=$mail;
                            $_SESSION["dnaissance"]=$birthdate;
                            $_SESSION["telephone"]=$phone;
                            $_SESSION["adresse"]=$adresse;
                            $_SESSION["cpville"]=$cpville;
                            $_SESSION["ville"]=$ville;
                            $_SESSION["sexe"]=$sexe;
                            if(strpos($favoris, '|') !== false) {
                                $favBDD = explode('|', $favoris);
                            }else{
                                $favBDD = $favoris;
                            }
                            if(isset($_SESSION['favoris'])) {
                                if(strpos($_SESSION['favoris'], '|') !== false) {
                                    $favCookies = explode('|', $_SESSION['favoris']);
                                }else{
                                    $favCookies = $_SESSION['favoris'];
                                }
                                if(is_array($favCookies)){
                                    foreach($favCookies as $fav){
                                        if(is_array($favBDD)){
                                            if(!in_array($fav, $favBDD, true)){
                                                $favoris = $favoris.'|'.$fav;
                                            }
                                        }else{
                                            if($fav != $favBDD){
                                                if($favoris != "") {
                                                    $favoris = $favoris . '|' . $fav;
                                                }else{
                                                    $favoris = $fav;
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    if(is_array($favBDD)){
                                        if(!in_array($favCookies, $favBDD, true)){
                                            $favoris = $favoris.'|'.$favCookies;
                                        }
                                    }else{
                                        if($favCookies != $favBDD){
                                            if($favoris != "") {
                                                $favoris = $favoris . '|' . $favCookies;
                                            }else{
                                                $favoris = $favCookies;
                                            }
                                        }
                                    }
                                }
                            }
                            $sqlUpdate = "UPDATE users set favoris = '".$favoris."' WHERE id = ".$id;
                            $stmtUpdate = mysqli_prepare($link, $sqlUpdate);
                            if ($stmtUpdate) {
                                mysqli_stmt_execute($stmtUpdate);
                            }
                            $_SESSION["favoris"]=$favoris;

                            // Redirection de l'utilisateur vers l'accueil
                            header("location: ../index.php");
                        } else{
                        // Si le mot de passe n'est pas bon: erreur
                            $password_err = "Le mot de passe entré n'est pas valide.";

                        }
                    }
                } else{
                    // Si le pseudo n'existe pas: erreur
                    $username_err = "Aucun compte lié à ce pseudo.";

                }
            } else{
                echo "Erreur. Essayez ultérieurement.";
            }

            // Fermeture statement
            mysqli_stmt_close($stmt);
        }
    }

    // Fermeture
    mysqli_close($link);
}
?>

<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Projet boissons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
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
                                          onclick="location.href='deconnexion/index.php' ">Se déconnecter
                                </button>
                            <?php }  else{ ?><button type="button" class="btn  wthree-link-bnr bg-transparent text-secondary"
                                                     onclick="location.href='#' ">Se connecter
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
                                        <a class="nav-link scroll" href="../mes_favoris/index.php">Mes cocktails préférés</a>
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
    <!-- //header -->


    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-theme2">
                <h5 class="modal-title" id="exampleModalLabel">Connexion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label for="pseudo" class="col-form-label">Pseudo</label>
                        <input type="text" class="form-control border" placeholder="pseudo" name="pseudo" id="pseudo"
                               required="" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label for="password" class="col-form-label">Mot de passe</label>
                        <input type="password" class="form-control border" placeholder="******" name="password" id="password"
                               required="">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control border text-white bg-theme" value="Se connecter">
                    </div>

                    <div class="row sub-w3l my-3">
                        <div class="col forgot-w3l text-right text-secondary">
                            <a href="#" class="text-white">Mot de passe oublié?</a>
                        </div>
                    </div>
                    <p class="text-center text-secondary">Pas de compte?
                        <a href="../creation_compte/index.php"  class="text-dark font-weight-bold">
                            Créez-en un!</a>
                    </p>
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

    <!-- Template scripts -->
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