<?php

define('DB_SERVER', 'localhost'); //server localhost pour l'éxécution du projet en local
define('DB_USERNAME', 'root'); //pseudo 'root' pour la connexion à la bdd via phpMyAdmin
define('DB_PASSWORD', '');//Mot de passe vide pour la connexion à phpMyAdmin (sur Windows)
define('DB_NAME', 'boissons');//nom de la base de données

// Tentative de connexion à la base de données MySQL
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// vérification de la vonnexion
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>