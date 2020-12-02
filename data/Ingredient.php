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
        function load(nomIng){
            $.ajax({
                type:'POST',
                url:'TraitementRecettes.php',
                data:{func:'recInd', var:nomIng},
                success: function(retRec){
                    retRec = retRec.replaceAll('[', '');
                    retRec = retRec.replaceAll(']', '');
                    let idRec = retRec.split(',');
                    for (let i = 0; i < idRec.length; i++){
                        $.ajax({
                            type:'POST',
                            url:'TraitementRecettes.php',
                            data:{func: 'recNum', var: idRec[i]},
                            dataType: 'JSON',
                            success: function(recs){
                                resRec.push(recs.titre);
                            }
                        })
                    }
                }
            });
            $.ajax({
                type:'POST',
                url:'TraitementHierarchie.php',
                data:{func:'sub', var:nomIng},
                success: function (retSubIng){
                    retSubIng = retSubIng.replaceAll('"', '');
                    retSubIng = retSubIng.replaceAll('[', '');
                    retSubIng = retSubIng.replaceAll(']', '');
                    retSubIng = retSubIng.replaceAll('{', '');
                    retSubIng = retSubIng.replaceAll('}', '');
                    retSubIng = retSubIng.replaceAll(':', '');
                    retSubIng = retSubIng.replaceAll('0', '');
                    retSubIng = retSubIng.replaceAll('1', '');
                    retSubIng = retSubIng.replaceAll('2', '');
                    retSubIng = retSubIng.replaceAll('3', '');
                    retSubIng = retSubIng.replaceAll('4', '');
                    retSubIng = retSubIng.replaceAll('5', '');
                    retSubIng = retSubIng.replaceAll('6', '');
                    retSubIng = retSubIng.replaceAll('7', '');
                    retSubIng = retSubIng.replaceAll('8', '');
                    retSubIng = retSubIng.replaceAll('9', '');
                    if(!retSubIng.includes('false')){
                        let sub = retSubIng.split(',');
                        for(let i=0; i<sub.length; i++) {
                            resSubIng.push(sub[i]);
                        }
                    }
                }
            });
            $.ajax({
                type:'POST',
                url:'TraitementHierarchie.php',
                data:{func:'sup', var:nomIng},
                success: function (retSupIng){
                    retSupIng = retSupIng.replaceAll('"', '');
                    retSupIng = retSupIng.replaceAll('[', '');
                    retSupIng = retSupIng.replaceAll(']', '');
                    retSupIng = retSupIng.replaceAll('{', '');
                    retSupIng = retSupIng.replaceAll('}', '');
                    retSupIng = retSupIng.replaceAll(':', '');
                    retSupIng = retSupIng.replaceAll('0', '');
                    retSupIng = retSupIng.replaceAll('1', '');
                    retSupIng = retSupIng.replaceAll('2', '');
                    retSupIng = retSupIng.replaceAll('3', '');
                    retSupIng = retSupIng.replaceAll('4', '');
                    retSupIng = retSupIng.replaceAll('5', '');
                    retSupIng = retSupIng.replaceAll('6', '');
                    retSupIng = retSupIng.replaceAll('7', '');
                    retSupIng = retSupIng.replaceAll('8', '');
                    retSupIng = retSupIng.replaceAll('9', '');
                    if(!retSupIng.includes('false')){
                        let sup = retSupIng.split(',');
                        for(let i=0; i<sup.length; i++) {
                            resSupIng.push(sup[i]);
                        }
                    }
                }
            });
        }
        $(document).ajaxStop( function() {
            for (let i = 0; i < resRec.length; i++) {
                document.getElementById('listeRecettes').innerHTML += '<a href="Recette.php?nom='+ resRec[i] + '">' + resRec[i] + '</a><br/>';
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
<body onload="load('<?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?>')">
    <h1>Listes des recettes dans lesquelles est utilisé le/la <?php if(isset($_GET['nom'])){echo $_GET['nom'];}else{echo "Aliment";}?></h1>
    <p id="listeRecettes"></p>
    <h1>Liste des sous-ingrédients</h1>
    <p id="sousIng"></p>
    <h1>Liste des sur-ingrédients</h1>
    <p id="supIng"></p>
</body>
</html>