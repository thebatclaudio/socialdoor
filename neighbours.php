<?php
    session_start();
    if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
        header('location: login.php?error=1');
    
    include "./includes/user.class.php";
    include "./includes/mysqlclass.class.php";
    
    $user = new user($_SESSION['user']);
    $mysql = new MySqlClass();
    $mysql->connect();

    $result = $mysql->query("SELECT * FROM openedDoors,users WHERE openedDoors.idDoor = users.idUser AND openedDoors.idUser = ".$user->getId()." AND accepted = 1");
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
    $flag = 0;
    while ($obj = mysql_fetch_object($result)) {  
        if ($flag == 0) {
            $flag = 1;
            echo "<div class='div' style='margin-top: 30px'></div><h2 class='notifTitle'>Porte aperte</h2><div class='div'></div><div id='content'><ul style='list-style: none;'>";
        }
        echo "<li style='font-size: 16px;' height='30px'><img src='"; 
        if($obj->pic==0)
            echo "./css/img/profile_photo.png";
        else
            echo "./photos/".$obj->idUser.".jpg?imm=".rand(0,99999);
        echo "' height='35px' align='left'><a style='text-decoration: underline' href='room.php?id=" . $obj->idUser . "'>" . $obj->name . " " . $obj->surname . "</a></li><br /><br />";
    }
    if ($flag == 1) {
        echo "</ul></div><br /><br /><br /><br /><br />";
    } else {
        if (!isset($obj->idUser))
            echo "<div class='div' style='margin-top: 30px'></div><h2 class='notifTitle'>Nessuno ti ha aperto la porta</h2><div class='div'></div><div id='content'><br /><br /></div>";
    }
?>

<?php
    $result = $mysql->query("SELECT * FROM openedDoors,users WHERE openedDoors.idUser = users.idUser AND openedDoors.idDoor = ".$user->getId()." AND accepted = 1");
    $flag = 0;
    while ($obj = mysql_fetch_object($result)) {  
        if ($flag == 0) {
            $flag = 1;
            echo "<div class='div'></div><h2 class='notifTitle'>Persone a cui hai aperto la porta</h2><div class='div'></div><div id='content'><ul style='list-style: none;'>";
        }
        echo "<li style='font-size: 16px;' height='30px'><img src='"; 
        if($obj->pic==0)
            echo "./css/img/profile_photo.png";
        else
            echo "./photos/".$obj->idUser.".jpg?imm=".rand(0,99999);
        echo "' height='35px' align='left'><a style='text-decoration: underline' href='room.php?id=" . $obj->idUser . "'>" . $obj->name . " " . $obj->surname . "</a></li><br /><br />";
    }
    if ($flag == 1) {
        echo "</ul></div>";
    } else {
        if (!isset($obj->idUser))
            echo "<div class='div'></div><h2 class='notifTitle'>Non hai aperto la porta a nessuno</h2><div id='div'></div><div id='content'>";
    }
?>
</div></body></html>