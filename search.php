<?php
session_start();

$search = trim(filter_var($_POST['search'],FILTER_SANITIZE_STRING));

if(!isset($search) OR $search == "" OR strstr($search,"%"))
    $search = "Nessuno";

include "./includes/mysqlclass.class.php";
include "./includes/user.class.php";

$user = new user($_SESSION['user']);

include "header.php";

?>
<div id="container">
    <div id="header">
                <div id="right">
                    <form action="search.php" method="post">
                        <input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
                    </form>
                </div>
                <div id="left">
                    <a href="home.php" title="Torna alla home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
                </div>
            </div>	
<?php
    $mysql = new MySqlClass();
    $mysql->connect();
    $result = $mysql->query("SELECT * FROM users WHERE CONCAT(name,' ',surname) LIKE '%" . $search . "%'");
	$flag = 0;
	while ($obj = mysql_fetch_object($result)) {  
		if ($flag == 0) {
			$flag = 1;
			echo "<h2 id='notifTitle'>Risultati per \"" . $search . "\"</h2><div id='div'></div><div id='content'><ul style='list-style: none;'>";
		}
		echo "<li style='font-size: 16px;' height='30px'><img src='"; 
        if($obj->pic==0)
            echo "./css/img/profile_photo.png";
        else
            echo "./photos/".$obj->idUser.".jpg";
		echo "' height='35px' align='left'><a style='text-decoration: underline' href='room.php?id=" . $obj->idUser . "'>" . $obj->name . " " . $obj->surname . "</a></li><br /><br />";
	}
	$result = $mysql->query("SELECT * FROM users WHERE email = '$search'");
	while ($obj = mysql_fetch_object($result)) {  
		if ($flag == 0) {
			$flag = 1;
			echo "<h2 id='notifTitle'>Risultati per \"" . $search . "\"</h2><div id='div'></div><div id='content'><ul style='list-style: none;'>";
		}
		echo "<li style='font-size: 16px;' height='30px'><img src='"; 
        if($obj->pic==0)
            echo "./css/img/profile_photo.png";
        else
            echo "./photos/".$obj->idUser.".jpg";
		echo "' height='35px' align='left'><a style='text-decoration: underline' href='room.php?id=" . $obj->idUser . "'>" . $obj->name . " " . $obj->surname . "</a></li><br /><br />";
	}
	if ($flag == 1) {
		echo "</ul>";
	} else {
		if (!isset($obj->idUser))
			echo "<h2 id='notifTitle'>Nessun risultato per \"" . $search . "\"</h2><div id='div'></div><div id='content'>";
	}
?>
</div></div></body></html>
