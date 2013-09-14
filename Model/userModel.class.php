<?php
/**
 * Model that manage user's informations
 */
class userModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->table = "users";
    }
    
    /**
     * Method that effectuate login
     * @param $username (username)
     * @param $password (hashed password)
     * @return boolean 
     */
    public function login($username,$password){
        $sql = "SELECT * FROM users WHERE email = '{$username}' AND password='{$password}'"; 
        if($this->record_exists($sql)){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Method that get all users'names for JSON encode
     * @return array (users'name)
     */
    public function getAllUsersJSON(){
        $sql = "SELECT name, surname FROM users";
        $users = $this->get_records_sql($sql);
        $returnUsers = array();
        foreach($users as $user){
            $returnUsers[] = utf8_encode($user->name." ".$user->surname);
        }
        return $returnUsers;
    }

}

?>