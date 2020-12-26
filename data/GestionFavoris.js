



function ajouterFav(id){
    $.ajax({ url: '../data/GestionFavoris.php',
            data: {func: 'ajout',var: id},
            type: 'POST',
            //dataType: 'JSON',
            success: function(output) {
                //console.log(output);
                //console.log(id);
                alert("Ce cocktail a bien été ajouté à votre panier");
                document.location.reload();
            }
        });

}


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
                if(result.fav[0]===""){
                    document.getElementById("ResFav").innerHTML +="<p class='text-center'>Vous n'avez pas de cocktails favoris </p>";
                }else{
                    document.getElementById("ResFav").innerHTML +='<ul>';
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