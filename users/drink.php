<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        $id = $_GET['id'];
        $ml = $_POST['drink_ml'];

        $objRule = new Rules();
        $whereParam = ' id = %d';
        $data = $objRule->checkUser($whereParam, $id);

        if($data){
            $drink_counter = $data['data'][0]['drink_counter'];
            $return = $objRule->drinkUser($id, $drink_counter, $ml);
            if($return)
                return true;
        }else{
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


