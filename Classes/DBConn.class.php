<?php
/**
 * Class which manage database connection using PDO
 */

class DBConn
{
	private $db_host;
	private $db_user;
	private $db_password;
	private $db_name;
	private $db_type;
	private static $conn;
	private $transaction = false;
	public $commit=0; //da settare a 1 se si deve committare, 0 altrimenti.
	public $lastQuery = "";
	public $lastInsertID = "";
	public $logger;


	public function __construct() {
		$this->db_host = HOST;
		$this->db_user = DB_USER;
		$this->db_password = DB_PASS;
		$this->db_name = DB_NAME;
		$this->db_type = DB_TYPE;
		$this->accessToDB();
	}

	/**
	 * Method that access to DB 
	 */
	public function accessToDB()
	{
		if(!self::$conn){
			$dbconn = "{$this->db_type}:host={$this->db_host};dbname={$this->db_name}";
			try{
				self::$conn = new PDO($dbconn,$this->db_user,$this->db_password, array( PDO::ATTR_PERSISTENT => true));
				self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $pe) {
				self::$conn = $pe->getMessage();
                printError($pe->getMessage());
			}
		}
	}

	/**
	 * Method that close connection
	 */
	public function close(){
		self::$conn = null;
	}

	/**
	 * Method that quote the parameter's string 
	 * @param string $var
	 */
	public function quote($var){
		if(!is_object(self::$conn)){
			$this->accessToDB();
		}
		 
		return self::$conn->quote($var);
		 
	}

	/**
	 * Method that execute a query
	 * It return query's result or false if it can execute query
	 * @param string $sql
	 */
	public function execute($sql)
	{
		$result = null;
		
		if(!is_object(self::$conn)){
			$this->accessToDB();
		}
		
		try{
			$result = self::$conn->query($sql);
			$this->lastInsertID = self::$conn->lastInsertId();
		} catch (PDOException $err) {
			$result = false;
		}
		 
		$this->lastQuery = $sql;
		 
		return $result;
	}

	/**
	 * Method that start a transaction
	 * It returns true in success case
	 * @return boolean
	 */
	public function startTransaction(){
		if(!is_object(self::$conn)){
			return false;
		} else {
			$conn = self::$conn;
			if(!$this->transaction){
				if($conn->beginTransaction()){ //se parte la transazione
					$this->transaction = true;
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
	}

	/**
	 * Method that stop a transaction
	 * It returns true in success case
	 * @return boolean
	 */
	public function stopTransaction(){
		if(!is_object(self::$conn)){
			return false;
		} else {
			if($this->transaction){
				switch ($this->commit){
					case COMMIT://commit
						$result=self::$conn->commit();
						break;

					case ROLLBACK: //rollback
						$result=self::$conn->rollBack();
						break;

					default:
						$result=self::$conn->rollBack();
				}
				return $result;
			} else {
				return false;
			}
		}
	}
}

?>