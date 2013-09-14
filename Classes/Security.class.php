<?php
/**
 * Class with static methods that help to make safe the application
 */
class Security {
    
    /**
     * Method that make hash of concatenation of email and password (passwords are saved in this mode in DB) 
     */
    public static function hashing($email, $password){
        return hash("sha256",$email.$password);
    }
    
    /**
     * Method that clean variables to prevent SQL injections
     */
    public static function clean($var){
        return trim(filter_var($var, FILTER_SANITIZE_STRING));
    }
    
    /**
     * Method that returns user's IP
     */
    public static function getIP(){
        return $_SERVER['REMOTE_ADDR'];
    }
    
}

?>