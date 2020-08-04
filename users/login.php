<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        $user = $_POST['email'];
        $pass = $_POST['password'];

        $objRule = new Rules();
        $data = $objRule->checkUserPass($user, $pass);


        if(isset($data['error'])){
            $json = $baseController->returnJSON(array('error' => $data['error']));
        }

        if(isset($data['data'])){
            $json = $baseController->returnJSON(array('data' => $data['data']));
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['auth'] = $data['data'];
        }

        echo $json;
        exit;
        
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


