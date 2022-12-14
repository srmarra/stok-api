<?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once("../../util/pdo_connect.php");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);
    $key = $dados->{'key'};
    
    

    $smtp = $PDO->prepare("SELECT A.auth_key,U.user_id FROM tb_auth A INNER JOIN tb_user U on U.user_id = A.auth_user_id WHERE A.auth_key = :key ");
    $smtp->execute(array(
        "key"=>$key
    ));


    if($smtp->rowCount() >0){
        $user = $smtp->fetch();

        $smtp = $PDO->prepare("INSERT INTO tb_produtos values(null, :titulo , :descr , :preco , :qnt , :id )");
        
        $smtp->execute(array(
            "titulo"=>$dados->{'titulo'},
            "descr"=>$dados->{'descricao'},
            "preco"=>$dados->{'preco'},
            "qnt"=>$dados->{'quantidade'},
            "id"=>$user['user_id']
        ));
        

        $json = array(
            "status"=>true,
            "id"=>$user['user_id']
        );
        echo json_encode($json);
    }else{
        $json = array(
            "status"=>false,
        );
        echo json_encode($json);
    }

    
    