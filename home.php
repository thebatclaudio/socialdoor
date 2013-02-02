<?php
session_start();
include ('./includes/user.class.php');
include ('./includes/room.class.php');
include ('./includes/mysqlclass.class.php');
if(!isset($_SESSION['loggedin'])){
    header('location: login.php?error=1');
}
$mysql = new MySqlClass();
$mysql->connect();
$user = new user($_SESSION['user']);
$result=$mysql->query("SELECT * FROM rooms WHERE idUser = ".$user->getId());
$room = mysql_fetch_object($result,'room');

function data_it($date) {
        $array2 = explode(" ",$date);
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
        $itDate = $array[2] . " " . $array[1] . " " . $array[0]." <span>alle ore</span> ". substr($array2[1],0,5);
        return $itDate;
    }

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
			<div id="newpost">
				<?php
				if ($_SESSION['loggedin']) {
					echo '<h2>Ciao ' . $user -> getName() . '! Cos\'hai da dire oggi?</h2>
<div class="inner">
<div class="textarea">
<form action="newpost.php" method="post">
<textarea id="post" name="post" maxlength="560"></textarea>
            <script type="text/javascript">
                $("#post").focus(function() {
                    $("#tooltip").fadeIn(\'slow\');
                }).blur(function(){
                    $("#tooltip").fadeOut(\'slow\');
                });
            </script>
<input class="submit" type="submit" id="publish" value="Pubblica">
<div id="tooltip">
<strong style="color: #55F">Consiglio:</strong><br /><br />
Puoi condividere <span>link</span>, <span>immagini</span> o <span>video</span> caricati su Youtube semplicemente copiando e incollando l\'<span>URL</span>!</div>
</form>
</div>
</div>
<div class="sidebar">';
					echo '<a href="room.php?id=' . $user -> getId() . '" title="' . $user -> getCompleteName() . '">';
					if ($user -> getPic() == 0)
						echo '<img src="./css/img/profile_photo.png">';
					else
						echo '<img src="./photos/' . $user -> getId() . '.jpg?imm='.rand(0,99999).'">';
					echo '</a></div>';
				} else
					echo '<h2>Devi aver effettuato l\'accesso a SocialDoor per visualizzare questa pagina</h2>';
				?>
				<div class="divFooter"></div>
			</div>
			<div id="lastposts">
				<h2>Ultimi post dei tuoi amici</h2>
				<div id="div"></div>
				<div id="lastpostsContent">
					
					<?php 
                       
                       $result = $mysql->query("SELECT idDoor, idOwner, name, surname, pic, idPost, date, content FROM posts,openedDoors,users WHERE openedDoors.idDoor = posts.idUser AND openedDoors.idDoor = users.idUser AND openedDoors.idUser = ".$user->getId()." AND accepted = 1 ORDER BY idPost DESC LIMIT 0,10");
                       
                       while($homePost = mysql_fetch_array($result)){
                       	if($homePost['idOwner']==NULL){
                        echo '<div class="postBlock">
                        <div class="inner">
                            <div class="textarea">
                                <div class="post">
                                    <div class="date">
                                        '.data_it($homePost['date']).'
                                    </div>
                                    <p>
                                        <span class="owner"><a href="room.php?id='.$homePost['idDoor'].'">'.$homePost['name'].' '.$homePost['surname'].'</a></span> scrive:<br />'.nl2br($homePost['content']).'                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar">
                        <a href="room.php?id='.$homePost['idDoor'].'">';
                            if($homePost['pic']==0)
                                echo '<img src="./css/img/profile_photo.png">';
                            else 
                                echo '<img src="./photos/'.$homePost['idDoor'].'.jpg?imm='.rand(0,99999).'">';
                        echo '</a></div>
                        <div class="divFooter">
                            <a href="post.php?id='.$homePost['idPost'].'">Commenta</a>
                        </div>
                    </div>';
                    } else {
                    	$result2 = $mysql->query("SELECT name, surname, pic FROM users WHERE idUser = ".$homePost['idOwner']);
                        $owner = mysql_fetch_array($result2);
                        echo '<div class="postBlock">
                        <div class="inner">
                            <div class="textarea">
                                <div class="post">
                                    <div class="date">
                                        '.data_it($homePost['date']).'
                                    </div>
                                    <p>
                                        <span class="owner"><a href="room.php?id='.$homePost['idOwner'].'">'.$owner['name'].' '.$owner['surname'].'</a></span> > <span class="owner"><a href="room.php?id='.$homePost['idDoor'].'">'.$homePost['name'].' '.$homePost['surname'].'</a></span>:<br />'.nl2br($homePost['content']).'                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar">
                        <a href="room.php?id='.$homePost['idDoor'].'">';
                            if($owner['pic']==0)
                                echo '<img src="./css/img/profile_photo.png">';
                            else 
                                echo '<img src="./photos/'.$homePost['idOwner'].'.jpg?imm='.rand(0,99999).'">';
                        echo '</a></div>
                        <div class="divFooter">
                            <a href="post.php?id='.$homePost['idPost'].'">Commenta</a>
                        </div>
                    </div>';
                    }
                       }
					?>
				</div>
				<div id="morePost"><a href="#morePost" onClick="viewMore(10)">Altri post...</a></div>
				        <script type="text/javascript">
            function viewMore(n){
                var message = document.getElementById("morePost");
                message.innerHTML = "Attendere...";
                var oXHR = new XMLHttpRequest();
                var text = document.getElementById("lastpostsContent").innerHTML;
                oXHR.open("post", "morePost.php", true);
                oXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                oXHR.onreadystatechange = function() {
                    if(oXHR.readyState == 4) {
                        if(oXHR.responseText == 'nomore'){
                            message.innerHTML = 'Non ci sono altri post da visualizzare';
                        } else if(oXHR.responseText != 'KO') {
                            text += oXHR.responseText;
                            document.getElementById("lastpostsContent").innerHTML = text;
                            message.innerHTML = '<a href="#morePost" onClick="viewMore('+(n+10)+')">Altri post...</a>';
                        } else {
                        message.innerHTML = "Si &egrave; verificato un errore. Riprovare";
                        }
                    }
                }
            var params = "idUser=<?php echo $user->getId(); ?>&n="+n;
            oXHR.send(params);
            }
        </script>
			</div>
		</div>
	</body>
</html>