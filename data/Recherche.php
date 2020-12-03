<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tests recherche</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        let usedSearch = false;
        function liste(){
            document.getElementById("liste").innerHTML = "";
            match = document.getElementById('search').value;
            if(match != "") {
                traitementRecettes(match, function (recs){
                    if (recs.titre[0] != "none") {
                        //document.getElementById("liste").innerHTML += '<option>Recettes</option>';
                        for (let i = 0; i < recs.titre.length; i++) {
                            document.getElementById("liste").innerHTML += '<option value="' + recs.titre[i] + '">Recette : ' + recs.titre[i] + '</option>';
                        }
                    }
                });
                traitementIngredients(match, function (ings) {
                    if (ings.nom[0] != "none") {
                        //document.getElementById("liste").innerHTML += '<option style="background-color: aqua;">Ingrédients</option>';
                        for (let i = 0; i < ings.nom.length; i++) {
                            document.getElementById("liste").innerHTML += '<option value="' + ings.nom[i] + '"/>Ingrédient : ' + ings.nom[i] + '</option>';
                        }
                    }
                });
            }
        }
        function traitementRecettes(match, traitement){
            $.ajax({
                type: 'POST',
                url: 'TraitementRecettes.php',
                data: {func: 'matchNom', var: match},
                dataType: 'JSON',
                success: function (ret) {
                    recs = JSON.parse(ret);
                    traitement(recs);
                }
            });
        }
        function traitementIngredients(match, traitement){
            $.ajax({
                type: 'POST',
                url: 'TraitementHierarchie.php',
                data: {func: 'matchNom', var: match},
                dataType: 'JSON',
                success: function (ret) {
                    ings = JSON.parse(ret);
                    traitement(ings);
                }
            })
        }
        function afficherResultats(){
            usedSearch = true;
            match = document.getElementById('search').value;
            document.getElementById("ResSearch").innerHTML = '<h1>Liste des résultats pour "' + match +'"</h1><ul id="listeResults" style="overflow: auto; width: 750px">';
            if(match != "") {
                traitementRecettes(match, function (recs){
                    if (recs.titre[0] != "none") {
                        for (let i = 0; i < recs.titre.length; i++) {
                            document.getElementById("listeResults").innerHTML += '<li href="Recettes.php?nom=' + recs.titre[i] + '" style="overflow: visible">Recette : ' + recs.titre[i] + '</li>';
                        }
                    }
                });
                traitementIngredients(match, function (ings) {
                    if (ings.nom[0] != "none") {
                        for (let i = 0; i < ings.nom.length; i++) {
                            document.getElementById("listeResults").innerHTML += '<li href="Ingredients.php?nom=' + ings.nom[i] + '" style="overflow: visible"/>Ingrédient : ' + ings.nom[i] + '</li>';
                        }
                    }
                });
            }
            document.getElementById("ResSearch").innerHTML += "</ul>";
        }
        $(document).ajaxStop(function (){
            if(usedSearch) {
                if (document.getElementById("listeResults").childElementCount == 0) {
                    document.getElementById("listeResults").style.visibility = "hidden";
                    document.getElementById("ResSearch").innerHTML = '<h1>Liste des résultats pour "' + match + '"</h1><h2>Aucun résultat trouvé pour cette recherche.</h2>';
                }
            }
        })
    </script>
</head>
<body>
    <div>
        <input style="width: 500px;" list="liste" type="text" name="rechercheBoissons" placeholder="Rechercher.." id="search" oninput="liste()">
        <button onclick="afficherResultats()"><img style="max-height: 15px" src="../images/search.webp"></button>
        <datalist id="liste"></datalist>
    </div>
    <div id="ResSearch"></div>
</body>
