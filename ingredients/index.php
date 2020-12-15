<?php
//Initialisation de la session
session_start();
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
    <title><?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../data/sidebar.js">
    </script>
    <script type="text/javascript">
        let resRec = Array();
        let resSubIng = Array();
        let resSupIng = Array();
        let resSurIng = Array();
        function load(nomIng){
            $.ajax({
                type:'POST',
                url:'../data/TraitementHierarchie.php',
                data:{func:'sur', var:nomIng},
                dataType:'JSON',
                success: function (retSurIng){
                    nomSur = JSON.parse(retSurIng);
                    for(let i = nomSur.nom.length-1; i >= 0; i--){
                        resSurIng.push(nomSur.nom[i]);
                    }
                }
            })
            $.ajax({
                type:'POST',
                url:'../data/TraitementRecettes.php',
                data:{func:'recInd', var:nomIng},
                dataType: 'JSON',
                success: function(retRec){
                    idRec = JSON.parse(retRec);
                    if(idRec.index[0] != "none"){
                        for (let i = 0; i < idRec.index.length; i++) {
                            $.ajax({
                                type: 'POST',
                                url: '../data/TraitementRecettes.php',
                                data: {func: 'recNum', var: idRec.index[i]},
                                dataType: 'JSON',
                                success: function (recs) {
                                    resRec.push(recs.titre);
                                }
                            })
                        }
                    }
                }
            })
            $.ajax({
                type:'POST',
                url:'../data/TraitementHierarchie.php',
                data:{func:'sub', var:nomIng},
                dataType:'JSON',
                success: function (retSubIng){
                    subs = JSON.parse(retSubIng);
                    if(subs.nom[0] != "none"){
                        for(let i=0; i<subs.nom.length; i++) {
                            resSubIng.push(subs.nom[i]);
                        }
                    }
                }
            })
            $.ajax({
                type:'POST',
                url:'../data/TraitementHierarchie.php',
                data:{func:'sup', var:nomIng},
                dataType:'JSON',
                success: function (retSupIng){
                    sups = JSON.parse(retSupIng);
                    if(sups.nom[0] != "none"){
                        for(let i=0; i<sups.nom.length; i++) {
                            resSupIng.push(sups.nom[i]);
                        }
                    }
                }
            })
        }
        $(document).ajaxStop( function() {
            for (let i = 0; i < resSurIng.length; i++) {
                if(i != resSurIng.length-1){
                    document.getElementById('surIng').innerHTML += '<a href="?nom=' + resSurIng[i] + '">' + resSurIng[i] + '</a>&nbsp;&nbsp;&nbsp;<img style="max-height: 10px;" src="../assets/images/next.png"/>&nbsp;&nbsp;&nbsp;';
                }else{
                    document.getElementById('surIng').innerHTML += resSurIng[i];
                }
            }
            for (let i = 0; i < resRec.length; i++) {
                document.getElementById('listeRecettes').innerHTML += '<a href="../recettes/index.php?nom='+ resRec[i] + '">' + resRec[i] + '</a><br/>';
            }
            for (let i = 0; i < resSubIng.length; i++) {
                document.getElementById('sousIng').innerHTML +='<a href="?nom=' + resSubIng[i] + '">' + resSubIng[i] + '</a><br/>';
            }
            for (let i = 0; i < resSupIng.length; i++) {
                document.getElementById('supIng').innerHTML +='<a href="?nom=' + resSupIng[i] + '">' + resSupIng[i] + '</a><br/>';
            }
        });
    </script>
</head>

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
<body onload="load('<?php if(isset($_GET['nom'])){echo preg_replace('/\'/', '\\\'', $_GET['nom']);}else{echo "Aliment";}?>');  sidebar();">



<div class="row">
    <div class="col-lg-3 border-left">
        <ul id = 'sidebar' class='text-center' style='background-color: mediumpurple; cursor: pointer; border-radius: 10px '></ul>
    </div>
    <div class="align-content-center col-lg-9" >
        <h2 class='text-center' style='color: #5341b4'>Liste hiérarchie</h2>
        <p class="text-center" id="surIng"></p>
        <br>
        <h2 class='text-center' style='color: #5341b4'>Listes des recettes dans lesquelles est utilisé le/la <?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?></h2>
        <p class="text-center" id="listeRecettes"></p>
        <br>
        <h2 class='text-center' style='color: #5341b4'>Liste des sous-ingrédients</h2>
        <p class="text-center" id="sousIng"></p>
        <br>
        <h2 class='text-center' style='color: #5341b4'>Liste des sur-ingrédients</h2>
        <p class="text-center" id="supIng"></p>
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


</body>
</html>