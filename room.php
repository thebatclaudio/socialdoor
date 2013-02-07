<?php
	//stanza personale di ogni utente
	//in questo caso un utente non loggato può visualizzare la stanza, ma non può leggere i post
	
	//apro la sessione
    session_start();
    //se non è stato passato nessun id reindirizzo l'utente alla home
    if(!isset($_GET['id']))
        header('location: home.php');
    
    $id=$_GET['id'];//assegno a id l'id passato in get
    
    if(!is_numeric($id)){
    	include "header.php";
		die("<div id='container'>Hai inserito un id non valido.</div>");
    }
    
    //includo le classi mysql, user, post e room
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    include "./includes/post.class.php";
    include "./includes/room.class.php";

	//inizializzo l'oggetto mysql e mi connetto al db
    $mysql = new MySqlClass();
    $mysql->connect();
	//seleziono dal db i dati dell'user e li salvo nell'oggetto owner
    $result = $mysql->query("SELECT * FROM users WHERE idUser = '".$id."'");
    $owner = new user(mysql_fetch_object($result));
	//se l'utente è loggato controllo se il proprietario della stanza gli ha aperto la porta e gli ha dato quindi i permessi di visualizzare i suoi post
    if(isset($_SESSION['loggedin'])){
        //se è loggato inizializzo l'oggetto user
        $user = new user($_SESSION['user']);
		//potrebbe essere stato inserito un id falso nella querystring e potrebbe quindi non esistere nessun user con id corrispondente
		//effettuo allora un controllo sull'id dell'owner perima di controllare se la porta è stata aperta
        if($owner->getId())
            $opened = $user->canIsee($owner->getId());
    }   
	
	//controllo il nome del proprietario della stanza per essere sicuro che l'id passato in querystring sia reale
	//se il nome è vuoto allora l'id è falso
    if($owner->getName()==""){
    	//allora owner sarà il Sig. Nessuno nato lo 0 Gennaio dell'anno 0 e che vive nel Mondo dei sogni
        $owner->setName("Nessuno");
        $flag=1; //il flag serve a indicare che l'user è il Sig. Nessuno e verrà utilizzato dopo
        $owner->setBirthday("0 Gennaio dell'anno 0");
        $owner->setCity("Mondo dei sogni");
        $opened = 1;
        $room = new room(0); //se passo 0 al costruttore di room la stanza verrà generata con sfondo nero e scritte blu (predefinito)
    } else {
    	//se il nome non è vuoto allora seleziono i dati della stanza dal db e li salvo nell'oggetto room
        $result = $mysql->query("SELECT * FROM rooms WHERE idUser = ".$id);
        $room = mysql_fetch_object($result,'room');
    }  
	//preparo i metatag title, description e keywords
    $title = "Stanza di ".$owner->getName()." - SocialDoor";
    $description = "Stanza di ".$owner->getCompleteName()." su SocialDoor. Iscriviti o accedi per visualizzarla";
    $keywords = $owner->getCompleteName().",socialdoor,social door,stanza di ".$owner->getCompleteName().",".$owner->getCity().",pagina personale";
    //includo l'header della stanza
    include "header.php";
?>
<div id="container" style="overflow: scroll">
    <div id="header">
        <div id="right">
            <form action="search.php" method="post" style="margin-top: 10px;">
                <input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
            </form>
        </div>
        <div id="left">
            <h3>Stanza di</h3>
            <h1><?php echo $owner -> getCompleteName();?></h1>
        </div>
        <div id="divFooter"></div>
    </div>
    <div id="userInfo">
        <div id="userInfoRight">
            <ul>
                <li>
                    Nome: <?php echo $owner -> getCompleteName();?>
                </li>
                <li>
                    Nat<?php
                    //controllo il sesso dell'owner per far stampare natO o natA
                    if ($owner -> getSex() == 1)
                        echo "o";
                    else
                        echo "a";
                    ?>
                    il: <?php echo $owner -> getBirthday();?>
                </li>
                <li>
                    Vive a: <?php echo "<a href='http://maps.google.it/maps?hl=it&q=" . $owner -> getCity() . "' target='_blank'>" . $owner -> getCity() . "</a>";?>
                </li>
                <?php
               		//nel caso dei dati opzionali stampo solo i dati diversi da NULL
                    if ($owner -> getRelationship() != NULL)
                        echo '<li>Situazione sentimentale: ' . $owner -> getRelationship() . '</li>';           
                    if ($owner -> getWork() != NULL)
                        echo '<li>Lavoro: ' . $owner -> getWork() . '</li>';
                    if ($owner -> getWebsite() != 'http://')
                        echo '<li>Sito web: <a href="' . $owner -> getWebsite() . '" target="_blank">' . $owner -> getWebsite() . '</a></li>';
                ?>
            </ul>
            <div id="buttons">
<?php
				//i pulsanti vengono stampati solo se l'utente è loggato
                if(isset($_SESSION['loggedin'])){
                	//controllo quindi se l'id dell'user è uguale a quello dell'owner
                    if ($owner -> getId() == $user -> getId()) {
                    	//se gli id sono uguali allora stampo il pulsante "Modifica la tua stanza"
                        echo '<a href="editRoom.php" title="Modifica la tua stanza"><input type="button" class="doorBell" value="Modifica la tua stanza" style="width: 280px" /></a>';
                        $opened = 1;
                    } else if ($opened == 0)
                        //se opened è uguale a 0 allora l'user non ha ancora bussato alla porta dell'owner
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="Suona il campanello" style="width: 280px" onClick="openPopupRingTheBell()" />';
                    else if($opened == 2)
						//se opened è uguale a 2 allora l'user ha già bussato alla porta dell'owner, ma l'owner non ha ancora aperto
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="Hai gi&agrave; suonato il campanello" style="width: 280px" />';                        
                    else
						//altrimenti (opened sarà uguale a 1) l'user ha già bussato alla porta dell'owner e gli è stata aperta
                        echo '<input id="ringTheBellButton" type="button" class="doorBell" value="' . $owner -> getName() . ' ti ha aperto la porta" style="width: 280px" /><input type="button" class="doorBell" value="Lascia un messaggio" onclick="openPopupSendMessage()" style="width: 280px" />';
                    
					//controllo l'id di owner per essere sicuro che non sia il Sig. Nessuno
                    if($owner->getId()){
                    	//se non è il Sig. Nessuno controllo se l'owner ha bussato alla porta dell'user e se questa non è ancora stata aperta
                        if($user->heRingsMyBell( $owner->getId() ) == 1 )
							//se ancora non è stata aperta stampo il pulsante "Aprigli la porta"
                            echo '<a href="openTheDoor.php?id='.$owner->getId().'"><input type="button" class="doorBell" value="Aprigli la porta" style="width: 280px" /></a>';
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
        <h2>Ultimi post di <?php echo $owner -> getName();?></h2>
        <div id="div"></div>
        <div id="lastpostsContent">
            <?php
            //se il flag è uguale a 0 allora l'id passato in querystring è falso e visualizzo un messaggio di errore
            if ($flag == 1) {
                echo "<p align='center'>L'ID $id corrisponde a Nessuno... ";
                //controllo il sesso dell'user per stampare sicurO o sicurA
                if ($user -> getSex() == 1)
                    echo "Sei sicuro ";
                else
                    echo "Sei sicura ";
                echo "di aver inserito l'ID esatto?</p>";
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
<a href="post.php?id=' . $post -> getId() . '">Leggi tutto</a>
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
<a href="post.php?id=' . $post -> getId() . '">Leggi tutto</a>
</div>
</div>';
                    }
                }
            } else {
                echo "<center><h3>Non puoi visualizzare i post di " . $owner -> getName() . "</h3></center>";
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
