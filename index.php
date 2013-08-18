<?php
session_start();
if (isset($_SESSION['loggedin'])) {
	header('Location: home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>SocialDoor - Accedi o iscriviti e crea la tua stanza</title>
		<meta content="Claudio La Barbera" name="author" />
		<link rel="shortcut icon" href="http://www.socialdoor.it/css/favicon.ico" />
		<meta content="SocialDoor &egrave; un social network che ti consente di connetterti con i tuoi amici, condividere pensieri e personalizzare la tua stanza" name="description" />
		<meta content="socialdoor, social door, socialdoor.it, social network, crea la tua stanza, condividi pensieri, condividi post, personalizza la tua stanza, arreda la tua stanza, crea la tua pagina personale, pagina personale, social networking, social" name="keywords" />
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		<link href="./css/home.css?u=5" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="fb-root"></div>
		<div id="container">
			<div id="header">
				<div id="logo">
					<a href="index.php" title="SocialDoor - Accedi o iscriviti e crea la tua stanza"><img src="./css/img/logo.png" alt="SocialDoor - Accedi o iscriviti e crea la tua stanza"></a>
				</div>
				<div id="login">
					<form action="login.php" method="post">
						<label>Indirizzo email:</label>
						<input type="text" name="email" />
						<br />
						<label>Password:</label>
						<input type="password" name="password" />
						<br />
						<a href="forgotpassword.php" title="Password dimenticata?" id="forgot">Password dimenticata?</a>
						<input type="submit" class="submit" value="Accedi" />
					</form>
				</div>
			</div>
			<div id="mid">
				<div id="mid_right">
					<?php if(!isset($_GET['exit'])) {
					?>
					<h2>Con <strong>SocialDoor</strong> puoi metterti in contatto pi&ugrave; facilmente con i tuoi amici.</h2>
					<?php } else { ?>
					<h2>Torna presto su <strong>SocialDoor</strong></h2>
					<?php } ?>
				</div>
				<div id="mid_left">
					<img src="./css/img/rooms.png" alt="Crea la tua stanza su SocialDoor">
				</div>
			</div>
			<div id="content">
				<div id="right">
					<div id="right_right">
						<h3>Condividi la tua vita con i tuoi amici!</h3>
						<p>
							Su SocialDoor puoi condividere pensieri, link, video e foto con i tuoi amici con un semplice click!
						</p>
						<p>
							Restare in contatto diventer&agrave; un gioco da ragazzi!
						</p>
					</div>
					<div id="right_left">
						<h3>Trova i tuoi amici e conosci nuova gente!</h3>
						<p>
							Vuoi metterti in contatto con qualcuno su SocialDoor? Basta cercare il suo nome e suonare il suo campanello!
						</p>
						<p>
							Quando suoni il campanello chiedi al proprietario della stanza di condividere i suoi post con te e, nello stesso momento, tu condividi i tuoi con lui!
						</p>
					</div>
					<div id="right_footer"></div>
				</div>
				<div id="left">
					<h3>Crea la tua stanza!</h3>
					<p>
						Registrandoti su SocialDoor creerai la tua stanza, una pagina personale che potrai modificare come meglio ti pare.
					</p>
					<p>
						Carica il tuo sfondo, cambia i colori del testo e crea anche tu la tua identit&agrave; online!
					</p>
				</div>
			</div>
			<div id="footer">
				<h2>E allora cosa aspetti?</h2>
				<a href="signup.php" title="Registrati!" id="signup">Registrati</a>
			</div>
			<div id="credits">
				<a href="index.php" title="SocialDoor">SocialDoor</a> &copy; 2012 - <a href="./en/" title="English version">English</a> - </a><a href="readme.php" title="Informativa sulla privacy">Informativa sulla privacy</a> - <a href="./blog/" title="Blog">Blog</a> - <a href="http://www.facebook.com/socialdoor.it" title="SocialDoor su Facebook" target="_blank">Facebook</a> - <a href="http://www.twitter.com/socialdoor" title="SocialDoor su Twitter" target="_blank">Twitter</a> - <a href="https://plus.google.com/108232997018106862537/" title="SocialDoor su Google+" target="_blank">Google+</a>
				<br />
				Developed by <a href="http://www.labarberawebdesign.it" title="LaBarbera Webdesign" target="_blank">Claudio La Barbera</a>
			</div>
		</div>
	</body>
</html>
