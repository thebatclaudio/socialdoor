<?php
session_start();
if (isset($_SESSION['loggedin'])) {
	header('Location: /../home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>SocialDoor - Log in or sign up to create your own room</title>
		<meta content="Claudio La Barbera" name="author" />
		<meta name="google-site-verification" content="F5VW5s9PhNZ7DW7ZJXqvrsTErdYwecqmuqrCDCi8TtY" />
		<link rel="shortcut icon" href="http://www.socialdoor.it/css/favicon.ico" />
		<meta content="SocialDoor is a social network that allows you to connect with your friends, share thoughts and customize your room" name="description" />
		<meta content="socialdoor, social door, socialdoor.it, social network, create your own room, share thoughts, share posts, customize your room, decorate your room, create your personal page, personal page, social networking, social" name="keywords" />
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		<link href="../css/home.css?u=5" rel="stylesheet" type="text/css" />
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
		<div id="fb-root"></div>
		<div id="container">
			<div id="header">
				<div id="logo">
					<a href="index.php" title="SocialDoor - Log in or sign up to create your own room"><img src="../css/img/logo.png" alt="SocialDoor - Login or signup to create your own room"></a>
				</div>
				<div id="login">
					<form action="/../login.php" method="post">
						<label>Email address:</label>
						<input type="text" name="email" />
						<br />
						<label>Password:</label>
						<input type="password" name="password" />
						<br />
						<a href="forgotpassword.php" title="Forgot your password?" id="forgot">Forgot your password?</a>
						<input type="submit" class="submit" value="Log In" />
					</form>
				</div>
			</div>
			<div id="mid">
				<div id="mid_right">
					<?php if(!isset($_GET['exit'])) {
					?>
					<h2>With <strong>SocialDoor</strong> you can more easily keep in touch with your friends.</h2>
					<?php } else { ?>
					<h2>Come back soon on <strong>SocialDoor</strong></h2>
					<?php } ?>
				</div>
				<div id="mid_left">
					<img src="../css/img/rooms.png" alt="Crea la tua stanza su SocialDoor">
				</div>
			</div>
			<div id="content">
				<div id="right">
					<div id="right_right">
						<h3>Share your life with your friends!</h3>
						<p>
							On SocialDoor you can share thoughts, links, videos and photos with your friends by a simple click!
						</p>
						<p>
							Keeping in touch will become a piece of cake!
						</p>
					</div>
					<div id="right_left">
						<h3>Find your friends and meet new people!</h3>
						<p>
							Do you want to keep in touch with someone on SocialDoor? You just need to search for his or her name and ring the bell!
						</p>
						<p>
							Anytime you ring the bell you are asking room's owners to share his posts with you and, at the same time, you share your posts with him!
						</p>
					</div>
					<div id="right_footer"></div>
				</div>
				<div id="left">
					<h3>Create your own room!</h3>
					<p>
						When you sign up on SocialDoor, you create your own room, a personal page that you will be able to customize as you like it.
					</p>
					<p>
						Upload your background, change text colours and create your online identity!
					</p>
				</div>
			</div>
			<div id="footer">
				<h2>What are you waiting for?</h2>
				<a href="/../signup.php" title="Registrati!" id="signup">Sign Up</a>
			</div>
			<div id="credits">
				<a href="index.php" title="SocialDoor">SocialDoor</a> &copy; 2012 - <a href="./../" title="Versione italiana">Italiano</a> - <a href="/../readme.php" title="Privacy">Privacy</a> - <a href="/../blog/" title="Blog">Blog</a> - <a href="http://www.facebook.com/socialdoor.it" title="SocialDoor on Facebook" target="_blank">Facebook</a> - <a href="http://www.twitter.com/socialdoor" title="SocialDoor on Twitter" target="_blank">Twitter</a> - <a href="https://plus.google.com/108232997018106862537/" title="SocialDoor on Google+" target="_blank">Google+</a>
				<br />
				Developed by <a href="http://www.labarberawebdesign.it" title="LaBarbera Webdesign" target="_blank">Claudio La Barbera</a>
			</div>
		</div>
	</body>
</html>