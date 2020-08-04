<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    try {

        $idUser = '';
        if(isset($_GET['id'])){
            $idUser = $_GET['id'];
        }
        
        $objRule = new Rules();
        $data = $objRule->listUser($idUser);

        if($data['data']){
            $json = $baseController->returnJSON(array('data' => $data['data']));
            echo $json;
            exit;
        }
        
    } catch (\Exception $exc) {
        $json = $baseController->returnJSON(array('ErrorCode' => $exc->getCode()));
        echo $json;
        exit;
    }
}
else{
    $json = $baseController->returnJSON(array('ErrorCode' => 0));
    echo $json;
    exit;
}


