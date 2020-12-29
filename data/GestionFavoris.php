<?php

//Si la session n'est pas accessible, alors elle est lancée
if(session_id() == ''){
    session_start();
}

//Cette partie permet d'utiliser différentes fonctions par rapport au type de POST envoyé
if(isset($_POST['func'])){
    $fail = true;
    switch ($_POST['func']){
        case 'get':
            getFavoris();
            $fail = false;
            break;
        case 'ajout':
            if(isset($_POST['var'])){
                ajoutFavoris($_POST['var']);
                $fail = false;
            }
            break;
        case 'suppr':
            if(isset($_POST['var'])){
                supprFavoris($_POST['var']);
                $fail = false;
            }
    }
    if($fail){
        $res = '{"fail":"true"}';
        echo json_encode($res);
    }
}

//Cette fonction permet de récupérer les favoris de l'utilisateur connecté ou non, respectivement à partir de la base de données ou des cookies de session
function getFavoris(){
    $res = '{"fail":"false", "fav":[';
    $favoris = "";
    if(isset($_SESSION["loggedin"])) {
        if ($_SESSION["loggedin"] == true) {
            $link = mysqli_connect("localhost", "root", "", "boissons");
            $sql = "SELECT favoris FROM users WHERE id = " . $_SESSION['id'];
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $favoris);
                        if(mysqli_stmt_fetch($stmt)) {
                            if(strpos($favoris, '|') !== false) {
                                $favArray = explode('|', $favoris);
                                foreach ($favArray as $fav) {
                                    $res = $res . '"' . $fav . '",';
                                }
                            }else{
                                $res = $res.'"'.$favoris.'",';
                            }
                        }
                    }
                }
            }
        } else {
            if (isset($_SESSION["favoris"])) {
                $favoris = $_SESSION["favoris"];
                if(strpos($favoris, '|') !== false) {
                    $favArray = explode('|', $favoris);
                    foreach ($favArray as $fav) {
                        $res = $res . '"' . $fav . '",';
                    }
                }else{
                    $res = $res.'"'.$favoris.'"';
                }
            }else{
                $res = $res.'"",';
            }
        }
        if(substr($res,-1)===','){
            $res = substr_replace($res, "", -1);
        }
    }
    $res = $res . ']}';
    echo json_encode($res);
}

//Cette fonction permet d'ajouter un favoris à un utilisateur connecté ou non, respectivement en base de données ou dans les cookies de session
function ajoutFavoris($id){
    if(isset($_SESSION["loggedin"])) {
        if ($_SESSION["loggedin"] == true) {
            $link = mysqli_connect("localhost", "root", "", "boissons");
            $sql = "SELECT favoris FROM users WHERE id = " . $_SESSION['id'];
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $favoris);
                        if(mysqli_stmt_fetch($stmt)) {
                            if ($favoris != "")
                                $favoris = $favoris . '|' . $id;
                            else
                                $favoris = $id;
                            $_SESSION["favoris"] = $favoris;
                            $sqlUpdate = "UPDATE users SET favoris = '" . $favoris . "' WHERE id = " . $_SESSION['id'];
                            $stmtUpdate = mysqli_prepare($link, $sqlUpdate);
                            if ($stmtUpdate) {
                                mysqli_stmt_execute($stmtUpdate);
                            }
                        }
                    }
                }
            }
        } else {
            if (isset($_SESSION["favoris"]))
                if($_SESSION["favoris"] != "")
                    $_SESSION["favoris"] = $_SESSION["favoris"] . '|' . $id;
                else
                    $_SESSION["favoris"] = $id;
            else
                $_SESSION["favoris"] = $id;
        }
    }else {
        $_SESSION["loggedin"] = false;
        if (isset($_SESSION["favoris"])) {
            if ($_SESSION["favoris"] != "")
                $_SESSION["favoris"] = $_SESSION["favoris"] . '|' . $id;
            else
                $_SESSION["favoris"] = $id;
        }else {
            $_SESSION["favoris"] = $id;
        }
    }
}

//Cette fonction permet de supprimer un favoris pour un utilisateur connecté ou non, respectivement en base de données ou dans les cookies de session
function supprFavoris($id){
    $favUpdate = "";
    if(isset($_SESSION["loggedin"])) {
        if ($_SESSION["loggedin"] == true) {
            $link = mysqli_connect("localhost", "root", "", "boissons");
            $sql = "SELECT favoris FROM users WHERE id = " . $_SESSION['id'];
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $favoris);
                        if(mysqli_stmt_fetch($stmt)) {
                            if(strpos($favoris, '|') !== false) {
                                $favArray = explode('|', $favoris);
                                foreach ($favArray as $fav) {
                                    if ($fav != $id)
                                        $favUpdate = $favUpdate . $fav . '|';
                                }
                                $favUpdate = substr_replace($favUpdate, "", -1);
                            }else{
                                $favUpdate = '';
                            }
                            $_SESSION["favoris"] = $favUpdate;
                            $sqlUpdate = "UPDATE users SET favoris = '" . $favUpdate . "' WHERE id = " . $_SESSION['id'];
                            $stmtUpdate = mysqli_prepare($link, $sqlUpdate);
                            if ($stmtUpdate) {
                                mysqli_stmt_execute($stmtUpdate);
                            }
                        }
                    }
                }
            }
        } else {
            if(isset($_SESSION["favoris"])) {
                $favoris = $_SESSION["favoris"];
                if(strpos($favoris, '|') !== false) {
                    $favArray = explode('|', $favoris);
                    foreach ($favArray as $fav) {
                        if ($fav != $id)
                            $favUpdate = $favUpdate . $fav . '|';
                    }
                    $favUpdate = substr_replace($favUpdate, "", -1);
                }else{
                    $favUpdate = '';
                }
                $_SESSION["favoris"] = $favUpdate;
            }
        }
    }else{
        $_SESSION["loggedin"] = false;
        if(isset($_SESSION["favoris"])) {
            $favoris = $_SESSION["favoris"];
            if(strpos($favoris, '|') !== false) {
                $favArray = explode('|', $favoris);
                foreach ($favArray as $fav) {
                    if ($fav != $id)
                        $favUpdate = $favUpdate . $fav . '|';
                }
                $favUpdate = substr_replace($favUpdate, "", -1);
            }else{
                $favUpdate = '';
            }
            $_SESSION["favoris"] = $favUpdate;
        }
    }
}

//Cette fonction permet de détecter si une recette dont l'id est donné en paramètre est dans les favoris de l'utilisateur ou non
function estFavoris($id){
    $ok = false;
    if(isset($_SESSION['favoris'])) {
        $favs = $_SESSION['favoris'];
        if (strpos($favs, '|')){
            $favArray = explode('|', $favs);
            foreach ($favArray as $fav) {
                if ($fav == $id)
                    $ok = true;
            }
        }else{
            if($favs==$id){
                $ok=true;
            }
        }

    }
    return $ok;
}
?>