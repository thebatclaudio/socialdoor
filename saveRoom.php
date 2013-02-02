<?php
    session_start();
    if($_SESSION['loggedin']!=1){
        header('location: login.php?error=1');
    }
    
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    
    $mysql = new MySqlClass();
    $mysql->connect();
    $user = new user($_SESSION['user']);
    if($_POST['bgColor']=="#FFFFFF"){
        $bgColor = 1;
    } else {
        $bgColor = $_POST['bgColor'];
    }
    $mysql -> query("UPDATE rooms SET bgColor = '".htmlspecialchars(strip_tags($bgColor))."', textColor1 = '".htmlspecialchars(strip_tags($_POST['textColor1']))."', textColor2 = '".htmlspecialchars(strip_tags($_POST['textColor2']))."', bgPost = '".htmlspecialchars(strip_tags($_POST['bgPost']))."' WHERE idUser = ".$user -> getId());
    $mysql -> disconnect();
    
    header('location: room.php?id='.$user->getId());  
?>
