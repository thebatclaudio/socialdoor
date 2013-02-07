<?php
	//room
	//user not logged can see room, but can't see posts
	
    session_start();
    if(!isset($_GET['id']))
        header('location: home.php');
    
    $id=$_GET['id'];
    
    if(!is_numeric($id)){
    	include "header.php";
		die("<div id='container'>ID not valid.</div>");
    }
    
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    include "./includes/post.class.php";
    include "./includes/room.class.php";

    $mysql = new MySqlClass();
    $mysql->connect();
    $result = $mysql->query("SELECT * FROM users WHERE idUser = '".$id."'");
    $owner = new user(mysql_fetch_object($result));
    if(isset($_SESSION['loggedin'])){
        $user = new user($_SESSION['user']);
        
        if($owner->getId())
        	//control if room's owner has opened door to user loggedin
            $opened = $user->canIsee($owner->getId());
    }   
	
    if($owner->getName()==""){
    	//if name is = "", user is nobody
    	$flag=1;
        $owner->setName("Chuck Norris");
        $owner->setBirthday("10/03/1940");
        $owner->setCity("Ryan (Oklahoma)");
        $opened = 1;
        $room = new room(0); //if parameter is 0, room will be created with standard template
    } else {
        $result = $mysql->query("SELECT * FROM rooms WHERE idUser = ".$id);
        $room = mysql_fetch_object($result,'room');
    }  
	//prepare metatags
    $title = $owner->getName()."'s room - SocialDoor";
    $description = $owner->getCompleteName()."'s room on SocialDoor. Sign up or login to view it.";
    $keywords = $owner->getCompleteName().",socialdoor,social door,".$owner->getCompleteName()."'s room,".$owner->getCity().",personal page";
    
    include "header.php";
?>
<div id="container" style="overflow: scroll">
    <div id="header">
        <div id="right">
            <form action="search.php" method="post" style="margin-top: 10px;">
                <input type="text" id="search" name="search" placeholder="Search..." autocomplete="off">
            </form>
        </div>
        <div id="left">
            <h1><?php echo $owner -> getCompleteName();?>'s</h1>
            <h3>Room</h3>
        </div>
        <div id="divFooter"></div>
    </div>
    <div id="userInfo">
        <div id="userInfoRight">
            <ul>
                <li>
                    Name: <?php echo $owner -> getCompleteName();?>
                </li>
                <li>
                   Born on: <?php echo $owner -> getBirthday();?>
                </li>
                <li>
                    Live in: <?php echo "<a href='http://maps.google.it/maps?hl=it&q=" . $owner -> getCity() . "' target='_blank'>" . $owner -> getCity() . "</a>";?>
                </li>
                <?php
               		//nel caso dei dati opzionali stampo solo i dati diversi da NULL
                    if ($owner -> getRelationship() != NULL)
                        echo '<li>Relationship : ' . $owner -> getRelationship() . '</li>';           
                    if ($owner -> getWork() != NULL)
                        echo '<li>Work : ' . $owner -> getWork() . '</li>';
                    if ($owner -> getWebsite() != 'http://')
                        echo '<li>Website : <a href="' . $owner -> getWebsite() . '" target="_blank">' . $owner -> getWebsite() . '</a></li>';
                ?>
            </ul>
            <div id="buttons">
<?php
				//i pulsanti vengono stampati solo se l'utente è loggato
                if(isset($_SESSION['loggedin'])){
                	//controllo quindi se l'id dell'user è uguale a quello dell'owner
                    if ($owner -> getId() == $user -> getId()) {
                    	//se gli id sono uguali allora stampo il pulsante "Modifica la tua stanza"
                        echo '<a href="editRoom.php" title="Edit your room"><input type="button" class="doorBell" value="Edit your room" style="width: 280px" /></a>';
                        $opened = 1;
                    } else if ($opened == 0)
                        //se opened è uguale a 0 allora l'user non ha ancora bussato alla porta dell'owner
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="Ring the bell" style="width: 280px" onClick="openPopupRingTheBell()" />';
                    else if($opened == 2)
						//se opened è uguale a 2 allora l'user ha già bussato alla porta dell'owner, ma l'owner non ha ancora aperto
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="You have just ringed the bell" style="width: 280px" />';                        
                    else
						//altrimenti (opened sarà uguale a 1) l'user ha già bussato alla porta dell'owner e gli è stata aperta
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="' . $owner -> getName() . ' has opened the door to you" style="width: 280px" /><input type="button" class="doorBell" value="Leave a message" onclick="openPopupSendMessage()" style="width: 280px" />';
                    
					//controllo l'id di owner per essere sicuro che non sia il Sig. Nessuno
                    if($owner->getId()){
                    	//se non è il Sig. Nessuno controllo se l'owner ha bussato alla porta dell'user e se questa non è ancora stata aperta
                        if($user->heRingsMyBell( $owner->getId() ) == 1 )
							//se ancora non è stata aperta stampo il pulsante "Aprigli la porta"
                            echo '<a href="openTheDoor.php?id='.$owner->getId().'"><input type="button" class="doorBell" value="Open the door" style="width: 280px" /></a>';
                    }
                }
                ?>
            </div>
        </div>
        <div id="userInfoLeft">
            <?php
           	//se l'immagine è già stata cambiata la stampo, altrimenti stampo il pupino predefinito
            if ($owner -> getPic() == 1)
                echo '<img src="./photos/' . $owner -> getId() . '.jpg?imm='.rand(0,99999).'" style="border: 1px solid #999">';
            else
                echo '<img src="./css/img/profile_photo.png" style="border: 1px solid #999">';
            ?>
        </div>
        <div class="divFooter"></div>
    </div>
    <div id="lastposts">
        <h2>Last <?php echo $owner -> getName();?>'s posts</h2>
        <div id="div"></div>
        <div id="lastpostsContent">
            <?php
            //se il flag è uguale a 0 allora l'id passato in querystring è falso e visualizzo un messaggio di errore
            if ($flag == 1) {
                echo "<p align='center'>This ID doesn't exist in our database...";
     
                echo "Are you sure you have entered the correct id?</p>";
            }
			//se opened è uguale a 1 l'user può visualizzare i post
            if ($opened == 1) {
            	//seleziono i post dal db
                $result = $mysql -> query("SELECT * FROM posts WHERE idUser = " . $owner -> getId() . " ORDER BY idPost DESC LIMIT 0,6");
                while ($post = mysql_fetch_object($result, 'post')) {
                    //se getIdOwner() da come valore di ritorno NULL è un semplice post, altrimenti è un messaggio lasciato da qualcun altro   
                    if ($post -> getIdOwner()!=NULL) {
                    	//se idOwner è diverso da NULL allora seleziono dal db i dati dell'user che ha lasciato il messaggio e li salvo nell'oggetto postOwner
                        $postOwnerResult = $mysql -> query("SELECT * from users WHERE idUser = ".$post->getIdOwner());
                        $postOwner = new user(mysql_fetch_object($postOwnerResult));    
                        //stampo il post
                        echo '<div class="postBlock">
<div class="inner">
<div class="textarea">
<div class="post">
<div class="date">
' . $post -> getDate() . '
</div>
<span><a href="room.php?id='.$postOwner->getId().'">'.$postOwner -> getCompleteName() . "</a></span><br /><p> ". $post -> getContent() . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($postOwner -> getPic() == 1)
                            echo '<img src="./photos/' . $postOwner -> getId() . '.jpg?imm='.rand(0,99999).'">';
                        else
                            echo '<img src="./css/img/profile_photo.png">';
                        echo '</div>
<div class="divFooter">
<a href="post.php?id=' . $post -> getId() . '">Read more...</a>
</div>
</div>';
                    } else {
                        echo '<div class="postBlock">
<div class="inner">
<div class="textarea">
<div class="post">
<div class="date">
' . $post -> getDate() . '
</div>
<span><a href="room.php?id='.$owner->getId().'">'.$owner -> getCompleteName() . '</a></span><br /><p>
' . $post -> getContent() . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($owner -> getPic() == 1)
                            echo '<img src="./photos/' . $owner -> getId() . '.jpg?imm='.rand(0,99999).'">';
                        else
                            echo '<img src="./css/img/profile_photo.png">';
                        echo '</div>
<div class="divFooter">
<a href="post.php?id=' . $post -> getId() . '">Read more</a>
</div>
</div>';
                    }
                }
            } else {
                echo "<center><h3>You can't view " . $owner -> getName() . "'s posts</h3></center>";
            }
            ?>
        </div>
    </div>
                
                <?php
                //se opened è uguale a 1 stampo il pulsante "Altri post" e la corrispettiva funzione AJAX
                if($opened==1){
                    echo '<div id="morePost"><a href="#morePost" onClick="viewMore(6)">Altri post...</a></div>
                        <script type="text/javascript">
            function viewMore(n){
                var message = document.getElementById("morePost");
                message.innerHTML = "Attendere...";
                var oXHR = new XMLHttpRequest();
                var text = document.getElementById("lastpostsContent").innerHTML;
                oXHR.open("post", "moreRoomPost.php", true);
                oXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                oXHR.onreadystatechange = function() {
                    if(oXHR.readyState == 4) {
                        if(oXHR.responseText == \'nomore\'){
                            message.innerHTML = \'Non ci sono altri post da visualizzare\';
                        } else if(oXHR.responseText != \'KO\') {
                            text += oXHR.responseText;
                            document.getElementById("lastpostsContent").innerHTML = text;
                            message.innerHTML = \'<a href="#morePost" onClick="viewMore(\'+(n+5)+\')">Altri post...</a>\';
                        } else {
                        message.innerHTML = "Si &egrave; verificato un errore. Riprovare";
                        }
                    }
                }
            var params = "idUser='.$owner->getId().'&n="+n;
            oXHR.send(params);
            }
        </script>';
                }
      ?>
</div>
<div id="ringTheBell">
    <p class="closePopup">
        <a href="#" onClick="closePopupRingTheBell()">Chiudi X</a>
    </p>
    <h3>Suona il campanello di <?php echo $owner -> getCompleteName();?>!</h3>
    <form>
        Scrivi qui il tuo messaggio per <?php echo $owner -> getCompleteName();?>!
        <br />
        <br />
        <textarea name="message" id="message" style="width: 350px;" maxlength="240"></textarea>
<br />        <input class="submit" type="button" onClick='ringTheBell();' value="Suona!" />
    </form>
    <div id="warning">
        <h3>Attenzione!</h3>Suonando il campanello chiederai a <?php echo $owner -> getCompleteName();?>
        di condividere con te le sue informazioni personali e i suoi pensieri. Automaticamente, tu
        condividerai le tue.
        <br />
        Sei sicuro di ci&ograve; che stai facendo?
    </div>
</div>
<?php if($opened==1) {?>
<div id="sendMessage">
    <p class="closePopup">
        <a href="#" onClick="closePopupSendMessage()">Chiudi X</a>
    </p>
    <h3>Lascia un messaggio a <?php echo $owner -> getCompleteName();?>!</h3>
    <form>
        Scrivi qui il tuo messaggio per <?php echo $owner -> getCompleteName();?>!
        <br />
        <br />
        <textarea name="message" id="postMessage" style="width: 350px;" maxlength="240"></textarea>
<br />        <input class="submit" type="button" onClick='sendMessage();' value="Invia!" />
    </form>
    <div id="sendMessageWarning">
        
    </div>
</div><?php } ?>

<div id="dark"></div>
</body>
</html> 
