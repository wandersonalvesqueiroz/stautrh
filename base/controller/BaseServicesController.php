<?php

require_once 'BaseController.php';

class BaseServicesController extends BaseController
{

    public function init()
    {
        header('Access-Control-Allow-Origin:*');
        $auth = parent::services();
        try {
            parent::init();
        } catch (Exception $e) {
            $json = $auth->returnJSON();
            echo $json;
            exit;
        }
    }

    /**
     * Função para transformar um array de objetos em uma string serializada com JSON
     * @param type $arrayObject
     * @return string
     */
    public function returnJSON($arrayObject = null)
    {
        return json_encode($arrayObject) ;
    }

}
