<?php


    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    $email = $dados->{'email'};

    require_once("../../util/pdo_connect.php");//Conexão com banco de dados



    $smtp = $PDO->prepare("SELECT * from tb_user where user_email = :email");

    $smtp->execute(array(
        "email"=>$email
    ));

    if($smtp->rowCount() == 1){
        $user = $smtp->fetch();
        $codigoRedefinicao = rand(1000,9999);

        keyGerar:
        $key_reset = uniqid("key_",true);

        $smtp = $PDO->prepare("SELECT * from tb_resetPass where reset_key = :key");
        $smtp->execute(array("key"=>$key_reset));

        if($smtp->rowCount() > 0){goto keyGerar;}

        $smtp = $PDO->prepare("SELECT * from tb_resetPass where reset_user_id = :id");
        $smtp->execute(array("id"=>$user['user_id']));
        
        if($smtp->rowCount() > 0){
            $smtp = $PDO->prepare("DELETE from tb_resetPass where reset_user_id = :id");
            $smtp->execute(array("id"=>$user['user_id']));
        }


        $smtp = $PDO->prepare("INSERT INTO tb_resetPass values (:key , CURDATE(), :code , 0, :userid)");
        $smtp->execute(array(
            "key"=>$key_reset,
            "code"=>$codigoRedefinicao,
            "userid"=>$user['user_id']
            
        ));


        $envio = EnviarEmail($codigoRedefinicao);

        

        $json = array(
            "key"=>$key_reset,
            "status"=> $envio
        );

        echo json_encode($json);

}else{
    $json = array(
        "status"=> false,
        "email" => $dados->{'email'}
    );

    echo json_encode($json);
}







function EnviarEmail($codigoRedefinicao){
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
    $body = "
    <div style='width: 600px; background-color: #fff; text-align: center;'>
    <div style='width: 100%; height: 50px; background-color: #3F416C;'></div>
    <h1 style='color: #eba61e;'>STOK</h1>
    <h1 style='font-size: 25px;'>SEU CÓDIGO DE REDEFINIÇÃO É:</h1>
    <h2 style='font-size: 35px; margin: 30px auto; width: 100px; border: 1px solid #3F416C;'>$codigoRedefinicao</h2>
    <div style='width: 100%; height: 50px; background-color: #3F416C;'></div>
</div>
    ";



    return mail($para,$Assunto,$body,$headers);
}