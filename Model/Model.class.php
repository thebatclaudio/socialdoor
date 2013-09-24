<?php

	/**
	 * Generic model class
	 */

	class Model{
		
		protected $table;
		protected $db;
		
		public function __construct(){
			$this->db = new DBConn();
		}
        
        /**
         * Method that execute a query and return an object that contains row's data
         * @param $sql (sql to execute)
         * @return $object (object that contains row's data)
         */
        protected function get_record_sql($sql){
            $object = null;
    
            try{
                $result = $this->db->execute($sql);
                if($result){
                    $object = $result->fetch(PDO::FETCH_OBJ);
                } else {
                    printError("ERROR QUERY : ".$sql);      
                }      
            } catch(PDOException $err) {
                printError($err->getMessage());
            } catch (Exception $e) {
                printError($e->getMessage());
            }
    
            return $object;
        }
        
        /**
         * Method that execute a query and return an array of objects that contains row's data
         * @param $sql (sql to execute)
         * @return $object (array of object that contains row's data)
         */        
        protected function get_records_sql($sql){
            $object =array();
    
            try{
                $result = $this->db->execute($sql);
                if($result){
                    $object = $result->fetchAll(PDO::FETCH_OBJ);
                } else {
                    printError("ERROR QUERY : ".$sql);
                }
            } catch(PDOException $err) {
                printError($err->getMessage());
            }
    
            return $object;
        }
        
        /**
         * Method that check if a record exists in db
         * @param $query (sql to execute)
         * @return boolean (true if exists)
         */
        protected function record_exists($query){
            if($this->get_record_sql($query))
                return true;
            else
                return false;
        }
        
        /**
         * Method that get a row by a field passed in array (example: array('id'=>1))
         * @param $array (filters)
         * @return object
         */
        public function getRowByFields($array){
            if(!empty($array)){
                $table = $this->table;
                $sql = "SELECT * FROM {$table} WHERE 1 = 1 ";
                foreach($array as $key=>$value){
                    $sql.= "AND {$key} = '{$value}' ";
                }
                return $this->get_record_sql($sql);
            }
        }
        
        /**
         * Method that returns id of last insert's row
         * @return integer
         */
        public function getLastInsertID(){
            return $this->db->lastInsertID;
        }
    
	}

?>