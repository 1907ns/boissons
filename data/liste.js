//La fonction traitementRecettes permet de récupérer les données des recettes par comparaison avec Ajax et de les traiter de façon synchrone
function traitementRecettes(match, url, traitement){
    $.ajax({
        type: 'POST',
        url: url,
        data: {func: 'matchNom', var: match},
        dataType: 'JSON',
        success: function (ret) {
            let recs = JSON.parse(ret);
            traitement(recs);
        }
    });
}

//La fonction traitementRecettesContient permet de récupérer les données des recettes qui contiennent un certain ingrédient avec Ajax et de les traiter de façon synchrone
function traitementRecetteContient(ing,url, traitement){
    $.ajax({
        type: 'POST',
        url: url,
        data: {func: 'recIng', var: ing},
        dataType: 'JSON',
        success: function (ret) {
            let recs = JSON.parse(ret);
            traitement(recs);
        }
    });
}

//La fonction traitementIngredients permet de récupérer les données des ingrédients par comparaison avec Ajax et de les traiter de façon synchrone
function traitementIngredients(match, url, traitement){
    $.ajax({
        type: 'POST',
        url: url,
        data: {func: 'matchNom', var: match},
        dataType: 'JSON',
        success: function (ret) {
            let ings = JSON.parse(ret);
            traitement(ings);
        }
    })
}

//La fonction traitementSousCateg permet de récupérer les données des sous ingrédients d'ingrédient donné avec Ajax et de les traiter de façon synchrone
function traitementSousCateg(nomSource, url, traitement){
    $.ajax({
        type:'POST',
        url:url,
        data:{func: 'sub', var:nomSource},
        dataType: 'JSON',
        success: function (ret){
            let subs = JSON.parse(ret);
            traitement(subs);
        }
    })
}



// Fonction permettant de lister les propositions sous la barre de recherche
function liste(url1, url2){
    document.getElementById("liste").innerHTML = "";
    //On récupère la valeur qu'on essaiera de faire "matcher" pour retrouver différentes propositions
    match = document.getElementById('search').value;
    //On ne fait rien tant que la barre de recherche est vide
    if(match != "") {
        //On appelle la fonction traitementRecettes, qui va réaliser l'appel Ajax pour obtenir les valeurs ressemblant au match passé en paramètre
        //Cette fonction va ensuite, dans l'appel Ajax, appeler la fonction passée en paramètre avec le résultat, ce qui permet un traitement synchrone de l'information
        //Un traitement synchrone permet d'attendre que la totalité des informations soient récupérées avant de les utiliser
        traitementRecettes(match, url1,function (recs){
            if (recs.titre[0] != "none") {
                for (let i = 0; i < recs.titre.length; i++) {
                    document.getElementById("liste").innerHTML += '<option value="' + recs.titre[i] + '">Recette : ' + recs.titre[i] + '</option>';
                }
            }
        });
        //Autour de l'appel à la fonction traitementRecettes, le traitement est asynchrone, ce qui veut dire que la suite du code s'exécute en parallèle de l'appel à traitementRecettes
        //On appelle la fonction traitementIngredients, qui traite l'information de façon synchrone, comme traitementRecettes
        traitementIngredients(match, url2,function (ings) {
            if (ings.nom[0] != "none") {
                for (let i = 0; i < ings.nom.length; i++) {
                    document.getElementById("liste").innerHTML += '<option value="' + ings.nom[i] + '"/>Ingrédient : ' + ings.nom[i] + '</option>';
                }
            }
        });
    }
}