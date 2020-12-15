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
    <script  src="../data/liste.js"></script>
    <script>let usedSearch = false;
        //La fonction affciherResultats permet d'afficher les résultats de la recherche
        function afficherResultats(match, url){
            usedSearch = true;
            let allIngs = Array();
            let recAff = Array();
            let dernierIng = false;
            //On récupère la valeur qu'on essaiera de faire "matcher" pour retrouver différents résultats
            //let match = document.getElementById('search').value;
            document.getElementById("ResSearch").innerHTML = '<h2 class="text-center"  style=\'color: #5341b4\'>Liste des résultats pour "' + match +'"</h><p id="listeResults" style="justify-content: center">';
            if(match != "") {
                //On appelle la fonction traitementIngredients pour récupérer les différents ingrédients correspondant au match et les traiter de façon asynchrone
                traitementIngredients(match,'../data/TraitementHierarchie.php', function (ings) {
                    //On ne fait rien si aucun argument ne correspond à la recherche
                    if (ings.nom[0] != "none") {
                        for (let i = 0; i < ings.nom.length; i++) {
                            document.getElementById("listeResults").innerHTML += '<li style="overflow: visible; font-size: medium"/><a href="../ingredients/index.php?nom=' + ings.nom[i] + '"> Ingrédient : ' + ings.nom[i] + '</a></li>';
                            if (!allIngs.includes(ings.nom[i])) {
                                allIngs.push(ings.nom[i]);
                            }
                            //On prévient qu'on se trouve sur le dernier ingrédient
                            if(i == ings.nom.length-1){
                                dernierIng=true;
                            }
                            //On appelle la fonction traitementSousCateg pour récupérer les sous ingrédients de chaque ingrédient récupéré par la recherche et les traiter de façon synchrone
                            traitementSousCateg(ings.nom[i], '../data/TraitementHierarchie.php', function (subs) {
                                if (subs.nom[0] != "none") {
                                    for (let i = 0; i < subs.nom.length; i++) {
                                        document.getElementById("listeResults").innerHTML += '<li style="overflow: visible; font-size: medium"/><a href="../ingredients/index.php?nom=' + subs.nom[i] + '"> Sous-ingrédient : ' + subs.nom[i] + '</a></li>';
                                        if (!allIngs.includes(subs.nom[i])) {
                                            allIngs.push(subs.nom[i]);
                                        }
                                    }
                                }
                                //Si on est sur le dernier ingrédient (et qu'on a donc récupéré les derniers sous ingrédients), on lance l'affichage des recettes contenant tous ces ingrédients
                                if(dernierIng){
                                    afficherRecettesContenant(allIngs, recAff, url);
                                }
                            });
                        }
                    }
                });
                //On appelle traitementRecettes pour récupérer les données des recettes correspondant au match et les traiter de façon asynchrone
                traitementRecettes(match, '../data/TraitementRecettes.php', function (recs){
                    if (recs.titre[0] != "none") {
                        for (let i = 0; i < recs.titre.length; i++) {
                            //On on ajoute cette recette dans les recettes affichées à l'écran
                            recAff.push(recs.titre[i]);
                            document.getElementById("listeResults").innerHTML += '<li style="overflow: visible; font-size: medium"><a href="../recettes/index.php?nom=' + recs.titre[i] + '">Recette : ' + recs.titre[i] + '</a></li>';
                        }
                    }
                });
            }
            document.getElementById("ResSearch").innerHTML += "</p>";
        }

        //la fontion afficherRecettesContenant permet d'afficher les recettes contenant une liste d'ingrédients donnée
        function afficherRecettesContenant(allIngs, recAff, url){
            for (let i = 0; i < allIngs.length; i++) {
                //On appelle traitementRecetteContient pour récupérer les recettes contenant un ingrédient donné et traiter les données de façon synchrone
                traitementRecetteContient(allIngs[i], '../data/TraitementRecettes.php',function (recs) {
                    if (recs.titre[0] != "none") {
                        for (let j = 0; j < recs.titre.length; j++) {
                            if (!recAff.includes(recs.titre[j])) {
                                //On ajoute la recette dans les recettes affichées à l'écran
                                recAff.push(recs.titre[j]);
                                document.getElementById("listeResults").innerHTML += '<li style="overflow: visible"><a href="../recettes/index.php?nom=' + recs.titre[j] + '">Recette contenant "' + allIngs[i] + '" : ' + recs.titre[j] + '</a></li>';
                            }
                        }
                    }
                });
            }
        }

        //Quand toutes les requêtes ajax sont terminées
        $(document).ajaxStop(function (){
            //Si une recherche a été efféctuée
            if(usedSearch) {
                //Si le résultat de la recherche est vide on affiche un message indiquant que rien n'a été trouvé
                if (document.getElementById("listeResults").childElementCount === 0) {
                    document.getElementById("listeResults").style.visibility = "hidden";
                    document.getElementById("ResSearch").innerHTML = '<h2 class="text-center"  style="color: #5341b4">Liste des résultats pour "' + match + '"</h2><h4 class="text-center">Aucun résultat trouvé pour cette recherche.</h4>';
                }
            }
        })</script>
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
<!-- Login modal -->
<body  onload="afficherResultats('<?php if(isset($_GET['name'])){echo preg_replace('/\'/', '\\\'', $_GET['name']);}?>', '../data/');" >

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
                                    <a class="nav-link scroll" href="#">Mes cocktails préférés</a>
                                </li>
                                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
                                    <li class="nav-item   mr-lg-3">
                                        <a class="nav-link scroll" href="../compte/index.php">Mon Compte</a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item mr-lg-3 active">
                                    <form action="index.php" method="get" class="nav-link scroll" >
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

<div class="justify-content-center" id="ResSearch"></div>


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
</body>
</html>
<!-- //header -->