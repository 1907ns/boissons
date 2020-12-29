<?php

//Cette partie permet d'utiliser différentes fonctions par rapport au type de POST envoyé
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

//Cette fonction permet de récupérer les numéros de recettes contenant un index donné
function getNumRecettesFromIndex($index){
    $Recettes=array();
    include '../Projet/Donnees.inc.php';
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

//Cette fonction permet d'obtenir la liste des recettes contenant un ingrédient donné
function getRecetteFromIngredient($ingredient){
    //preg_replace('/\'/', $ingredient, '\\\'');
    $Recettes=array();
    include '../Projet/Donnees.inc.php';
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

//Cette fonction permet d'obtenir une recette en fonction de son id
function getRecetteFromNum($index){
    $Recettes=array();
    include '../Projet/Donnees.inc.php';
    $res = $Recettes[$index];
    preg_replace('/\'/', '\\\'', $res['titre']);
    preg_replace('/\'/', '\\\'', $res['ingredients']);
    preg_replace('/\'/', '\\\'', $res['preparation']);
    $res['preparation'] = preg_replace('/"/', '\\"', $res['preparation']);
    for($i = 0; $i < count($res['index']); $i++){
        preg_replace('/\'/', '\\\'', $res['index'][$i]);
    }
    //return $res;
    echo json_encode($res);
}

//Cette fonction permet d'obtenir toutes les recettes
function getAllRecettes(){
    $Recettes=array();
    include '../Projet/Donnees.inc.php';
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

//Cette fonction permet d'obtenir une recette à partir de son nom
function getRecetteFromNom($nom){
    $Recettes = array();
    include '../Projet/Donnees.inc.php';
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
            $preparation = preg_replace('/"/', '\\"', $preparation);
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

//Cette fonction permet de récupérer une recette en fonction d'un match donnée, grâce à l'utilisation de regex
function getRecetteMatchNom($match){
    $match = preg_replace('/\([^*]*\)/', '', $match);
    $Recettes = array();
    include "../Projet/Donnees.inc.php";
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