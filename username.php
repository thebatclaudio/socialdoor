<?php
	include('./includes/mysqlclass.class.php');

	$mysql = new MySqlClass();
	$mysql->connect();
	
	$result = $mysql->query("SELECT * FROM users");
	while($user = mysql_fetch_array($result)){
		$username = str_replace(' ','',$user['name']).".".str_replace(' ','',$user['surname']).$user['idUser'];
		$mysql->query("UPDATE users SET username = '$username' WHERE idUser = ".$user['idUser']);
	}
?>