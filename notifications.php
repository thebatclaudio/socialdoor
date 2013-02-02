<?php 
    session_start(); 
    
    if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
        header('location: login.php?error=1');
   
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    include "./includes/notification.class.php";
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
    <h2 id="notifTitle">Notifiche</h2>
    <div id="div"></div>
    <div id="content">
    <?php
    $mysql = new MySqlClass();
    $mysql->connect();

    $result = $mysql->query("SELECT * FROM notifications WHERE idUser = ".$user->getId()." ORDER BY idNotification DESC");
    
    echo "<ul>";
    $data = null;
    while ($notification = mysql_fetch_object($result,'notification')) {
        if($notification->getOnlyDate()!=$data){
            $data=$notification->getOnlyDate();
            echo "<h3>$data</h3>";
        }
        echo "<li>";
        echo "<span>".$notification->getDate()."</span><br /><p class='notifContent'>".$notification->getContent();
        echo "</p></li><br />";
        $mysql->query("UPDATE notifications SET `read` = 1 WHERE idNotification = ".$notification->getId());
    }
    echo "</ul>";
    $mysql->disconnect();
?>
</div>
</div>
</div>
</body>
</html> 