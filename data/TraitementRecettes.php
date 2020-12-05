<?php

//echo(getNumRecettesFromIndex('Limonade'));
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
                getNumRecettesFromIndex($_POST['var']);
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

function getNumRecettesFromIndex($index){
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
    //preg_replace('/\'/', $ingredient, '\\\'');
    $Recettes=array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "titre":[';
    $existe = false;
    foreach ($Recettes as $recette) {
        if(in_array($ingredient, $recette['index'])){
            $existe = true;
            $titre = $recette['titre'];
            preg_replace('/\'/', '\\\'', $titre);
            $res = $res.'"'.$titre.'",';
        }
    }
    if($existe){
        $res = substr_replace($res ,"", -1);
        $res = $res.']}';
    }else{
        $res = $res.'"none"]}';
    }
    return $res;
    //echo json_encode($res);
}

function getRecetteFromNum($index){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res = $Recettes[$index];
    preg_replace('/\'/', '\\\'', $res['titre']);
    preg_replace('/\'/', '\\\'', $res['ingredients']);
    preg_replace('/\'/', '\\\'', $res['preparation']);
    for($i = 0; $i < count($res['index']); $i++){
        preg_replace('/\'/', '\\\'', $res['index'][$i]);
    }
    //return $res;
    echo json_encode($res);
}

function getAllRecettes(){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res='{"fail":"false", "titre":[';
    foreach ($Recettes as $type){
        $titre = $type['titre'];
        preg_replace('/\'/', '\\\'', $titre);
        $res = $res.'"'.$titre.'",';
    }
    $res = substr_replace($res ,"", -1);
    $res = $res.']}';
    //return $res;
    echo json_encode($res);
}

function getRecetteFromNom($nom){
    //preg_replace('/\'/', $nom, '\\\'');
    $Recettes = array();
    include 'Donnees.inc.php';
    $res = '{"fail":"false", "titre":"';
    $existe = false;
    foreach ($Recettes as $type) {
        if($type['titre'] == $nom){
            $existe = true;
            $titre = $type['titre'];
            preg_replace('/\'/', '\\\'', $titre);
            $ingredients = $type['ingredients'];
            preg_replace('/\'/', '\\\'', $ingredients);
            $preparation = $type['preparation'];
            preg_replace('/\'/', '\\\'', $preparation);
            $res = $res.$titre.'","ingredients":"'.$ingredients.'","preparation":"'.$preparation.'","index":[';
            foreach ($type['index'] as $index){
                preg_replace('/\'/', $index, '\\\'');
                $res = $res.'"'.$index.'",';
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

function getRecetteMatchNom($match){
    //preg_replace('/\'/', $match, '\\\'');
    $Recettes = array();
    include "Donnees.inc.php";
    $res = '{"fail":"false", "titre":[';
    $exp = '/.*?'.$match.'.*?/i';
    $isEmpty = true;
    foreach ($Recettes as $item){
        if(preg_match($exp, $item['titre'])) {
            $titre = $item['titre'];
            preg_replace('/\'/', '\\\'', $titre);
            $res = $res.'"'.$titre.'",';
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