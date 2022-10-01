<?php
    $user = "u337436534_stok";
    $password = '/l0X!KVl';
    try{
        $PDO = new PDO('mysql:host=92.249.44.52;dbname=u337436534_stok',$user,$password);
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo 'ERROR'.$e->getMessage();
    }

?>
