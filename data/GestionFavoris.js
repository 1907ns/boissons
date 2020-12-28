/**
 * Fonction permettant d'utiliser la fonction "ajoutFavoris",
 * définie dans GestionFavoris.php, grâce à Ajax et jQuery
 * @param id identifiant du cocktail à ajouter
 */
function ajouterFav(id){
    $.ajax({ url: '../data/GestionFavoris.php',
            data: {func: 'ajout',var: id},
            type: 'POST',
            success: function(output) {
                alert("Ce cocktail a bien été ajouté à votre panier");
                document.location.reload();
            }
        });

}

/**
 * Fonction permettant d'utiliser la fonction "supprFavoris",
 * définie dans GestionFavoris.php, grâce à Ajax et jQuery
 * @param id identifiant du cocktail à supprimer
 */
function supprimerFav(id){
    $.ajax({ url: '../data/GestionFavoris.php',
        data: {func:'suppr',var: id},
        type: 'POST',
        success: function(output) {
            console.log(output);
            alert("Ce cocktail a bien été supprimé votre panier");
            document.location.reload();
        }
    });
}


/**
 * Fonction permettant d'utiliser la fonction "getFavoris",
 * définie dans GestionFavoris.php, grâce à Ajax et jQuery
 */
function getFav(){
    document.getElementById("ResFav").innerHTML = '<h2 class="text-center"  style=\'color: #5341b4\'>Mes recettes préférées </h><p class="text-center"  style="justify-content: center">';
    $.ajax({
        type: "POST",
        url: "../data/GestionFavoris.php",
        data: {func: 'get'},
        dataType:'JSON',
        success: function (ret) {
            console.log(ret)
            result = JSON.parse(ret);
            if (result.fail == "true") {
                alert("Erreur de chargement des favoris");
            } else {
                if(result.fav[0]==="" || result.fav.length===0){ //s'il n'y a pas de cocktails en favoris, on affiche cette phrase.
                    document.getElementById("ResFav").innerHTML +="<p class='text-center'>Vous n'avez pas de cocktails favoris </p>";
                }else{
                    document.getElementById("ResFav").innerHTML +='<ul>';
                    /* sinon on utilise la fonction recNum (définie dans TraitementRecettes.php) qui nous permet de trouver un coktail grâce à son identifiant (avec Ajax et jQuery)
                      et cela pour chaque cocktail qui se trouve dans les favoris */
                    for (let i = 0; i < result.fav.length; i++) {
                        $.ajax({
                            type:"POST",
                            url:"../data/TraitementRecettes.php",
                            data:{func:'recNum', var:result.fav[i]},
                            dataType:'JSON',
                            success: function(ret){
                                console.log(ret.titre);
                                document.getElementById("ResFav").innerHTML += '<li style="overflow: visible; cursor:pointer" class=" text-center" ><a id="' +ret.titre+ '" onclick="window.location.href=\'../recettes/index.php?nom=' +ret.titre+ '\'">'+ret.titre+ '</a></li>';
                            }
                        })

                    }
                    document.getElementById("ResFav").innerHTML +='</ul>';
                }

            }
        }
    })
}