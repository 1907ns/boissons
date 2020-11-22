<?php
//Tests des fonctions
//print_r(getBaseArbo());
//echo "<br/><br/>";
//print_r(getSousCategories("Agrume"));
//echo "<br/><br/>";
//print_r(getSurCategories("Jus de tomates"));

if (isset($_POST['func'])){
    $fail = true;
    switch ($_POST['func']){
        case 'base':
            getBaseArbo();
            $fail=false;
            break;
        case 'sub':
            if (isset($_POST['var'])){
                getSousCategories($_POST['var']);
                $fail=false;
            }
            break;
        case 'sup':
            if (isset($_POST['var'])){
                getSurCategories($_POST['var']);
                $fail=false;
            }
            break;
    }
    if($fail){
        $res = array('fail');
        echo json_encode($res);
    }

}

//Fonction permettant de récupérer la/les base.s de l'arborescence des ingrédients
function getBaseArbo(){
    $Hierarchie = array();
    $res = array();
    include 'Donnees.inc.php';
    foreach ($Hierarchie as $nom) {
        if (!isset($nom['super-categorie'])) {
            $cles = array_keys($Hierarchie, $nom, true);
            foreach ($cles as $cle) {
                array_push($res, $cle);
            }
        }
    }
    //print_r($res);
    echo json_encode($res);
}

//Fonction permettant de récupérer la/les sous-catégorie.s d'un ingrédient
// ** paramètre nomSource = nom de l'ingrédient dont on veut connaître la/les sous-catégorie.s
function getSousCategories($nomSource){
    $Hierarchie = array();
    include 'Donnees.inc.php';
    if (isset($Hierarchie[$nomSource]['sous-categorie']))
        $res = $Hierarchie[$nomSource]['sous-categorie'];
    else
        $res = array('false');
    //return $res;
    echo json_encode($res);
}

//Fonction permettant de récupérer les super-catégories chainées d'un ingrédient, un seul chemin est choisi de base
// ** paramètre nomSource = nom de l'ingrédient dont on veut connaître les super-catégories
// ***  à modifier si le chemin doit être défini par des paramètres extérieurs
function getSurCategories($nomSource){
    $Hierarchie = array();
    include 'Donnees.inc.php';
    $res = array();
    array_push($res, $nomSource);
    while(isset($Hierarchie[$nomSource]['super-categorie'])){
        $nomSource = $Hierarchie[$nomSource]['super-categorie'][0];
        array_push($res, $nomSource);
    }
    //return $res;
    echo json_encode($res);
}
?>