<?php

function cryptageMdp($pass){
    $pass = "a2t" . sha1($pass . "1t23ed") . "v2v3d";
    $pass = sha1($pass);
    return $pass;
}

function dataSecure($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function est_connecter(){
    return isset($_SESSION['connect']);
}


