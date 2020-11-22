<?php // Cr�ation de la base de donn�es

function query($link,$requete)
{
    $resultat=mysqli_query($link,$requete) or die("$requete : ".mysqli_error($link));
    return($resultat);
}


$mysqli=mysqli_connect('localhost', 'root', '') or die("Erreur de connexion");
$base="Boissons";
$Sql="
		DROP DATABASE IF EXISTS $base;
		CREATE DATABASE $base;
		USE $base;
		CREATE TABLE users (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, mail VARCHAR(255), pseudo VARCHAR(30) NOT NULL, 
		nom VARCHAR(30) , prenom VARCHAR(30) ,
		 password VARCHAR(30) NOT NULL, phone VARCHAR(30), birthdate DATE, 
		 adresse VARCHAR(50), cpville VARCHAR(50),ville VARCHAR(50), sexe VARCHAR(20), favoris VARCHAR(500));
		 
		 INSERT INTO users VALUES (1, '','pseudotest','','','admin123','','','','','','','');
		";

//foreach(explode(';',$Sql) as $Requete) query($mysqli,$Requete);

mysqli_close($mysqli);
?>