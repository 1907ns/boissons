<?php

print_r(getBaseArbo());
echo "<br/><br/>";
print_r(getSousCategories("Fruit"));
echo "<br/><br/>";
print_r(getSurCategories("Jus de tomates"));

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
    return $res;
}

function getSousCategories($nomSource){
    $Hierarchie = array();
    include 'Donnees.inc.php';
    if (isset($Hierarchie[$nomSource]['sous-categorie']))
        $res = $Hierarchie[$nomSource]['sous-categorie'];
    else
        $res = false;
    return $res;
}

function getSurCategories($nomSource){
    $Hierarchie = array();
    include 'Donnees.inc.php';
    $res = array();
    array_push($res, $nomSource);
    while(isset($Hierarchie[$nomSource]['super-categorie'])){
        $nomSource = $Hierarchie[$nomSource]['super-categorie'][0];
        array_push($res, $nomSource);
    }
    return $res;
}
?>