<?php
// Include config file
require "../data/config.php";


// Definition des variables
$username = $password  = "";
$username_err = $password_err  = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validation du pseudo
    if(empty(trim($_POST["pseudo"]))){
        $username_err = "Please enter a username.";
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

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["pseudo"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Vaidation du mot de passe
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }




    // Verifier s'il n'y a pas d'erreurs
    if(empty($username_err) && empty($password_err)){

        // Insertion du nouvelle utilisateur dans la BDD
        $sql = "INSERT INTO users (pseudo, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables 
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parametres
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ../connexion/index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

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
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
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
                                                     onclick="location.href='../connexion/index.php' ">Se connecter
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
                                        <a class="nav-link" href="../index.php">Accueil
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
                                        <li class="nav-item   mr-lg-3">
                                            <a class="nav-link scroll" href="../compte/index.php">Mon Compte</a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item mr-lg-3 ">
                                        <form action="" class="nav-link scroll">
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
                <h5 class="modal-title" id="exampleModalLabel1">S'enregister</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="pseudo" class="col-form-label">Pseudo</label>
                        <input type="text" class="form-control border" placeholder="Enes88" name="pseudo" id="pseudo"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="nomuser" class="col-form-label">Nom</label>
                        <input type="text" class="form-control border" placeholder="Ayata" name="nomuser" id="nomuser"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="prenomuser" class="col-form-label">Prénom</label>
                        <input type="text" class="form-control border" placeholder="Enes" name="prenomuser" id="prenomuser"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="emailuser" class="col-form-label">Email</label>
                        <input type="email" class="form-control border" placeholder="username@email.com" name="emailuser"
                               id="emailuser" required="">
                    </div>
                    <div class="form-group">
                        <label for="telephone" class="col-form-label">Numéro de tél.</label>
                        <input type="tel" class="form-control border" placeholder="0123456789" name="telephone"
                               id="telephone" >
                    </div>
                    <div class="form-group">
                        <label for="dnaissance" class="col-form-label">Date de naissance</label>
                        <input type="text" class="form-control border" placeholder="********" name="dnaissance"
                               id="dnaissance" required="">
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="col-form-label">Adresse</label>
                        <input type="text" class="form-control border" placeholder="19 rue des cerisiers" name="adresse"
                               id="adresse" required="">
                    </div>
                    <div class="form-group">
                        <label for="cpville" class="col-form-label">CP </label>
                        <input type="text" class="form-control border" placeholder="54000" name="cpville"
                               id="cpville" required="">
                    </div>
                    <div class="form-group">
                        <label for="ville" class="col-form-label">Ville</label>
                        <input type="text" class="form-control border" placeholder="Nancy" name="ville"
                               id="ville" required="">
                    </div>
                    <div class="form-group">
                        <label for="sexe" class="col-form-label">Sexe:</label>

                        <select name="sexe" id="sexe" class="form-control border">
                            <option value="NF">Non défini</option>
                            <option value="M">M</option>
                            <option value="M">F</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label">Mot de passe</label>
                        <input type="password" class="form-control border" placeholder="********" name="password" id="password"
                               required="">
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control bg-theme text-white" value="Valider">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<?php mysqli_report(MYSQLI_REPORT_ALL); ?>