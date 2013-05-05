<?php
	//apro la sessione
	session_start();
	
	//controllo se la variabile di sessione loggedin è già settata
	if(isset($_SESSION['loggedin']) AND $_SESSION['loggedin']==1)
		header("Location: home.php");//se è già settata reindirizzo l'utente alla home
	
	//includo le classi mysqlclass e user	
	include "./includes/mysqlclass.class.php";
	include "./includes/user.class.php";
	
	//controllo se i dati sono stati inseriti
	if(!isset($_POST['name']) OR $_POST['name']==""){
		$name = -1;
	} else {
		$name=trim(filter_var($_POST['name'],FILTER_SANITIZE_STRING));
		//se il nome è composto da più parole (Francesco Paolo) lo divido in un array
		$array = explode(" ",$name);
		$name="";
		//con un foreach pulisco il nome, mettendo la prima lettera maiuscola e il resto minuscole
		foreach($array as $val){	
			$name=$name.ucfirst(strtolower($val))." ";
		}
		$name=trim($name);
	}
	
	if(!isset($_POST['surname']) OR $_POST['surname']==""){
		$surname = -1;
	} else {
		$surname=trim(filter_var($_POST['surname'],FILTER_SANITIZE_STRING));
		$array = explode(" ",$surname);
		$surname="";
		foreach($array as $val){	
			$surname=$surname.ucfirst(strtolower($val))." ";
		}
		$surname=trim($surname);
	}
	
	if(!isset($_POST['email']) OR $_POST['email']==""){
		$email = -1;
	} else if(strpos($_POST['email'], '@')==FALSE OR strpos($_POST['email'], '.')==FALSE){
		$email = -1;
	} else {
		$email=trim(filter_var($_POST['email'],FILTER_SANITIZE_STRING));
	}
	
	if(!isset($_POST['password']) OR $_POST['password']==""){
		$password = -1;
	} else {
		$password=trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
	}
	
	if(!isset($_POST['password2']) OR $_POST['password2']==""){
		$password2 = -1;
	} else {
		$password2=trim(filter_var($_POST['password2'], FILTER_SANITIZE_STRING));
		if($password!=$password2){
			$password2=-1;
		}
	}
	
	if(!isset($_POST['city']) OR $_POST['city']==""){
		$city = -1;
	} else {
		$city = trim(filter_var($_POST['city'],FILTER_SANITIZE_STRING));
	}
	
	if(!isset($_POST['sex']) OR $_POST['sex']==0){
		$sex = -1;
	} else {
		$sex = $_POST['sex'];
	}
	
	if(!isset($_POST['dd']) OR $_POST['dd']==-1){
		$dd = -1;
	} else {
		$dd = $_POST['dd'];
	}
	
	if(!isset($_POST['mm']) OR $_POST['mm']==-1){
		$mm = -1;
	} else {
		$mm = $_POST['mm'];
	}
	
	if(!isset($_POST['yy']) OR $_POST['yy']==-1){
		$yy = -1;
	} else {
		$yy = $_POST['yy'];
	}
	
	if($name!=-1 AND $surname!=-1 AND $email!=-1 AND $password!=-1 AND $password2!=-1 AND $city!=-1 AND $sex!=-1 AND $dd!=-1 AND $mm!=-1 AND $yy!=-1){
		//cripto la password
		$hash = hash("sha256",$email.$password);    
		//mi connetto a mysql
		$mysql = new MySqlClass();
		$mysql->connect();
		//controllo se eiste già un user con l'indirizzo email inserito
		$result = $mysql->query("SELECT * FROM users WHERE email='$email'");
        $line = mysql_fetch_array($result);
        if(isset($line['idUser'])){
            $user=new user();
            include("header.php");
            die("<br /><br /><h3>Si &egrave; gi&agrave; registrato qualcuno con l'indirizzo <u>$email</strong></u>");
        }
		//se non esiste procedo con la registrazione sul database
		$t = "users";
    	$v = array ($name,$surname,$email,$hash,$city,$sex,$yy."-".$mm."-".$dd,$_SERVER['REMOTE_ADDR']);
    	$r =  "name,surname,email,password,city,sex,birthday,ip";
		$mysql->insert($t,$v,$r);
		
		//effettuo l'accesso
		$query = "SELECT idUser,name,surname,birthday,sex,city,email,pic,website,work,relationship FROM users WHERE email='$email'";
		$auth=$mysql->query($query);
		$_SESSION['user']=mysql_fetch_object($auth);
        $_SESSION['loggedin']=1;
        
		//mando la prima notifica
        $t = "notifications";
        $v = array ($_SESSION['user']->idUser,"Benvenuto su SocialDoor, ".$_SESSION['user']->name."! <a href='readme.php'>Leggi l'informativa sulla privacy</a>");
        $r =  "idUser,Content";
        $mysql->insert($t,$v,$r);
        
		//creo la stanza
        $t = "rooms";
        $v = array ($_SESSION['user']->idUser,0,0,0,0);
        $r = "idUser,bgColor,textColor1,textColor2,bgPost";
        $mysql->insert($t,$v,$r);
        
		//apro la porta all'user stesso
        $t = "openedDoors";
        $v = array ($_SESSION['user']->idUser,$_SESSION['user']->idUser,'himself',1);
        $r = "idUser,idDoor,message,accepted";
        $mysql->insert($t,$v,$r);
        
        //disconnetto il database
		$mysql->disconnect();
        $user = new user($_SESSION['user']);
        
		//mando l'email di benvenuto
        $header = "To: ".$user->getCompleteName()." <".$user->getEmail().">\n";
        $header .= "From: SocialDoor <noreply@socialdoor.it>\n";
        $oggetto = "Benvenuto su SocialDoor, ".$user->getName();
        $messaggio = "Benvenuto su SocialDoor, ".$user->getName().", \n";
        $messaggio .= "siamo contenti di averti tra noi. SocialDoor è un progetto in via di sviluppo e per crescere abbiamo bisogno di utenti.\n";
        $messaggio .= "Essendo in via di sviluppo, potrai trovare alcuni errori e ci scusiamo per questo. Se vuoi aiutarci puoi mandare un'email a info@socialdoor.it quando trovi un errore, in modo da poter migliorare il nostro lavoro.\n";
        $messaggio .= "Se puoi e se vuoi invita i tuoi amici dandogli semplicemente il link http://www.socialdoor.it\n\n";
        $messaggio .= "Buona permanenza su SocialDoor!\n\n";
        $messaggio .= "Claudio La Barbera - CEO/Founder di SocialDoor\n";
        $messaggio .= "http://www.socialdoor.it - info@socialdoor.it";
        
        mail($email,$oggetto,$messaggio,$header);
        
		//mando l'email a Mr. Claudio
        $header = "To: Claudio La Barbera <youremail@youremail.it>\n";
        $header .= "From: SocialDoor <noreply@socialdoor.it>\n";
        $oggetto = "Nuovo iscritto: ".$user->getCompleteName();
        $messaggio = "Nuovo iscritto: ".$user->getCompleteName();
        
        mail("info@labarberawebdesign.it",$oggetto,$messaggio,$header); 
        
		//stampo la pagina per far inserire la foto all'utente
        include "header.php";
        echo '<div id="signupContainer">
                    <h2>';
        if($user->getSex()==1)
            echo "Benvenuto ";
        else 
            echo "Benvenuta ";
        echo 'su SocialDoor, '.$user->getName().'!</h2>
                         <div id="div"></div>
                         <br />
                         <p>Condividi SocialDoor su Facebook per farlo conoscere anche ai tuoi amici!</p>
                         					<a name="fb_share" type="button" 
   share_url="http://www.socialdoor.it">Condividi su Facebook!</a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
        type="text/javascript">
</script>
<div id="div"></div>
                         <p>Non hai ancora caricato una foto per farti riconoscere. Cosa aspetti a farlo?</p>
                         <form action="uploadPhoto.php" method="post" enctype="multipart/form-data">
                            <img src="./css/img/profile_photo.png" /><br />
                            <input type="file" name="upfile" id="upfile" />
                            <br />
                            <input type="submit" class="submitPhoto" value="Carica foto" /><br />
                            <p>Solo JPEG, GIF e PNG</p>
                         </form>
               </div>';
	} else {
	    ?>
	    <?php
		//apro la sessione
		session_start();

		//se è già settata la variabile loggedin ed è uguale a 1 reindirizzo l'utente alla pagina home.php
		if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == 1) {
			header("Location: home.php");
		}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Registrati su SocialDoor</title>
        <meta content="Registrati su SocialDoor e inizia a personalizzare la tua stanza!" name="description" />
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
        <link href="./css/style.css?r=2" rel="stylesheet" type="text/css" media="screen" />
        <script src="./js/jquery.min.js"></script>
        <script src="./js/jquery.validate.js"></script>
        <script language="JavaScript">
									$(document).ready(function() {
				$("#signup_form").validate({
					rules : {
						'name' : {
							required: true
						},
						'surname' : {
							required: true
						},
						'email' : {
							required: true,
							email: true
						},
						'city' : {
							required: true
						},
						'dd' : {
							required: true
						},				
						'password' : {
							required : true,
							minlength : 8
						},
						'password2' : {
							required: true,
							minlength: 8,
							equalTo: '#password'
						}
					},
					messages : {
						'name' : {
							required: "Non hai un nome!?"
						},
						'surname' : {
							required: "Non hai un cognome!?"
						},
						'email' : {
							required: "Non hai un indirizzo email!?",
							email: "E questo ti sembra un indirizzo email!?"
						},
						'city' : {
							required: "E dove abiti? Sulla luna?"
						},
						'dd' : {
							required: "Inserisci un giorno"
						},				
						'password' : {
							required : "Non vuoi una password!?",
							minlength : "La password deve essere lunga almeno 8 caratteri!"
						},
						'password2' : {
							required: "Ripeti la password!",
							minlength: "La password deve essere lunga almeno 8 caratteri!",
							equalTo: "Non mi sembra tanto simile alla password che hai scritto sopra..."
						}
					}
				});
			});
        </script>
        <script src="./js/functions.js"></script>
        <script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-29666712-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();

</script>
    </head>
    <body>
        <div id="container" style="padding-top: 20px">
            <div id="logo">
                <img src="./css/img/logoREAL.png" />
            </div>
            <br />
            <div id="signupForm" style="display: block">
				<div id="right">
				<form action="signup.php" method="post" id="signup_form">
					<table summary="Registrazione">
						<tr>
							<td><label>Nome:</label></td>
							<td>
							<input type="text" name="name" />
							</td>
						</tr>
						<tr>
							<td><label>Cognome:</label></td>
							<td>
							<input type="text" name="surname" />
							</td>
						</tr>
						<tr>
							<td><label>Indirizzo email:</label></td>
							<td>
							<input type="text" name="email" />
							</td>
						</tr>
						<tr>
							<td><label>Nuova password:</label></td>
							<td>
							<input type="password" name="password" id="password" maxlength="20" />
							</td>
						</tr>
						<tr>
							<td><label>Ripeti password:</label></td>
							<td>
							<input type="password" name="password2" maxlength="20" />
							</td>
						</tr>
						<tr>
							<td><label>Citt&agrave;</label></td>
							<td>
							<input type="text" name="city" />
							</td>
						</tr>
						<tr>
							<td><label>Sesso:</label></td>
							<td>
							<select name="sex">
								<option value="0">Seleziona sesso:</option>
								<option value="1">Uomo</option>
								<option value="2">Donna</option>
							</select></td>
						</tr>
						<tr>
							<td><label>Data di nascita:</label></td>
							<td>
							<select name="dd">
								<option value="-1">Giorno:</option>
								<?php
								for ($i = 1; $i < 32; $i++) {
									if ($i < 10) {
										echo '<option 		value="0' . $i . '">' . $i . '</option>';
									} else {
										echo '<option 		value="' . $i . '">' . $i . '</option>';
									}
								}
								?>
							</select>
							<select id="mese" name="mm">
								<option value="-1">Mese:</option>
								<option value="01">Gennaio</option>
								<option value="02">Febbraio</option>
								<option value="03">Marzo</option>
								<option value="04">Aprile</option>
								<option value="05">Maggio</option>
								<option value="06">Giugno</option>
								<option value="07">Luglio</option>
								<option value="08">Agosto</option>
								<option value="09">Settembre</option>
								<option value="10">Ottobre</option>
								<option value="11">Novembre</option>
								<option value="12">Dicembre</option>
							</select>
							<select name="yy">
								<option value="-1">Anno:</option>
								<?php
								for ($i = date("Y") - 14; $i > 1930; $i--) {
									echo '<option value="' . $i . '">' . $i . '</option>';
								}
								?>
							</select></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 12px">
								Registrandoti confermi di aver letto la nostra <a href="readme.php" title="Informativa sulla privacy" style="text-decoration: underline">informativa sulla privacy</a>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
							<input id="signupSubmit" class="submit" type="submit" value="Registrati" style="display: block" />
							</td>
						</tr>
					</table>
				</form>
				</div>
				<div id="left">
					<p>					<img src="./css/img/omini.png" alt="Aspettano te su SocialDoor!" width="150" align="right" />

					<strong>SocialDoor</strong> &egrave; un social network dove puoi metterti in contatto pi&ugrave; facilmente con i tuoi amici o dove puoi conoscere nuova gente.
</p>
<p>Registrandoti entrerai a far parte di una rete e creerai la tua <strong>stanza</strong>, una pagina personale in cui potrai condividere i tuoi pensieri e che potrai personalizzare come meglio credi. 
<h3 style="margin-left: 20px">Cosa aspetti? Manchi solo tu!</h3></p>

				</div>
				<div style="clear: both"><br />
				<h3>Sei gi&agrave; registrato?<br /><a href="login.php" title="Accedi">Accedi</a></h3>
				</div>
			</div>
        </div>
    </body>
</html>
<?php } ?>
