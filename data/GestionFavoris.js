
let resFav = "";


function ajouterFav(id){
    $.ajax({ url: '../data/GestionFavoris.php',
            data: {func: 'ajout',var: id},
            type: 'POST',
            //dataType: 'JSON',
            success: function(output) {
                //console.log(output);
                //console.log(id);
                alert("Ce cocktail a bien été ajouté à votre panier");
            }
        });

}


function supprimerFav(nom){
    $.ajax({ url: '../data/GestionFavoris.php',
        data: {func:'suppr',var: nom},
        type: 'POST',
        success: function(output) {
            alert("Ce cocktail a bien été supprimé votre panier");
        }
    });
}

function getFav(){
    document.getElementById("ResFav").innerHTML = '<h2 class="text-center"  style=\'color: #5341b4\'>Mes recettes préférées </h><p id="listeResults" style="justify-content: center">';
    $.ajax({
        type: "POST",
        url: "../data/TraitementHierarchie.php",
        data: {func: 'get'},
        dataType:'JSON',
        success: function (ret) {
            result = JSON.parse(ret);
            if (result.fail == "true") {
                alert("Erreur de chargement des favoris");
            } else {
                for (let i = 0; i < result.tab.length; i++) {
                    hasNext(result.tab[i],function(ret){
                        resultat = JSON.parse(ret);
                        retour = true;
                        if(resultat == "none") {
                            retour = false;
                        }
                        $.ajax({
                            type:"POST",
                            url:"../data/TraitementRecettes.php",
                            data:{func:'recNum', var:result.tab[i]},
                            dataType:'JSON',
                            success: function(ret){
                                document.getElementById("ResFav").innerHTML += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' +ret + '" onclick="window.location.href=\'../recettes/index.php?nom=' + ret + '\'"></span></li>';
                            }
                        })
                    });
                }
            }
        }
    })
}