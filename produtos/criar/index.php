<?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once("../../util/pdo_connect.php");

    $smtp = $PDO->prepare("INSERT TO tb_prosutos value(null , :titulo , :desc , :preco , :qnt , :user)");

    $smyp->execute(array(
        "id" => "",

    ));