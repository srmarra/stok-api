<?php
    require_once("../util/pdo_connect.php");

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);
    $key = $dados->{'key'};
    
    

    $smtp = $PDO->prepare("SELECT A.auth_key,U.user_id FROM tb_auth A INNER JOIN tb_user U on U.user_id = A.auth_user_id WHERE A.auth_key = :key ");
    $smtp->execute(array(
        "key"=>$key
    ));

    if($smtp->rowCount() >0){
        $user = $smtp->fetch();

        $smtp= $PDO->prepare("SELECT * FROM tb_produtos where prod_user_id = :id order by prod_id desc");
        $smtp->execute(array(
            "id"=>$user['user_id']
        ));
        $json = array();
        while($resp = $smtp->fetch()){
            $in = array(
                "id"=>$resp['prod_id'],
                "titulo"=>$resp['prod_titulo'],
                "desc"=>$resp['prod_desc'],
                "preco"=>$resp['prod_preco'],
                "qnt"=>$resp['prod_qnt'],
            );
            array_push($json,$in);
        }

        echo json_encode($json);

    }else{

        $json = array(
            "status"=>false,
        );
        echo json_encode($json);
    }



    
