<?php
//Initialisation de la session
session_start();
include '../data/nom_image.php';
?>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script  src="../data/liste.js"></script>
    <script  src="../data/nom_image.js"></script>
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
    <script src="../data/sidebar.js">
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
                        var sidebar  = document.createElement('div');
                        sidebar.className = 'col-lg-3 border-left';
                        var sidebarhtml = ' <ul id = \'sidebar\' class=\'text-center\' style=\'background-color: mediumpurple; cursor: pointer; border-radius: 10px  \'></ul>\n'
                        sidebar.innerHTML= sidebarhtml.trim();
                        var divcocktail = document.createElement('div');
                        divcocktail.className='row col-lg-9';
                        cocktails.appendChild(sidebar);
                        cocktails.appendChild(divcocktail);
                        for(let i = 0; i < liste.titre.length; i++) {
                            var div = document.createElement('div');
                            var nom_im = name_str(liste.titre[i]);

                            /** Vérifier si la photo existe */
                            if(!doesFileExist('../Projet/Photos/'+nom_im+'.jpg')){
                                nom_im="Raifortissimo";
                            }
                            console.log(nom_im);
                            div.className = 'col-lg-6';
                            var onecocktail =
                                '                    <div class="img-grid" >' +
                                '                        <div class="Portfolio-grid1">' +
                                '                            <img style="width: 50%; height: 50%;" src="../Projet/Photos/' +nom_im + '.jpg" alt=" " class="img-fluid" />' +
                                '                        </div>' +
                                '                        <div class="port-desc text-center">' +
                                '                            <h6 class="main-title-w3pvt text-center">'+ liste.titre[i] +'</h6>' +
                                '                            <a href="?nom=' +liste.titre[i] + '" class="scroll text-capitalize serv_link btn bg-theme2">DECOUVRIR LA RECETTE</a>' +
                                '                        </div>' +
                                '                    </div>'

                            div.innerHTML = onecocktail.trim();
                            //document.getElementById("liste").innerHTML += '<a href="?nom=' +liste.titre[i] + '">' + liste.titre[i] + '</a><br/>';
                            //document.getElementById("liste").innerHTML +=

                            divcocktail.appendChild(div);
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
                            document.getElementById("ingredients").innerHTML += '<a href="../ingredients/index.php?nom=' + recette.index[i] + '">' + recette.index[i] + "</a><br/>";
                        }
                    }
                })
            }
        }

    </script>
</head>
<body onload="load('<?php if(isset($_GET['nom'])){echo preg_replace('/\'/', '\\\'', $_GET['nom']);}else{echo "index";}?>'); sidebar();">


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
                                    <a class="nav-link scroll" href="index.php">Tous nos cocktails</a>
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


<!-- populaires -->
<section class="portfolio-wthree align-w3" id="populaires">
    <div class="container-fluid">
        <div class="title-w3ls text-center">
            <h4 class="w3pvt-title"><?php if(isset($_GET['nom'])){echo "";}else{echo "Toutes nos recettes";}?></h4>
        </div>
        <?php

        if(isset($_GET['nom'])){ ?>
                <div class="row">
                    <div class="col-lg-3 border-left">
                        <ul id = 'sidebar' class='text-center' style='background-color: mediumpurple; cursor: pointer; border-radius: 10px '></ul>
                    </div>
                    <div class="align-content-center col-lg-9" >
                    <?php
                        $img = name_image($_GET['nom']); //nom de l'image sans espaces et caractères spéciaux
                        echo "<h1 class='text-center' style='color: #5341b4'> Recette de le/ la ". $_GET['nom'] . "</h1>";
                        echo "<br>";

                        //on affiche l'image si elle existe
                        if(file_exists("../Projet/Photos/" . $img . ".jpg")) {

                            echo "<div class='row' >";
                            echo "<div class='col-3 justify-content-center' ></div>";
                            echo "<div class='col-6 justify-content-center' >";
                            echo '<img class="align-self-center col-lg-6" src="../Projet/Photos/' . $img. '.jpg">';
                            echo "</div>";
                            echo "<div class='col-3 justify-content-center' ></div>";
                            echo "</div>";
                        }
                        echo "<h3 class='text-center'>Ingrédients nécéssaires :</h3>";
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
                        echo "<div class='row' >";
                        echo "<div class='col-3 justify-content-center' ></div>";
                        echo "<div class='col-6 justify-content-center' >";
                        echo '<a href="#" class="align-content-center scroll text-capitalize serv_link btn bg-theme2">AJOUTER AUX FAVORIS</a>';
                        echo '</div>';
                        echo "<div class='col-3 justify-content-center' ></div>";
                    ?> </div> </div><?php }else {
                    ?>

        <div class="row" id="cocktails">

                <?php echo "
                            <div  id = 'liste'></div>
                            ";
                }?>
        </div>
    </div>
</section>


</body>
</html>