<?php

//print_r(getRecettesFromIndex('Curacao'));
//echo "<br/>";
//print_r(getRecetteFromNum(51));

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