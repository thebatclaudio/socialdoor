<?php
//script per cancellare un post

//apro la sessione
session_start();

//se l'utente non è loggato lo reindirizzo al login
if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
    header('location: login.php?error=1');
}

include "./includes/mysqlclass.class.php";
include "./includes/post.class.php";
include "./includes/user.class.php";

$user = new user($_SESSION['user']);

$mysql = new MySqlClass();
$mysql->connect();

include "header.php";
?><div id="container"><div id="header">
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
if(!is_numeric($_GET['id'])){
    die('<h3>Si &egrave; verificato un errore</h3>');
}

$id = $_GET['id'];

$result = $mysql->query("SELECT * FROM posts WHERE idPost = $id");
$post = mysql_fetch_object($result,'post');
if($user->getId()==$post->getIdUser() OR $user->getId()==$post->getIdOwner()){
	$mysql->query("DELETE FROM posts WHERE idPost = $id");
	$mysql->query("DELETE FROM comments WHERE idPost = $id");
	$mysql->query("DELETE FROM posts_users WHERE idPost = $id");
	echo "<h3>Il post &egrave; stato cancellato correttamente</h3>";
	$mysql->disconnect();
} else {
	echo "<h3>Non provare ad eliminare un post che non &egrave; tuo. Grazie</h3>";
}

?>
</div></div></body></html>