<?php
//script usato in ajax per commentare i post

//apro la sessione
session_start();

//se l'utente non è loggato lo reindirizzo al login
if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('location: login.php?error=1');

//modifico il content-type per correggere eventuali caratteri speciali
header("Content-type: text/html; charset=ISO-8859-1");

//divido in un array data e ora
$array2 = explode(" ", date("Y-m-d H:i"));
//divido in un array la data
$array = explode("-", $array2[0]);
//correggo i numeri da 1 a 9 cancellando lo 0 davanti (es. 01 diventa 1)
switch($array[2]) {
    case "01" :
        $array[2] = "1";
        break;
    case "02" :
        $array[2] = "2";
        break;
    case "03" :
        $array[2] = "3";
        break;
    case "04" :
        $array[2] = "4";
        break;
    case "05" :
        $array[2] = "5";
        break;
    case "06" :
        $array[2] = "6";
        break;
    case "07" :
        $array[2] = "7";
        break;
    case "08" :
        $array[2] = "8";
        break;
    case "09" :
        $array[2] = "9";
        break;
}
//trasformo i mesi da numeri in stringe (es. 1 diventa Gennaio)
switch($array[1]) {
    case "01" :
        $array[1] = "Gennaio";
        break;
    case "02" :
        $array[1] = "Febbraio";
        break;
    case "03" :
        $array[1] = "Marzo";
        break;
    case "04" :
        $array[1] = "Aprile";
        break;
    case "05" :
        $array[1] = "Maggio";
        break;
    case "06" :
        $array[1] = "Giugno";
        break;
    case "07" :
        $array[1] = "Luglio";
        break;
    case "08" :
        $array[1] = "Agosto";
        break;
    case "09" :
        $array[1] = "Settembre";
        break;
    case "10" :
        $array[1] = "Ottobre";
        break;
    case "11" :
        $array[1] = "Novembre";
        break;
    case "12" :
        $array[1] = "Dicembre";
        break;
}
//creo la stringa con la data in italiano
$itDate = $array[2] . " " . $array[1] . " " . $array[0] . " <span>alle ore</span> " . substr($array2[1], 0, 5);

//includo le classi mysqlclass e user
include "./includes/mysqlclass.class.php";
include "./includes/user.class.php";

//creo l'oggetto user
$user = new user($_SESSION['user']);

//creo l'oggetto mysql e lo connetto
$mysql = new MySqlClass();
$mysql->connect();

//se l'id del post non è numerico o non è stato inserito nessun contenuto nel post chiudo lo script
if(!is_numeric($_POST['idPost']) OR !is_numeric($_POST['idUser']) OR !isset($_POST['content']) OR trim($_POST['content'])==""){
    die('KO');
}

//salvo idPost, idUser e pulisco il contenuto del post
$idPost = $_POST['idPost'];
$idUser = $_POST['idUser'];
$content = htmlspecialchars(utf8_decode(trim($_POST['content'])));
$content = str_replace("&lt;3","&hearts;",$content);

//sistemo le variabili per l'inserimento sul db
$t = "comments";
$v = array($idPost, $idUser, $content, $_SERVER['REMOTE_ADDR']);
$r = "idPost,idUser,content,ip";

//invio delle notifiche

//inserisco il nuovo commento sul db
$mysql->insert($t,$v,$r);

//seleziono il post dal db
$result = $mysql->query("SELECT idUser,idOwner FROM posts WHERE idPost = $idPost");
$line = mysql_fetch_array($result);

//seleziono l'user proprietario del post
$result = $mysql->query("SELECT * FROM users WHERE idUser = ".$line['idUser']);
$row = mysql_fetch_array($result);

//seleziono nome e cognome dell'user proprietario del commento
$result = $mysql->query("SELECT name,surname FROM users WHERE idUser = $idUser");
$line2 = mysql_fetch_array($result);

//se l'id dell'user che commenta è diverso da quello del proprietario
if($idUser!=$line['idUser']){
    //invio la notifica al proprietario del post
    $t = "notifications";
    //se idOwner non è NULL è un messaggio inserito da qualcun altro e la notifica sarà diversa
    if($line['idOwner']!=NULL)
        $v = array($line['idUser'], $line2['name']." ".$line2['surname']." ha commentato il <a href=\'post.php?id=$idPost\'>messaggio</a> nella tua stanza.");
    else
        $v = array($line['idUser'], $line2['name']." ".$line2['surname']." ha commentato il tuo <a href=\'post.php?id=$idPost\'>post</a>.");
    $r = "idUser,content";
    
    //inserisco la notifica sul db
    $mysql->insert($t,$v,$r);
}

//se idOwner è diverso da null il post è un messaggio
//quindi controllo anche se idOwner è diverso dall'id di chi commenta 
if($line['idOwner']!=NULL AND $idUser!=$line['idOwner']){
    //se è diverso mando la notifica
    $t = "notifications";
    $v = array($line['idOwner'], $line2['name']." ".$line2['surname']." ha commentato il tuo <a href=\'post.php?id=$idPost\'>messaggio</a>.");
    $r = "idUser,content";

    //inserisco la notifica sul db
    $mysql->insert($t,$v,$r);
}

//seleziono dal db tutti gli user che hanno già commentato il post
$result = $mysql->query('SELECT * FROM posts_users WHERE idPost = '.$idPost);
//con un while li scorro tutti e mando la notifica uno per uno
while($line3 = mysql_fetch_array($result)){
    //prima di mandare la notifica controllo che gli user non siano proprietari del post o del commento
    if($line3['idUser']!=$idUser AND $line3['idUser']!=$row['idUser'] AND $line3['idUser']!=$line['idOwner']){
        //se sono diversi mando la notifica
        $t = "notifications";
        $r = "idUser,content";
        $v = array($line3['idUser'],'Anche '.$line2['name'].' '.$line2['surname'].' ha commentato il <a href=post.php?id='.$idPost.'>post</a> di '.$row['name'].' '.$row['surname']);
        //salvo la notifica sul db
        $mysql->insert($t,$v,$r);
    }
}

//se l'user che ha commentato non ha mai commentato il post
$result = $mysql->query('SELECT * FROM posts_users WHERE idPost = '.$idPost.' AND idUser = '.$idUser);
if(mysql_fetch_row($result)==0){
    //salvo l'user sul db per mandargli la notifica nel momento in cui qualcun altro commenterà il post
    $t='posts_users';
    $v = array($idUser,$idPost);
    $r = "idUser,idPost";
    //salvo sul db
    $mysql->insert($t,$v,$r);
}

//seleziono il commento dal db per poi darlo in output a javascript
$result = $mysql->query("SELECT idComment FROM comments WHERE idPost = $idPost AND idUser = $idUser");
$comment = mysql_fetch_array($result);

//disconnetto il db
$mysql->disconnect();

//do il commento in output a javascript
echo '<div id="'.$comment['idComment'].'" class="commentBlock"><div class="inner"><div class="textarea"><div class="post"><div class="date">'.$itDate.' - <a href="#" onClick="deleteComment('.$comment['idComment'].')">Cancella</a></div><p><span class="owner"><a href="room.php?id='.$user->getId().'">'.$user->getCompleteName().':</a></span><br />'.stripslashes(nl2br($content)).'</p></div></div></div><div class="sidebar"><img src="';
if($user->getPic()==1) 
    echo "./photos/".$user->getId().".jpg"; 
else 
    echo "./css/img/profile_photo.png";
echo '"></div><div class="divFooter"></div></div>';
?>