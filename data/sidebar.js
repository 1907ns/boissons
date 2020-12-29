let resLoad = "";
let resSM = "";
let isSM = false;
let nomSM = "";
// Cette fonction va rechercher le ou les élément(s) constituant la base de l'affichage arborescent de la sidebar
// Elle le/les ajoute dans la variable resLoad, pour être affichée quand les scripts ont fini de s'exécuter
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
                    resLoad += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../ingredients/index.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../assets/images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + result.nom[i] + '\')"/></span></li>';
                }
            }
        }
    })
}
// Cette fonction va rechercher les éléments existant dans les sous-catégories d'un élément donné
function sousMenu(nom){
    resSM = "";
    isSM = true;
    nomSM = nom;
    //On vérifie si ce menu a déjà été déroulé, si c'est le cas, on le referme
    if(document.getElementById(nom).parentElement.value){
        document.getElementById(nom).parentElement.innerHTML = '<li value=0><span id="' + nom + '" onclick="window.location.href=\'../ingredients/index.php?nom=' + nom + '\'">' + nom + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../assets/images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + nom + '\')"/></li>';
    }else {
        document.getElementById(nom).parentElement.innerHTML = '<li value=0><span id="' + nom + '" onclick="window.location.href=\'../ingredients/index.php?nom=' + nom + '\'">' + nom + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../assets/images/rewind.png" style="max-width:20px;" onclick="sousMenu(\'' + nom + '\')"/></li>';
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
                            //Si la liste retournée par la requète de sous-éléments n'est pas vide, on crée un nouvel élément déroulable dans le menu, sinon on crée juste un élément non déroulable
                            if(retour){
                                resSM += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../ingredients/index.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="../assets/images/next.png" style="max-height:20px;" onclick="sousMenu(\'' + result.nom[i] + '\')"/></span></li>';
                            }else{
                                resSM += '<li value=0 class=" text-center" style="cursor: pointer"><span id="' + result.nom[i] + '" onclick="window.location.href=\'../ingredients/index.php?nom=' + result.nom[i] + '\'">' + result.nom[i] + '</span></li>';
                            }
                        });
                    }
                }
            }
        })
    }
}

//Cette fonction permet de savoir si un élément possède des sous-éléments ou non
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
//Cette fonction est exécutée une fois que toutes les requêtes ont fini d'être exécutées
$(document).ajaxStop(function(){
    //Si l'affichage n'a pas été causé par un sous-menu, on affiche la base
    if(!isSM) {
        document.getElementById('sidebar').innerHTML = resLoad;
    }else{ //Sinon on affiche ce sous-menu en indiquant que son parent a été développé
        document.getElementById(nomSM).parentElement.value = true;
        document.getElementById(nomSM).parentElement.innerHTML += resSM;
    }
})