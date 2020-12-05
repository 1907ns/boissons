<?php
//Tests des fonctions
//print_r(getBaseArbo());
//echo "<br/><br/>";
//getSousCategories("Partie d'agrumes");
//echo "<br/><br/>";
//print_r(getSurCategories("Jus de tomates"));
//echo "<br/><br/>";
//echo getIngredientMatchNom("jus");
//echo "<br/><br/>";
//echo getIngredientMatchNom("Black velvet");


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
        case 'sur':
            if (isset($_POST['var'])){
                getSurCategories($_POST['var']);
                $fail=false;
            }
            break;
        case 'sup':
            if (isset($_POST['var'])){
                getSupCategories($_POST['var']);
                $fail=false;
            }
            break;
        case 'matchNom':
            if(isset($_POST['var'])){
                getIngredientMatchNom($_POST['var']);
                $fail = false;
            }
    }
    if($fail){
        $res = '{"fail":"true"}';
        echo json_encode($res);
    }
}

//Fonction permettant de récupérer la/les base.s de l'arborescence des ingrédients
function getBaseArbo(){
    $Hierarchie = array();
    $res = '{"fail":"false","nom":[';
    include 'Donnees.inc.php';
    foreach ($Hierarchie as $nom) {
        if (!isset($nom['super-categorie'])) {
            $cles = array_keys($Hierarchie, $nom, true);
            foreach ($cles as $cle) {
                preg_replace('/\'/', '\\\'', $cle);
                $res = $res.'"'.$cle.'",';
            }
        }
    }
    $res = substr_replace($res ,"", -1);
    $res = $res.']}';
    //print_r($res);
    echo json_encode($res);
}

//Fonction permettant de récupérer la/les sous-catégorie.s d'un ingrédient
// ** paramètre nomSource = nom de l'ingrédient dont on veut connaître la/les sous-catégorie.s
function getSousCategories($nomSource){
    //preg_replace('/\'/', $nomSource, '\\\'');
    $Hierarchie = array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false","nom":[';
    if (isset($Hierarchie[$nomSource]['sous-categorie'])) {
        foreach ($Hierarchie[$nomSource]['sous-categorie'] as $value) {
            preg_replace('/\'/', '\\\'', $value);
            $res = $res . '"' . $value . '",';
        }
        $res = substr_replace($res, "", -1);
    }else {
        $res = $res.'"none"';
    }
    $res = $res . ']}';
    //return $res;
    echo json_encode($res);
}

//Fonction permettant de récupérer les super-catégories chainées d'un ingrédient, un seul chemin est choisi de base
// ** paramètre nomSource = nom de l'ingrédient dont on veut connaître les super-catégories
// ***  à modifier si le chemin doit être défini par des paramètres extérieurs
function getSurCategories($nomSource){
    //preg_replace('/\'/', $nomSource, '\\\'');
    $Hierarchie = array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "nom":["'.$nomSource.'",';
    while(isset($Hierarchie[$nomSource]['super-categorie'])) {
        $nomSource = $Hierarchie[$nomSource]['super-categorie'][0];
        $nomEnreg = $nomSource;
        preg_replace('/\'/', '\\\'', $nomEnreg);
        $res = $res . '"' . $nomEnreg . '",';
    }
    $res = substr_replace($res, "", -1);
    $res = $res . ']}';
    //return $res;
    echo json_encode($res);
}

function getSupCategories($nomSource){
    //preg_replace('/\'/', $nomSource, '\\\'');
    $Hierarchie = array();
    include 'Donnees.inc.php';
    $res = '{"fail":"true", "nom":[';
    if(isset($Hierarchie[$nomSource]['super-categorie'])) {
        foreach ($Hierarchie[$nomSource]['super-categorie'] as $value) {
            preg_replace('/\'/', '\\\'', $value);
            $res = $res.'"'.$value.'",';
        }
        $res = substr_replace($res, "", -1);
    }else {
        $res = $res.'"none"';
    }
    $res = $res . ']}';
    //return $res;
    echo json_encode($res);
}

function getIngredientMatchNom($match){
    preg_replace('/\'/', $match, '\\\'');
    $Hierarchie = array();
    include "Donnees.inc.php";
    $res = '{"fail":"false", "nom":[';
    $exp = '/.*?'.$match.'.*?/i';
    $isEmpty = true;
    $cles = array_keys($Hierarchie);
    foreach ($cles as $cle) {
        if (preg_match($exp, $cle)) {
            preg_replace('/\'/', '\\\'', $cle);
            $res = $res.'"'.$cle.'",';
            $isEmpty = false;
        }
    }
    if($isEmpty){
        $res = $res.'"none"';
    }else {
        $res = substr_replace($res, "", -1);
    }
    $res = $res.']}';
    //return $res;
    echo json_encode($res);
}