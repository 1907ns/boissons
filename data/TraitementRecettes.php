<?php

//print_r(getRecettesFromIndex('Curacao'));
//echo "<br/>";
//print_r(getRecetteFromNum(51));
//echo "<br/>";
//echo getAllRecettes();
//echo "<br/>";

if (isset($_POST['func'])){
    $fail = true;
    switch ($_POST['func']){
        case 'recInd':
            if (isset($_POST['var'])){
                getRecettesFromIndex($_POST['var']);
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
    }
    if($fail){
        $res = array('fail');
        echo json_encode($res);
    }
}

function getRecettesFromIndex($index){
    $Recettes=array();
    include 'Donnees.inc.php';
    $res = array();
    foreach ($Recettes as $type){
        if(in_array($index, $type['index'])){
            $cles = array_keys($Recettes, $type, true);
            foreach ($cles as $cle) {
                array_push($res, $cle);
            }
        }
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
    $res='{"titre":[';
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
    $res = '{"titre":"';
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