<?php
	/**
	 * Controller generic class
	 */

    class Controller{
    	
		private $action = false;
    	
		public function set($key,$value){
			$this->$key = $value;
		}
		
		public function get($key){
		    if(property_exists($this, $key))
			     return $this->$key;
            else return NULL;
		}
		
		public function play(){
			if($this->action){
				$action = $this->action;
                if(method_exists($this, $action))
				    $this->$action();
			}
		}
    }
?>