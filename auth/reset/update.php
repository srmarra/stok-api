<?php


    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    $email = $dados->{'email'};

    require_once("../../util/pdo_connect.php");//Conexão com banco de dados

    $smtp = $PDO->prepare("SELECT * FROM tb_resetPass where reset_key = :key and reset_status = 1");

$smtp->execute(array(
    "key"=> $dados->{'key'}
));


if($smtp->rowCount() == 1){
    $reset = $smtp->fetch();

    $smtp = $PDO->prepare("UPDATE tb_user set user_password = :senha where user_id = :id");

    $smtp->execute(array(
        "senha"=> $dados->{'senha'},
        "id"=> $reset->{'reset_user_id'}
    ));

    
    $json = array(
        "status"=>true
    );

    echo json_encode($json);

}else{
    $json = array(
        "status"=>false
    );
    echo json_encode($json);
}