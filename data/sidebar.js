let resLoad = "";
let resSM = "";
let isSM = false;
let nomSM = "";
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
function sousMenu(nom){
    resSM = "";
    isSM = true;
    nomSM = nom;
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
$(document).ajaxStop(function(){
    if(!isSM) {
        document.getElementById('sidebar').innerHTML = resLoad;
    }else{
        document.getElementById(nomSM).parentElement.value = true;
        document.getElementById(nomSM).parentElement.innerHTML += resSM;
    }
})