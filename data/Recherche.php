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
                    let recs = JSON.parse(ret);
                    traitement(recs);
                }
            });
        }

        function traitementRecetteContient(ing, traitement){
            $.ajax({
                type: 'POST',
                url: 'TraitementRecettes.php',
                data: {func: 'recIng', var: ing},
                dataType: 'JSON',
                success: function (ret) {
                    let recs = JSON.parse(ret);
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
                    let ings = JSON.parse(ret);
                    traitement(ings);
                }
            })
        }

        function traitementSousCateg(nomSource, traitement){
            $.ajax({
                type:'POST',
                url:'TraitementHierarchie.php',
                data:{func: 'sub', var:nomSource},
                dataType: 'JSON',
                success: function (ret){
                    let subs = JSON.parse(ret);
                    traitement(subs);
                }
            })
        }

        function afficherResultats(){
            usedSearch = true;
            let allIngs = Array();
            let recAff = Array();
            let dernierIng = false;
            let match = document.getElementById('search').value;
            document.getElementById("ResSearch").innerHTML = '<h1>Liste des résultats pour "' + match +'"</h1><ul id="listeResults" style="overflow: auto; width: 750px">';
            if(match != "") {
                traitementIngredients(match, function (ings) {
                    if (ings.nom[0] != "none") {
                        for (let i = 0; i < ings.nom.length; i++) {
                            document.getElementById("listeResults").innerHTML += '<li style="overflow: visible"/><a href="Ingredient.php?nom=' + ings.nom[i] + '"> Ingrédient : ' + ings.nom[i] + '</a></li>';
                            if (!allIngs.includes(ings.nom[i])) {
                                allIngs.push(ings.nom[i]);
                            }
                            if(i == ings.nom.length-1){
                                dernierIng=true;
                            }
                            traitementSousCateg(ings.nom[i], function (subs) {
                                if (subs.nom[0] != "none") {
                                    for (let i = 0; i < subs.nom.length; i++) {
                                        document.getElementById("listeResults").innerHTML += '<li style="overflow: visible"/><a href="Ingredient.php?nom=' + subs.nom[i] + '"> Sous-ingrédient : ' + subs.nom[i] + '</a></li>';
                                        if (!allIngs.includes(subs.nom[i])) {
                                            allIngs.push(subs.nom[i]);
                                        }
                                    }
                                }
                                if(dernierIng){
                                    afficherRecettesContenant(allIngs, recAff);
                                }
                            });
                        }
                    }
                });
                traitementRecettes(match, function (recs){
                    if (recs.titre[0] != "none") {
                        for (let i = 0; i < recs.titre.length; i++) {
                            recAff.push(recs.titre[i]);
                            document.getElementById("listeResults").innerHTML += '<li style="overflow: visible"><a href="Recette.php?nom=' + recs.titre[i] + '">Recette : ' + recs.titre[i] + '</a></li>';
                        }
                    }
                });
            }
            document.getElementById("ResSearch").innerHTML += "</ul>";
        }

        function afficherRecettesContenant(allIngs, recAff){
            for (let i = 0; i < allIngs.length; i++) {
                traitementRecetteContient(allIngs[i], function (recs) {
                    if (recs.titre[0] != "none") {
                        for (let j = 0; j < recs.titre.length; j++) {
                            if (!recAff.includes(recs.titre[j])) {
                                recAff.push(recs.titre[j]);
                                document.getElementById("listeResults").innerHTML += '<li style="overflow: visible"><a href="Recette.php?nom=' + recs.titre[j] + '">Recette contenant "' + allIngs[i] + '" : ' + recs.titre[j] + '</a></li>';
                            }
                        }
                    }
                });
            }
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
