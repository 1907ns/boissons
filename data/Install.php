<?php // Création de la base de données

function query($link,$requete)
{
    $resultat=mysqli_query($link,$requete) or die("$requete : ".mysqli_error($link));
    return($resultat);
}


$mysqli=mysqli_connect('localhost', 'root', '') or die("Erreur de connexion");
$base="boissons";
$Sql="
		DROP DATABASE IF EXISTS $base;
		CREATE DATABASE $base;
		USE $base;
		CREATE TABLE users (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, mail VARCHAR(255), pseudo VARCHAR(30) NOT NULL UNIQUE, 
		nom VARCHAR(30) , prenom VARCHAR(30) ,
		 password VARCHAR(255) NOT NULL, phone VARCHAR(30), birthdate VARCHAR(50), 
		 adresse VARCHAR(50), cpville VARCHAR(50),ville VARCHAR(50), sexe VARCHAR(20), favoris VARCHAR(500));
		 
		 
		";

foreach(explode(';',$Sql) as $Requete) query($mysqli,$Requete);

mysqli_close($mysqli);
?>