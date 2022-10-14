<?php

use PHPMailer\PHPMailer\PHPMailer;

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    // 

    require_once("../../util/pdo_connect.php");//Conexão com banco de dados


    // Configuração do email
    $headers  = "From: Stok <suporte@stok.tech>\n";
    $headers .= "X-Sender: Stok <suporte@stok.com>\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    $headers .= "X-Priority: 1\n"; // Urgent message!
    $headers .= "Return-Path: suporte@stok.com\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";

    $para = "herick.marra1@gmail.com";
    $Assunto = "STOK Redefinir senha";
    $body = "<h1>test</h1>";

    
    $envio = mail($para,$Assunto,$body,$headers);
    $codigoRedefinicao = rand(1000,9999);

    keyGerar:
    $key_reset = uniqid("key_",true);


    $json = array(
        "key"=>$key_reset,
        "code"=>$codigoRedefinicao,
        "status"=> $envio
    );

    echo json_encode($json);