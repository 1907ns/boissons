<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        let resRec = Array();
        let resSubIng = Array();
        let resSupIng = Array();
        let resSurIng = Array();
        function load(nomIng){
            $.ajax({
                type:'POST',
                url:'TraitementHierarchie.php',
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
                url:'TraitementRecettes.php',
                data:{func:'recInd', var:nomIng},
                dataType: 'JSON',
                success: function(retRec){
                    idRec = JSON.parse(retRec);
                    if(idRec.index[0] != "none"){
                        for (let i = 0; i < idRec.index.length; i++) {
                            $.ajax({
                                type: 'POST',
                                url: 'TraitementRecettes.php',
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
                url:'TraitementHierarchie.php',
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
                url:'TraitementHierarchie.php',
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
                    document.getElementById('surIng').innerHTML += '<a href="?nom=' + resSurIng[i] + '">' + resSurIng[i] + '</a>&nbsp;&nbsp;&nbsp;<img style="max-height: 10px;" src="../images/next.png"/>&nbsp;&nbsp;&nbsp;';
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
<body onload="load('<?php if(isset($_GET['nom'])){echo preg_replace('/\'/', '\\\'', $_GET['nom']);}else{echo "Aliment";}?>')">
    <h1>Liste hiérarchie</h1>
    <p id="surIng"></p>
    <h1>Listes des recettes dans lesquelles est utilisé le/la <?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?></h1>
    <p id="listeRecettes"></p>
    <h1>Liste des sous-ingrédients</h1>
    <p id="sousIng"></p>
    <h1>Liste des sur-ingrédients</h1>
    <p id="supIng"></p>
</body>
</html>