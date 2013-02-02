<?php
	session_start();//apro la sessione
    ob_start();	
	if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
		header('Location: login.php?error=1');//se l'utente non è loggato lo reindirizzo al login
	
	include('./includes/mysqlclass.class.php');
	include('./includes/user.class.php');
	
	$user = new user($_SESSION['user']);
	include('header.php');
	
?>

<div id="container">
<?php

//se il post è stato inserito e non è vuoto
if (isset($_POST['post']) AND trim($_POST['post'])!="") {
    //se è presente http nel post	
    if (strstr($_POST['post'], 'http') == TRUE) {
        //mi prendo la posizione di http nella stringa
        $pos = strpos($_POST['post'], 'http');
        $array[0] = substr($_POST['post'], 0, $pos); //array[0] è il testo prima del link
        $array[1] = substr($_POST['post'], $pos, strlen($_POST['post']) + 1); //array[1] è il testo dall'inizio del link in poi
        $string = explode(' ', $array[1]);//divido array[1] nell'array string dove è presente string[0] con il link e il resto degli elementi con le varie parole
        //allora faccio un for partendo da 1 per collegare di nuovo tutte le parole dopo il link
        for ($i = 1; $i < count($string); $i++) {
            $array[2] = $array[2] . ' '  . $string[$i]; //il testo dopo il link viene salvato in array[2]
            }
		//se in string[0] è presente la parola youtube allora è un link di youtube
        if(strstr($string[0],'youtube')==TRUE){
            $video=explode("watch?v=", $string[0]); //divido per watch?v= per prendermi l'id del video

            $length=strlen($video[1]); //prendo la lunghezza della stringa dopo watch?v= per fixare in caso di altre variabili dopo l'id del video
            $i=0;
            $char=$video[1][$i]; //char è il primo carattere del video
            $idVideo=""; //inizializzo idVideo
            while ($i<$length AND $char!="&"){
            	//con un while scorro tutti i caratteri fino a quando il carattere diventa & e mi salvo in idVideo l'id del video
                $i++;
                $idVideo.=$char;
                $char=$video[1][$i];
            }
			//salvo in array[1] il codice html per includere il video
            $array[1] = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$idVideo.'\' frameborder=\'0\' allowfullscreen></iframe><br />';
        } else if(strstr($string[0],'youtu.be')==TRUE){
        	//se nel link è presente youtu.be allora è presente lo shortlink
            $video = explode("be/",$string[0]); //allora divido per be/ per prendermi l'id e salvo in array[1] l'html per includere il video
            $array[1] = '<br /><iframe width=\'350\' height=\'208\' src=\'http://www.youtube.com/embed/'.$video[1].'\' frameborder=\'0\' allowfullscreen></iframe><br />';
        } else if(strstr($string[0],'.jpg')==TRUE OR strstr($string[0],'.png')==TRUE OR strstr($string[0],'.gif')==TRUE OR strstr($string[0],'.JPG')==TRUE OR strstr($string[0],'.PNG')==TRUE OR strstr($string[0],'.GIF')==TRUE OR strstr($string[0],'.jpeg')==TRUE OR strstr($string[0],'.JPEG')==TRUE){
        	//se è presente .jpg, .png, .gif allora è un'immagine
        	$array[1] = '<br /><img src=\"'.$string[0].'\" style=\"max-width: 300px\"><br />';
        } else {
        	//altrimenti è un semplice link
        	//estraggo il titolo
			$sorgente_file_remoto = implode("", file($string[0]));

			//utilizzo eregi() perchè il tag potrebbe essere <title> o <TITLE>
			if(eregi("<title>(.+)</title>", $sorgente_file_remoto, $regs)){
				$array[1] = '<a href=\'' . $string[0] . '\'>' . $regs[1] . '</a>';
			} else {
	            $array[1] = '<a href=\'' . $string[0] . '\'>' . $string[0] . '</a>';
			}
        }
		//salvo il post content codificando in html i vari caratteri speciali
        $postContent = htmlentities(trim($array[0])) . ' ' . $array[1] . ' ' . htmlentities(trim($array[2]));
    } else {
    	//salvo il post codificando in html i vari caratteri speciali
        $postContent = htmlentities(trim($_POST['post']));
    }
} else {
	die("Si &egrave; verificato un errore, riprovare.");
}

$mysql = new MySqlClass();
$mysql -> connect();

$postContent = str_replace("&lt;3","&hearts;",$postContent);

$t = "posts";
$v = array($user -> getId(), $postContent, $_SERVER['REMOTE_ADDR']);
$r = "idUser,content,ip";
$mysql -> insert($t, $v, $r);//salvo il post
$result = $mysql -> query("SELECT * FROM posts WHERE idUser = '" . $user -> getId() . "' ORDER BY idPost DESC");//carico il post per prendermi l'id

$post = mysql_fetch_object($result);

echo "Post inserito con successo!<br /> <a href='post.php?id=".$post->idPost."'>Visualizza il post</a>";

header('location: post.php?id=' . $post -> idPost);
ob_end_flush(); 
?>
</div>