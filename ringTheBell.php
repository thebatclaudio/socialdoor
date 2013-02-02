<?php
session_start();

if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('login.php?error=1');

include ('./includes/mysqlclass.class.php');

$mysql = new MySqlClass();

$mysql->connect();

if(!is_numeric($_POST['idUser']) OR !is_numeric($_POST['idDoor']) OR !isset($_POST['message']) OR trim($_POST['message'])==""){
    die("KO");
}

$idUser = $_POST['idUser'];
$idDoor = $_POST['idDoor'];
$message = trim(htmlspecialchars(strip_tags($_POST['message'])));
$name = $_SESSION['user']->name;

$t='openedDoors';
$v= array($idUser,$idDoor,$message);
$r= 'idUser, idDoor, message';

$mysql->insert($t,$v,$r); 

$t='openedDoors';
$v= array($idDoor,$idUser,$message,1);
$r= 'idUser, idDoor, message, accepted';

$mysql->insert($t,$v,$r); 

$content = "<a href=\'room.php?id=$idUser\'>".$_SESSION['user']->name." ".$_SESSION['user']->surname."</a> ha bussato alla tua porta dicendo <span>$message</span>. <a href=\'openTheDoor.php?id=$idUser\'>Aprigli la porta</a>";

$t='notifications';
$v= array($idDoor,$content);
$r= 'idUser, content';

$mysql->insert($t,$v,$r); 

echo 'OK';

$mysql->disconnect();
?>
