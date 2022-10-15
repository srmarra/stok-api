<?php

    //Db config
    $user = "u337436534_stok";
    $password = '/l0X!KVl';
    $dbname = 'u337436534_stok';
    $host = "92.249.44.52";


    try{
        $PDO = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo 'ERROR'.$e->getMessage();
    }

?>
