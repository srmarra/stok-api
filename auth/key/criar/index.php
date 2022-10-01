<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once('../../../util/pdo_connect.php');
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);


    if(isset($dados->{"email"})){
    $email = $dados->{"email"};
    $senha = $dados->{"senha"};
    $status = false;


    $stmt = $PDO->prepare('SELECT * from tb_user where user_email = :email');
    $stmt->execute(array('email' => $email));
    $keyreturn = "";
    if($stmt->rowCount() == 1){
        $user = $stmt->fetch();
        if(password_hash("1234", PASSWORD_DEFAULT) == '$2y$10$OLfxIDX39WUxhvaUktbSZOxoQ2tMxwCLcWmLhjOQp4tGUIjSngaVW'){
            regenerar:
            $key = uniqid("key_",true);
            $stmt = $PDO->prepare('SELECT * from tb_auth where auth_key = :key');
            $stmt->execute(array(
                "key" => $key
            ));
            if($stmt->rowCount() > 0){
                goto regenerar;
            }else{
                $stmt = $PDO->prepare('SELECT * from tb_auth where auth_user_id= :id');
                $stmt->execute(array(
                    "id" => $user['user_id']
                ));
                if($stmt->rowCount() > 0){
                    $stmt = $PDO->prepare('DELETE from tb_auth where auth_user_id = :id');
                    $stmt->execute(array(
                        "id" => $user['user_id']
                    ));
                }
                try{
                    $stmt = $PDO->prepare('INSERT INTO tb_auth VALUES (:key , CURDATE() , :id )');
                    $stmt->execute(array(
                        "key" => $key,
                        "id" => $user['user_id']
                    ));
                    $status = true;
                    $keyreturn = $key;
                }catch(Exception $e){
                        

                }
            }

        }
    }

    $return = array(
        "status" => $status,
        "key" => $keyreturn
    );

    echo(json_encode($return));
    }else{
        $return = array(
            "status" => false,
            "key" => ""
        );
        echo(json_encode($return));
    }

?>