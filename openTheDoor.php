<?php
    session_start();
    
    if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
        header('location: login.php?error=1');
    }
    
    if(!isset($_GET['id'])){
        header('home.php');
    }
    
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    
    $door = new user($_SESSION['user']);
    $mysql = new MySqlClass();
    $idUser = $_GET['id'];
    
    $query = "UPDATE  openedDoors SET accepted = 1 WHERE idUser= $idUser AND idDoor = ".$door->getId();
    $mysql->connect();
   
    $mysql->query($query);
    
    $t='notifications';
    $content = "<a href=\'room.php?id=".$door->getId()."'>".$door->getCompleteName()."</a> ti ha aperto la porta.";
    $v = array($idUser,$content);
    $r = 'idUser, content';
    
    $mysql->insert($t,$v,$r);
    
    $mysql->disconnect();  
    
    header('location: room.php?id='.$idUser);
?>