<?php

require_once __DIR__.'/../service/ManagerBaseServices.php';

class BaseController
{

    protected $_params;
    protected $_config;

    public function init()
    {
        ini_set('display_errors', 0);

        $this->services = new ManagerBaseServices();
        $this->_config = parse_ini_file(__DIR__.'../../../config.ini', true);
        $this->_params = $_REQUEST;

        $this->getParams();

    }

    protected function getParams()
    {
        foreach ($this->_params as $chave => $valor) {
            $this->$chave = $valor;
        }
        $this->_paginaAtual = $_SERVER['REQUEST_URI'];
    }

    protected function services()
    {
        $services = new ManagerBaseServices();
        return $services;
    }


}
