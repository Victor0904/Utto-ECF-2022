<?php
    try{
    $pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $GLOBALS["_bdd"] = new PDO('mysql:host=localhost;dbname=api_salle_sport', 'root', '');

    /*echo " Base connecté";*/
    }catch(Exeption $e){
      die('Erreur:'.$e->getMessage());
    }

?>