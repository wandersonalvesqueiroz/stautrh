<?php

require_once '../init.php';
require_once 'rules.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
    try {

        parse_str(file_get_contents('php://input'), $_PUT);

        $id = $_GET['id'];
        $name = $_PUT['name'];
        $user = $_PUT['email'];
        $pass = $_PUT['password'];

        $dataUser = array(
            'name' => $name,
            'email' => $user,
            'password' => md5($pass)
        );

        $objRule = new Rules();
        $whereParam = ' id = %d';
        $dataId = $objRule->checkUser($whereParam, $user);

        $whereParam = ' email = "%s"';
        $data = $objRule->checkUser($whereParam, $user);

        if((isset($data['data'][0]['id']) && $data['data'][0]['id'] == $id) || (empty($data) && !empty($dataId))){
            $return = $objRule->updateUser($dataUser, $id);
            if($return)
                return true;
        } elseif (isset($data['data'][0]['id']) && $data['data'][0]['id'] != $id){
            throw new Exception('Another user already exists using this login', 1);
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


