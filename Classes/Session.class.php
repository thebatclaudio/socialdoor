<?php

/**
 * This is a PHP static class that makes it easy to use sessions
 */
class Session{

	/**
	 * Static method that check if session is already started
	 * @return boolean (TRUE if session is already started)
	 */
	public static function isStarted(){
		if(session_id() == '') {
			return false;
		} else {
			return true;
		}		
	}

	/**
	 * Static method that set a session variable
	 * @param string $key (the name of variable)
	 * @param mixed $value (the value of variable)
	 */
	public static function set($key, $value){
		if(Session::isStarted())
			$_SESSION[$key] = $value;
	}

	/**
	 * Static method that get a session variable
	 * @param string $key (the name of variable)
	 * @return mixed (the value of variable if it exists and session is started, else null)
	 */
	public static function get($key){
		if(Session::isStarted())
			if(isset($_SESSION[$key]))
				return $_SESSION[$key];
			else
				return null;
		else
			return null;
	}

	/**
	 * Static method that start session
	 * @param array $data (if you want to initialize session with existing data put them as parameter)
	 */
	public static function startSession($data = false){
		if(!Session::isStarted()){
		    session_start();
    		if($data){
    			foreach($data as $key=>$value)
    				Session::set($key,$value);
    		}
        }
	}

	/**
	 * Static method that destroy session
	 */
	public static function destroySession(){
		if(Session::isStarted())
			session_destroy();
	}
    
    /**
     * Static method that check if user is logged (created for SocialDoor)
     */
    public static function isLogged(){
        if(Session::isStarted()){
            if(Session::get("loggedin")==1){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>