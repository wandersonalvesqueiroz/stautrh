<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        $name = $_POST['name'];
        $user = $_POST['email'];
        $pass = $_POST['password'];

        $objRule = new Rules();
        $whereParam = ' email = "%s"';
        $data = $objRule->checkUser($whereParam, $user);
        
        if(!$data){
            $return = $objRule->createUser($name, $user, $pass);
            if($return)
                return true;
        }else{
            throw new Exception('Existing user', 1);
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


