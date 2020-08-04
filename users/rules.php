<?php

require_once __DIR__ . '/../class/connection.php';

class Rules
{

    private $db;

    public function __construct()
    {
        $this->db = new connectBD();
    }
    
    public function checkUser($whereParam, $user)
    {
        //Verify User
        $sql = sprintf(
            'SELECT * FROM user WHERE '. $whereParam, 
            $user
        );

        $result = $this->db->consultSQL($sql);

        return $result;
    }

    public function checkUserPass($user, $pass)
    {
        
        try{
            $user = trim($user);
            $pass = md5($pass);

            $returnArray = array();

            $whereParam = ' email = "%s"';
            $resultUser = $this->checkUser($whereParam, $user);

            if(!$resultUser) {
                //error user
                $returnArray['error'] = 'user';
            } else {
                //Verify pass if user ok    
                $sql = sprintf(
                    'SELECT id, email, name, drink_counter FROM user WHERE (email="%s" AND password="%s")', 
                    $user, 
                    $pass
                );

                $result = $this->db->consultSQL($sql);
            
                if(!$result){
                    //error pass
                    $returnArray['error'] = 'password';
                }
            }

            //OK array get result success
            if ($result) {
                $returnArray['data'] = array(
                    'id' => $result['data'][0]['id'],
                    'email' => $result['data'][0]['email'],
                    'name' => $result['data'][0]['name'],
                    'drink_counter' => $result['data'][0]['drink_counter']
                );
            }

            return $returnArray;

        } catch (\Exception $e) {
            echo $e;
        }
        
    }

    public function createUser($name, $user, $pass)
    {
        $pass = md5($pass);
        $params = array('name' => $name, 'email'=> $user, 'password' => $pass);

        $result = $this->db->executeInsert('user', $params);

        if ($result) {
            return true;
        } else {
            throw new \Exception('Create error.');
        }

    }

    public function listUser($id = null)
    {
        if($id) {
            $where = ' WHERE id = %d';
        }
        $sql = sprintf('SELECT * FROM user ' . $where, $id);
        $result = $this->db->consultSQL($sql);

        return $result;
    }

    public function updateUser($data, $id)
    {
        $where = ' WHERE id = :id';
        $whereParams = array('id' => $id); 
        $result = $this->db->executeUpdate('user', $data, $where, $whereParams);

        return $result;
    }
    
    public function deleteUser($id)
    {
        $where = ' WHERE id = :id';
        $whereParams = array('id' => $id); 
        $result = $this->db->executeDelete('user', $where, $whereParams);

        return $result;
    }

    public function drinkUser($id, $drink_counter, $ml)
    {
        $where = ' WHERE id = :id';
        $whereParams = array('id' => $id); 
        $drink_counter = array('drink_counter' => $drink_counter + 1);
        //update user count drinks
        $$result = $this->db->executeUpdate('user', $drink_counter, $where, $whereParams);

        $params = array('id_user' => $id, 'drink_ml' => $ml);
        //insert ml drink to user
        $result = $this->db->executeInsert('drinks', $params);
        return $result;
    }

    public function historyUser($id)
    {
        $sql = sprintf(
            'SELECT u.id,
                    u.name, 
                    d.date_drink, 
                    d.drink_ml  
                FROM user AS u 
                LEFT JOIN drinks AS d 
                    ON u.id = d.id_user 
                WHERE u.id = %d', $id
            );

            // print($sql);
        $result = $this->db->consultSQL($sql);

        return $result;
    }

    public function rankingUser()
    {
        $sql = 'SELECT u.id, 
                        u.name,
                        u.email AS user, 
                        SUM(d.drink_ml) AS ml
                    FROM drinks d
                    LEFT JOIN user AS u
                        ON u.id = d.id_user 
                    GROUP BY d.id_user
                    ORDER BY d.drink_ml DESC';

        $result = $this->db->consultSQL($sql);

        return $result;
    }

}
