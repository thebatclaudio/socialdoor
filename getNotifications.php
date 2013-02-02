<?php
	session_start();
    
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    
    $mysql = new MySqlClass();
	
	$mysql->connect();
    
    $user = new user($_SESSION['user']);
	
	$result = $mysql->query("SELECT * FROM notifications WHERE idUser = ".$user->getId()." AND `read` = 0 ORDER BY idNotification");
    
	$cont=0;
	
	while($line = mysql_fetch_array($result)) 
	{		
		$cont++;
	}
	
	if($cont>0)
		echo $cont;
	
	$mysql->disconnect();
?>
