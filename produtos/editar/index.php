<?php

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    require_once("../../util/pdo_connect.php");

    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    $smtp = $PDO->prepare("UPDATE tb_produtos SET prod_titulo = :titulo , prod_desc = :desc , prod_preco = :preco, prod_qnt = :qnt where prod_id = :id");
    $smtp->execute(array(
        "titulo"=> $dados->{'titulo'},
        "desc"=> $dados->{'descricao'},
        "preco"=> $dados->{'preco'},
        "qnt"=> $dados->{'quantidade'},
        "id"=> $dados->{'id'},

    ));


    $json = array(
        "status" => true,
    );  



    
    echo json_encode($json);


