<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Index des recettes";}?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function load(nomRec){
            if(nomRec == "index"){
                $.ajax({
                    type:'POST',
                    url:'TraitementRecettes.php',
                    data:{func:'all'},
                    dataType:'JSON',
                    success:function(retRec){
                        let liste = JSON.parse(retRec);
                        for(let i = 0; i < liste.titre.length; i++) {
                            document.getElementById("liste").innerHTML += '<a href="?nom=' +liste.titre[i] + '">' + liste.titre[i] + '</a><br/>';
                        }
                    }
                })
            }else{
                $.ajax({
                    type:'POST',
                    url:'TraitementRecettes.php',
                    data:{func:'recNom', var:nomRec},
                    dataType:'JSON',
                    success:function(retRec){
                        let recette = JSON.parse(retRec);
                        let ing = recette.ingredients.split('|');
                        for (let i = 0; i < ing.length; i++) {
                            document.getElementById("ingredientsPrep").innerHTML += ing[i] + "<br/>";
                        }
                        document.getElementById("recette").innerHTML = recette.preparation;
                        for(let i = 0; i < recette.index.length; i++){
                            document.getElementById("ingredients").innerHTML += '<a href="Ingredient.php?nom=' + recette.index[i] + '">' + recette.index[i] + "</a><br/>";
                        }
                    }
                })
            }
        }
    </script>
</head>
<body onload="load('<?php if(isset($_GET['nom'])){echo preg_replace('/\'/', '\\\'', $_GET['nom']);}else{echo "index";}?>')">
<h1><?php if(isset($_GET['nom'])){echo "Recette du/de la ".$_GET['nom'];}else{echo "Index des recettes";}?></h1>
<?php
    if(isset($_GET['nom'])){
        echo "<h2>Ingrédients nécéssaires :</h2>";
        echo "<p id='ingredientsPrep'></p>";
        echo "<h2>Préparation :</h2>";
        echo "<p id='recette'></p>";
        echo "<h2>Liste des ingrédients :</h2>";
        echo "<p id='ingredients'></p>";
    }else{
        echo "<p id = 'liste'></p>";
    }
?>
</body>
</html>