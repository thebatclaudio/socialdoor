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
        $sql = "SELECT idUser, name, surname, pic FROM users";
        $users = $this->get_records_sql($sql);
        $returnUsers = array();
        foreach($users as $user){
        	$object = new stdClass();
        	$object->name = $object->value = utf8_encode($user->name." ".$user->surname);
        	$object->id = $user->idUser;
        	if($user->pic==1)
        		$object->pic = $object->id.".jpg";
        	else
        		$object->pic = "../img/profile_photo.png";
            $returnUsers[] = $object;
        }
        return $returnUsers;
    }

}

?>