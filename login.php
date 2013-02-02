<?php
	//apro la sessione
	session_start();
	
	//se è settata la variabile loggedin ed è uguale ad 1
	if(isset($_SESSION['loggedin']) AND $_SESSION['loggedin']==1){
		header("Location: home.php");//reindirizzo l'utente alla home
	}
	
	$error=0;//setto il flag "error" a 0
	
	//controllo se l'email è stata inserita
	if(!isset($_POST['email']) || $_POST['email']==""){
		$error=1;//se non è stata inserita setto il flag a 1
	}
	
	//controllo se la password è stata inserita
	if(!isset($_POST['password']) || $_POST['password']==""){
		//se il flag è già uguale a 1 significa che anche l'email non è stata inserita	
		if($error==1){
			$error=3;//quindi setto il flag a 3
		}
		else {
			$error=2;//altrimenti lo setto a 2
		}
	}
	
	if($_GET['error']==1){
		$error=4;
	}
	
	//se il flag è uguale a 0 (sono stati inseriti sia email che password)
	if($error==0){
		$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));//pulisco l'email
		$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));//pulisco la password
		$hash = hash("sha256",$email.$password);
		
		include "./includes/mysqlclass.class.php";//includo la classe mysql
		include "./includes/user.class.php";//includo la classe user
		
		$mysql = new MySqlClass();//creo un'istanza di mysql
		$mysql->connect();//mi connetto al db
		//controllo se esiste un utente con email e password uguali a quelle inserite
		$auth = $mysql->query("SELECT * FROM users WHERE email = '$email' AND password = '$hash'");
		
		//se il numero delle righe che viene restituito è uguale a 0 significa che non esiste
		if(mysql_num_rows($auth)<1){
			header("Location: login.php?error=1");//quindi reindirizzo l'utente al login
		} else {
			$_SESSION['user'] = mysql_fetch_object($auth);//altrimenti creo un'istanza user con i dati estratti dal db
			$user = new user($_SESSION['user']);
			$_SESSION['username'] = $user->getUsername();
			$_SESSION['loggedin']=1;//setto la variabile loggedin a 1
			$mysql->disconnect();//mi disconnetto dal db
			
			if(isset($_SESSION['url'])){
				header("Location: ".$_SESSION['url']);
			} else {
				header("Location: home.php");//reindirizzo l'utente alla home
			}			
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>SocialDoor - Effettua l'accesso</title>
		<meta content="Effettua l'accesso su SocialDoor" name="description" />
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		<link href="./css/style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29666712-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</head>
	<body>
		<div id="container">
			<div id="logo">
				<img src="./css/img/logo.png" />
			</div>
			<br />
			<div id="login">
				<form action="login.php" method="post">
					<?php
						if($error==1)//se il flag è uguale a 1 non è stata inserita solo l'email
							echo "<h1>Inserisci l'email</h1>";
						else if($error==2)//se il flag è uguale a 2 non è stata inserita solo la password
							echo "<h1>Inserisci la password</h1>";
						else if($error==3) //altrimenti (uguale a 3) non sono stati inseriti sia l'email che la password
							echo "<h1>Effettua l'accesso</h1>";
						else
							echo "<h1>Effettua l'accesso</h1>";
					?>
					<input type="email" placeholder="Indirizzo email" name="email" />
					<br />
					<input type="password" placeholder="Password" name="password" maxlength="20" />
					<br />
					<input type="submit" class="submit" value="Accedi" />
				</form>
				<a href="forgotpassword.php">Password dimenticata?</a>
			</div>
		</div>
	</body>
</html>