<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Cafe Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />

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
    <script type="text/javascript">
        let resLoad = "";
        let resSM = "";
        let isSM = false;
        let nomSM = "";
        function sidebar(){
            $.ajax({
                type:"POST",
                url:"../data/TraitementHierarchie.php",
                data:{func:'base'},
                dataType:'JSON',
                success: function(ret){
                    result = JSON.parse(ret);
                    if(result.fail == "true"){
                        alert("Erreur de chargement de la sidebar")
                    }else{
                        for (let i = 0; i < result.nom.length; i++) {
                            resLoad += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../data/Ingredient.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + result.nom[i] + '\')"/></span></li>';
                        }
                    }
                }
            })
        }
        function sousMenu(nom){
            resSM = "";
            isSM = true;
            nomSM = nom;
            if(document.getElementById(nom).parentElement.value){
                document.getElementById(nom).parentElement.innerHTML = '<li value=0><span id="' + nom + '" onclick="window.location.href=\'../data/Ingredient.php?nom=' + nom + '\'">' + nom + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + nom + '\')"/></li>';
            }else {
                document.getElementById(nom).parentElement.innerHTML = '<li value=0><span id="' + nom + '" onclick="window.location.href=\'../data.Ingredient.php?nom=' + nom + '\'">' + nom + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../images/rewind.png" style="max-width:20px;" onclick="sousMenu(\'' + nom + '\')"/></li>';
                $.ajax({
                    type: "POST",
                    url: "../data/TraitementHierarchie.php",
                    data: {func: 'sub', var: nom},
                    dataType:'JSON',
                    success: function (ret) {
                        result = JSON.parse(ret);
                        if (result.fail == "true") {
                            alert("Erreur de chargement de sous-menu")
                        } else {
                            for (let i = 0; i < result.nom.length; i++) {
                                hasNext(result.nom[i],function(ret){
                                    resultat = JSON.parse(ret);
                                    retour = true;
                                    if(resultat.nom[0] == "none") {
                                        retour = false;
                                    }
                                    if(retour){
                                        resSM += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../data/Ingredient.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + result.nom[i] + '\')"/></span></li>';
                                    }else{
                                        resSM += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../data/Ingredient.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '</span></li>';
                                    }
                                });
                            }
                        }
                    }
                })
            }
        }
        function hasNext(nom, traitement){
            $.ajax({
                type:'POST',
                url: "../data/TraitementHierarchie.php",
                data: {func: 'sub', var: nom},
                dataType:'JSON',
                success:function(ret){
                    traitement(ret);
                }
            })
        }
        $(document).ajaxStop(function(){
            if(!isSM) {
                document.getElementById('sidebar').innerHTML = resLoad;
            }else{
                document.getElementById(nomSM).parentElement.value = true;
                document.getElementById(nomSM).parentElement.innerHTML += resSM;
            }
        })
    </script>
    <script type="text/javascript">
        function load(nomRec){
            if(nomRec == "index"){
                $.ajax({
                    type:'POST',
                    url:'../data/TraitementRecettes.php',
                    data:{func:'all'},
                    dataType:'JSON',
                    success:function(retRec){
                        let liste = JSON.parse(retRec);
                        var cocktails = document.getElementById('cocktails');
                        for(let i = 0; i < liste.titre.length; i++) {
                            var div = document.createElement('div');
                            div.className = 'col-lg-4';

                            var onecocktail =
                                '                    <div class="img-grid">' +
                                '                        <div class="Portfolio-grid1">' +
                                '                            <img src="../Projet/Photos/Raifortissimo.jpg" alt=" " class="img-fluid" />' +
                                '                        </div>' +
                                '                        <div class="port-desc text-center">' +
                                '                            <h6 class="main-title-w3pvt text-center">'+ liste.titre[i] +'</h6>' +
                                '                            <a href="?nom=' +liste.titre[i] + '" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>' +
                                '                        </div>' +
                                '                    </div>'

                            div.innerHTML = onecocktail.trim();
                            //document.getElementById("liste").innerHTML += '<a href="?nom=' +liste.titre[i] + '">' + liste.titre[i] + '</a><br/>';
                            //document.getElementById("liste").innerHTML +=
                            cocktails.appendChild(div);
                        }
                    }
                })
            }else{
                $.ajax({
                    type:'POST',
                    url:'../data/TraitementRecettes.php',
                    data:{func:'recNom', var:nomRec},
                    dataType:'JSON',
                    success:function(retRec){
                        let recette = JSON.parse(retRec);
                        let ing = recette.ingredients.split('|');

                        var cocktails = document.getElementById('cocktails');
                        for (let i = 0; i < ing.length; i++) {

                            document.getElementById("ingredientsPrep").innerHTML += ing[i] + "<br/>";
                        }
                        document.getElementById("recette").innerHTML = recette.preparation;
                        for(let i = 0; i < recette.index.length; i++){
                            document.getElementById("ingredients").innerHTML += '<a href="../data/Ingredient.php?nom=' + recette.index[i] + '">' + recette.index[i] + "</a><br/>";
                        }
                    }
                })
            }
        }

        /** FONCTION START POUR LA SIDEBAR ET LES COCKTAILS */
        function start(){
            load(<?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo 'index';}?>);
            sidebar();
        }
    </script>
</head>
<body onload="start()">


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
<h1></h1>




<!-- populaires -->
<section class="portfolio-wthree align-w3" id="populaires">
    <div class="container-fluid">
        <div class="title-w3ls text-center">
            <h4 class="w3pvt-title"><?php if(isset($_GET['nom'])){echo "Recette du/de la ".$_GET['nom'];}else{echo "Toutes nos recettes";}?></h4>
        </div>
        <?php

        if(isset($_GET['nom'])){ ?>
        <div class="align-content-center col-lg-12" >
        <?php   echo "<h2 class='text-center'>Ingrédients nécéssaires :</h2>";
            echo "<p id='ingredientsPrep' class='card-text text-center'></p>";
        echo "<br>";
            echo "<h2 class='text-center'>Préparation :</h2>";
            echo "<div class='row' >";
            echo "<div class='col-3 justify-content-center' ></div>";
            echo "<div class='col-6 justify-content-center' >";
            echo "<p id='recette' class='text-center'></p>";
            echo "</div>";
            echo "<div class='col-3 justify-content-center' ></div>";
            echo "</div>";
            echo "<br>";
            echo "<h2 class='text-center'>Liste des ingrédients :</h2>";
            echo "<p id='ingredients' class='card-text text-center'></p>";
            echo "<br>";
        ?> </div> <?php }else {
        ?>

        <div class="row" id="cocktails">

                <?php echo "<div class='col-lg-3 border-left'>
                                <ul id = 'sidebar' class='text-center' style='background-color: #ede1f1; cursor: pointer; '></ul>
                            </div>
                            <div class='col-lg-9' id = 'liste'></div>";
                }?>
        </div>
    </div>
</section>


</body>
</html>