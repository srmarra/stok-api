<?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once("../../util/pdo_connect.php");
    $Dados_Recebidos = file_get_contents("php://input");
    $key = $Dados_Recebidos['key'];
    $smtp = $PDO->prepare("SELECT A.auth_key,U.user_id FROM tb_auth A INNER JOIN tb_user U on U.user_id = A.auth_user_id WHERE A.auth_key = :key ");
   
    
    