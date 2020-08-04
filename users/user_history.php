<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    try {

        $idUser = $_GET['id'];
        
        $objRule = new Rules();
        $data = $objRule->historyUser($idUser);

        if($data['data']){
            $json = $baseController->returnJSON(array('data' => $data['data']));
            echo $json;
            exit;
        } else {
            throw new Exception('User does not exist', 1);
        }
        
    } catch (\Exception $exc) {
        $json = $baseController->returnJSON(
            array(
                'message'=> $exc->getMessage(),
                'ErrorCode' => $exc->getCode()
            )
        );
        echo $json;
        exit;
    }
}
else{
    $json = $baseController->returnJSON(array('ErrorCode' => 0));
    echo $json;
    exit;
}


