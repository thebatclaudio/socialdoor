<?php
session_start();
header("Content-type: text/css");
include "../includes/mysqlclass.class.php";
include "../includes/room.class.php";
$mysql = new MySqlClass();
$mysql -> connect();
if (!isset($_GET['id']) OR !is_numeric($_GET['id']))
	$id = $_SESSION['user'] -> idUser;
else
	$id = $_GET['id'];
$result = $mysql -> query("SELECT * FROM rooms WHERE idUser = $id");
$room = mysql_fetch_object($result, 'room');
?>

body{
color: <?php echo $room -> getTextColor1();?>;
background: <?php
if ($room -> getBg() != 1)
	echo $room -> getBg();
else
	echo "url('../bgs/$id.jpg?id=" . rand(0, 999999) . "') center center repeat fixed";
?>;
}
.date, .date span{
color: <?php echo $room -> getTextColor1();?>;
}
a:link,a:visited,a:active{
color: <?php echo $room -> getTextColor1();?>;
text-decoration: underline;
}
h1,h2,h3,h4,.postblock h3,a:hover, span a:link, span a:hover, span a:visited, span a:active{
color: <?php echo $room -> getTextColor2();?>;
}
#ringTheBellButton,#ringTheBellButton:hover,.doorbell:hover,.doorbell,.submitPhoto,.submitPhoto:hover,.submit,.submit:hover{
background-color: <?php echo $room -> getTextColor2();?>;
color: <?php echo $room -> getTextColor1();?>;
}
#ringTheBellButton:hover, .doorbell:hover{
cursor: pointer;
}
#topBarLeft a:link,#loggedname, .dx_menu li a, #userInfoRight ul li a, #buttons a:link, .divFooter a:link, span a:link{
text-decoration: none;
}
.owner a:hover{
color: <?php echo $room -> getTextColor2();?>;
}
#commentInput{
background: <?php echo $room -> getBgPost();?>;
color: <?php echo $room -> getTextColor1();?>;
}
input, select, option{
background: <?php echo $room -> getBgPost();?>;
color: <?php echo $room -> getTextColor1();?>;
}
#post{
background: <?php echo $room -> getBgPost();?>;
color: <?php echo $room -> getTextColor1();?>;
}
#search{
color: <?php echo $room -> getTextColor1();?>
}
.dx_menu li a:link,.dx_menu li a:visited,.dx_menu li a:active,#topBarLeft a:link,#topBarLeft a:active,#topBarLeft a:visited,#edit a:hover, #edit a:link, #edit a:active, #edit a:visited{
color: #DDD;
}
#topBarLeft a:hover,.dx_menu li a:hover{
color: #55F;
}
#saveroom:hover{
cursor: pointer;
}
.post, #userInfo, #search{
background-color: <?php echo $room -> getBgPost();?>;
}
#newNotif{
color: #fff;
}
#newNotif a:link, #newNotif a:active, #newNotif a:visited{
color: #fff;
}
#newNotif a:hover{
color: #05f;
}