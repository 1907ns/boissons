<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
//Initialisation de la session
ini_set('error_reporting',-1);
ini_set('display_errors', 'on');
session_start();


// Vérifier si l'utilisateur est déjà connecté, si oui le rediriger vers la page d'accueil
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
//connexion à la BDD
$link= mysqli_connect("localhost", "root", "", "boissons");

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
        $sql = "SELECT id, pseudo, password FROM users WHERE pseudo = ?";
        $hashed_password= "SELECT password FROM users WHERE pseudo = ?";
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
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){

                        //Vérifier sue le mot de passe saisie correspons au hash
                        if(password_verify($password, $hashed_password)){

                        // Le mot de pase est correct, start d'une nouvelle session
                            session_start();

                            // Enregistrement des données dans les cookies
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["pseudo"] = $username;

                            // Redirection de l'utilisateur vers l'accueil
                            header("location: ../index.php");
                        } else{
                        // Si le mot de passe n'est pas bon: erreur
                            $password_err = "The password you entered was not valid.";
                            echo $hashed_password; echo '<br>'; echo $password;
                        }
                    }
                } else{
                    // Si le pseudo n'existe pas: erreur
                    $username_err = "No account found with that username.";

                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo 'error';
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
    <link href="..///fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link href="..///fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>
<!-- Login modal -->
<body>



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
                    <input type="password" class="form-control border" placeholder="********" name="password" id="password"
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
                    <a href="#" data-toggle="modal" data-target="#exampleModal1" class="text-dark font-weight-bold">
                        Créez-en un!</a>
                </p>
            </form>
        </div>
    </div>
</div>

<!-- //Login modal -->
</body>