<?php

use PHPMailer\PHPMailer\PHPMailer;

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    // 

    require_once("../../util/pdo_connect.php");//Conexão com banco de dados
    require_once("../../libraries/phpmailer/src/PHPMailer.php");//Classe PHPMAILER


    // Configuração Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp-relay.sendinblue.com";
    $mail->SMTPAuth=true;
    $mail->Username="stok@hmarra.tech";
    $mail->Password="QjD8vzgAsmYd7Iwf";
    // 


    // Para
    $mail->AddAddress("herick.marra1@gmail.com");
    

    $mail->isHTML(true);

    $mail->Subject="Resetar a senha STOK";//Assunto
    $mail->Body="Funcionou";//Corpo
    $mail->AltBody = "Erro aoler a mensagem";

    $envio = $mail->send();

    $codigoRedefinicao = rand(1000,9999);

    keyGerar:
    $key_reset = uniqid("key_",true);


    $json = array(
        "key"=>$key_reset,
        "code"=>$codigoRedefinicao,
        "status"=>$envio
    );

    echo json_encode($json);