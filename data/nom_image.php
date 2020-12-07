<?php

/**
 * @param $img nom du cocktail avec les espaces & et les caractères spéciaux
 * @return string|string[] retourne le nom du cocktail sans caractères spéciaux & espaces
 */
function name_image($img) {

    $img = str_replace(" ", "_", $img);
    $img = str_replace("'", "", $img);

    $img = str_replace("à", "a", $img);
    $img = str_replace("ä", "a", $img);

    $img = str_replace("é", "e", $img);
    $img = str_replace("è", "e", $img);
    $img = str_replace("ë", "e", $img);
    $img = str_replace("ê", "e", $img);

    $img = str_replace("ï", "i", $img);
    $img = str_replace("î", "i", $img);

    $img = str_replace("ô", "o", $img);
    $img = str_replace("ö", "o", $img);

    $img = str_replace("û", "u", $img);
    $img = str_replace("ü", "u", $img);
    $img = str_replace("ù", "u", $img);

    $img = str_replace("ç", "c", $img);
    $img = str_replace("ñ", "n", $img);


    return $img;
} ?>