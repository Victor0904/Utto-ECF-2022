<?php
    try{
    $pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $GLOBALS["_bdd"] = new PDO('mysql:host=j5zntocs2dn6c3fj.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306	;dbname=x95p2gcp1w2r4ykr', 'u62g8ed5v9oz3w01', 'xf0yy9sci6usojvg');

    /*echo " Base connecté";*/
    }catch(Exeption $e){
      die('Erreur:'.$e->getMessage());
    }

?>