<?php

class ManagerBaseServices
{

    /**
     * Função para transformar um array de objetos em uma string serializada com JSON
     * @param type $arrayObject
     * @return string
     */
    public function returnJSON($arrayObject = null)
    {
        return json_encode($arrayObject);
    }

}
