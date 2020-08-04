<?php

//Se a classe já foi definida, não a define novamente
if (class_exists('connectBD'))
    return;

class connectBD {
    
    public static $conexao = null;
    public static $instance = null;

    /** @var \PDO */
    public static $PDO = null;

    function __construct() {
        if (self::$PDO == null) {
            $host = 'localhost';
            $dbname = 'bd_prova';
            $charset = 'utf8';
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            $opcoes = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            );
            $usuario = 'root';
            $password = '';
            self::$PDO = new PDO($dsn, $usuario, $password, $opcoes);
        }
    }

    public function executeInsert($table, $params, $where = NULL, $whereParams = NULL) {

        try{
            $thisColumns = implode(', ', array_keys($params));
            $thisValues = preg_filter('/^/', ':', array_keys($params));
            $thisValues = implode(', ', $thisValues);
            
            $pdo = self::$PDO;
            $stmt = $pdo->prepare("INSERT INTO $table ($thisColumns) VALUES ($thisValues) $where");
            foreach($params AS $colum => $v){
                $stmt->bindValue(":$colum", $v); 
            }
            //Params Where Clause
            if($whereParams){
                foreach($whereParams AS $colum => $v){
                    $stmt->bindValue(":$colum", $v); 
                }
            }
            $stmt->execute();
            return true;
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function consultSQL($sql) {
        
        $result = false;
        
        try {
            $result = self::$PDO->query($sql);
            $result = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                $result = array(
                    'data' => $result,
                );
            }

            return $result;

        } catch (\Exception $e) {
            echo 'Error consult';
        }
    }

    public function executeUpdate($table, $params, $where = NULL, $whereParams = NULL) {
        
        try{
            $thisValues = array();

            foreach($params AS $colum => $v){
                array_push($thisValues, "$colum = :$colum");
            }

            $thisValues = implode(', ', $thisValues);

            $pdo = self::$PDO;
            $stmt = $pdo->prepare("UPDATE $table SET $thisValues $where");
            foreach($params AS $colum => $v){
                $stmt->bindValue(":$colum", $v); 
            }
            //Params Where Clause
            if($whereParams){
                foreach($whereParams AS $colum => $v){
                    $stmt->bindValue(":$colum", $v); 
                }
            }
            
            $stmt->execute();

            return true;
        } catch (\Exception $e) {
            echo $e;
        }
    }


    public function executeDelete($table, $where = NULL, $whereParams = NULL) {

        try{
            $pdo = self::$PDO;
            $stmt = $pdo->prepare("DELETE FROM $table $where");
            //Params Where Clause
            if($whereParams){
                foreach($whereParams AS $colum => $v){
                    $stmt->bindValue(":$colum", $v); 
                }
            }
            
            $stmt->execute();

            return true;
        } catch (\Exception $e) {
            echo $e;
        }
    }


    /**
     * @return \connectBD
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

}
