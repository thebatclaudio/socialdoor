<?php
session_start();

if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('login.php?error=1');

include "./includes/mysqlclass.class.php";
include "./includes/post.class.php";

if(!is_numeric($_POST['idOwner']) OR !is_numeric($_POST['idUser']) OR !isset($_POST['postMessage']) OR trim($_POST['postMessage'])==""){
    die('KO');
}

$mysql = new MySqlClass();

$mysql->connect();

$idOwner = $_POST['idOwner'];
$idUser = $_POST['idUser'];
    if (strstr($_POST['postMessage'], 'http') == TRUE) {
        $pos = strpos($_POST['postMessage'], 'http');
        $array[0] = substr($_POST['postMessage'], 0, $pos);
        $array[1] = substr($_POST['postMessage'], $pos, strlen($_POST['postMessage']) + 1);
        $string = explode(' ', $array[1]);
        for ($i = 1; $i < count($string); $i++) {
            $array[2] = $array[2] . ' '  . $string[$i];
            }
        if(strstr($string[0],'youtube')==TRUE){
            $video=explode("watch?v=", $string[0]);

            $length=strlen($video[1]);
            $i=0;
            $char=$video[1][$i];
            $idVideo="";
            while ($i<$length AND $char!="&"){
                $i++;
                $idVideo.=$char;
                $char=$video[1][$i];
            }
            $array[1] = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$idVideo.'\' frameborder=\'0\' allowfullscreen></iframe><br />';
        } else if(strstr($string[0],'youtu.be')==TRUE){
            $video = explode("be/",$string[0]);
            $array[1] = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$video[1].'\' frameborder=\'0\' allowfullscreen></iframe><br />';
        } else if(strstr($string[0],'.jpg')==TRUE OR strstr($string[0],'.png')==TRUE OR strstr($string[0],'.gif')==TRUE){
        	$array[1] = '<br /><img src=\"'.$string[0].'\" style=\"max-width: 300px\"><br />';
        } else {
            $array[1] = '<a href=\'' . $string[0] . '\'>' . $string[0] . '</a>';
        }
        $content = htmlspecialchars(utf8_decode(trim($array[0]))) . ' ' . $array[1] . ' ' . htmlspecialchars(utf8_decode(trim($array[2])));
    } else {
        $content = htmlspecialchars(utf8_decode(trim($_POST['postMessage'])));
    }
	$content = str_replace("&lt;3","&hearts;",$content);
$name = $_SESSION['user']->name;

$t='posts';
$v= array($idUser,$idOwner,$content,$_SERVER['REMOTE_ADDR']);
$r= 'idUser, idOwner, content, ip';

$mysql->insert($t,$v,$r); 

$result = $mysql->query("SELECT * FROM posts WHERE idUser = $idUser AND idOwner = $idOwner ORDER BY idPost DESC");
$post = mysql_fetch_object($result,'post');
$idPost = $post->getId();

$content = "<a href=\'room.php?id=$idOwner\'>".$_SESSION['user']->name." ".$_SESSION['user']->surname."</a> ti ha lasciato un messaggio: <span>$content</span>. <a href=\'post.php?id=$idPost\'>Leggi</a>";

$t='notifications';
$v= array($idUser,$content);
$r= 'idUser, content';
$mysql->insert($t,$v,$r);

echo '<div class="postBlock">
<div class="inner">
<div class="textarea">
<div class="post">
<div class="date">
' . $post -> getDate() . '
</div>
<span><a href="room.php?id='.$_SESSION['user']->idUser.'">'.$_SESSION['user']->name ." ".$_SESSION['user']->surname. "</a></span><br /><p> ". utf8_encode(nl2br($post -> getContent())) . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($_SESSION['user'] -> pic == 1)
                            echo '<img src="./photos/' . $_SESSION['user']->idUser . '.jpg">';
                        else
                            echo '<img src="./css/img/profile_photo.png">';
                        echo '</div>
<div class="divFooter">
<a href="post.php?id=' . $post -> getId() . '">Leggi tutto</a>
</div>
</div>';

$mysql->disconnect();
?>
