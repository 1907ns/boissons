<?php

//print_r(getRecettesFromIndex('Curacao'));
//echo "<br/>";
//echo getRecetteFromIngredient('Jus de mangue');
//echo "<br/>;
//print_r(getRecetteFromNum(51));
//echo "<br/>";
//echo getAllRecettes();
//echo "<br/>";
//echo getRecetteMatchNom("velv");
//echo "<br/>";
//echo getRecetteMatchNom("velc");

if (isset($_POST['func'])){
    $fail = true;
    switch ($_POST['func']){
        case 'recInd':
            if (isset($_POST['var'])){
                getRecettesFromIndex($_POST['var']);
                $fail=false;
            }
            break;
        case 'recIng':
            if (isset($_POST['var'])){
                getRecetteFromIngredient($_POST['var']);
                $fail=false;
            }
            break;
        case 'recNum':
            if (isset($_POST['var'])){
                getRecetteFromNum($_POST['var']);
                $fail=false;
            }
            break;
        case 'all':
            getAllRecettes();
            $fail=false;
            break;
        case 'recNom':
            if(isset($_POST['var'])){
                getRecetteFromNom($_POST['var']);
                $fail = false;
            }
            break;
        case 'matchNom':
            if(isset($_POST['var'])){
                getRecetteMatchNom($_POST['var']);
                $fail = false;
            }
    }
    if($fail){
        $res = array('fail');
        echo json_encode($res);
    }
}

function getRecettesFromIndex($index){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "index":[';
    $existe = false;
    foreach ($Recettes as $type){
        if(in_array($index, $type['index'])){
            $existe = true;
            $cles = array_keys($Recettes, $type, true);
            foreach ($cles as $cle) {
                $res = $res.'"'.$cle.'",';
            }
        }
    }
    if($existe){
        $res = substr_replace($res ,"", -1);
        $res = $res.']}';
    }else{
        $res = $res.'"none"]}';
    }
    //return $res;
    echo json_encode($res);
}

function getRecetteFromIngredient($ingredient){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "titre":[';
    $existe = false;
    foreach ($Recettes as $recette) {
        if(in_array($ingredient, $recette['index'])){
            $existe = true;
            $res = $res.'"'.$recette['titre'].'",';
        }
    }
    if($existe){
        $res = substr_replace($res ,"", -1);
        $res = $res.']}';
    }else{
        $res = $res.'"none"]}';
    }
    //return $res;
    echo json_encode($res);
}

function getRecetteFromNum($index){
    $Recettes=array();
    include 'Donnees.inc.php';
    //return $Recettes[$index];
    echo json_encode($Recettes[$index]);
}

function getAllRecettes(){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res='{"fail":"false", "titre":[';
    foreach ($Recettes as $type){
        $res = $res.'"'.$type['titre'].'"'.',';
    }
    $res = substr_replace($res ,"", -1);
    $res = $res.']}';
    //return $res;
    echo json_encode($res);
}

function getRecetteFromNom($nom){
    $Recettes = array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "titre":"';
    foreach ($Recettes as $type) {
        if($type['titre'] == $nom){
            $res = $res.$type['titre'].'","ingredients":"'.$type['ingredients'].'","preparation":"'.$type['preparation'].'","index":[';
            foreach ($type['index'] as $index){
                $res = $res.'"'.$index.'",';
            }
            $res = substr_replace($res ,"", -1);
            $res = $res.']}';
        }
    }
    //return $res;
    echo json_encode($res);
}

function getRecetteMatchNom($match){
    $Recettes = array();
    include "Donnees.inc.php";
    $res = '{"fail":"false", "titre":[';
    $exp = '/.*?'.$match.'.*?/i';
    $isEmpty = true;
    foreach ($Recettes as $item){
        if(preg_match($exp, $item['titre'])) {
            $res = $res . '"' . $item['titre'] . '",';
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