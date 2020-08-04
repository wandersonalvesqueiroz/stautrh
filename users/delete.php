<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    try {

        $id = $_GET['id'];

        $objRule = new Rules();
        $whereParam = ' id = %d';
        $data = $objRule->checkUser($whereParam, $id);

        if($data){
            $return = $objRule->deleteUser($id);
            if($return)
                return true;
        } else{
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


