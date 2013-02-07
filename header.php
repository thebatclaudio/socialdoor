<html>
	<head>
		<title><?php
		if (isset($title))
			echo $title;
		else
			echo "SocialDoor";
			?></title>
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" media="screen" href="./css/css.css?r=<?php echo rand(0, 9999999); ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link rel="shortcut icon" href="http://www.socialdoor.it/css/favicon.ico" />
		<?php if(isset($description) AND isset($keywords)) :
		?>
		<meta content="<?php echo $description; ?>" name="description" />
		<meta content="<?php echo $keywords; ?>" name="keywords" />
		<?php endif; ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="./js/jquery.min.js"></script>
		<script language="javascript">
			$(document).ready(function() {
				$('#loggedname').click(function() {
					$('ul.dx_menu').slideToggle('medium');
				});
			});
		</script>
		<?php
		if (isset($_SESSION['loggedin'])) {
			include "js_scripts.php";
		}
		?>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

		<script type="text/javascript" src="js/minicolors/jquery.miniColors.js"></script>
		<link type="text/css" rel="stylesheet" href="js/minicolors/jquery.miniColors.css" />

		<script type="text/javascript">
			$(document).ready(function() {

				//
				// Enabling miniColors
				//

				$(".color-picker").miniColors({
					letterCase : 'uppercase',
					change : function(hex, rgb) {
						logData(hex, rgb);
					}
				});
			});
			
			$(document).ready(function(){
				$("#bgColor").click(function() {
					var color = $('#bgColor').attr('value');
					$('body').css("background",color);
				});
			});
			
			$(document).ready(function(){
				$("#textColor1").click(function() {
					var color = $('#textColor1').attr('value');
					$('body').css("color",color);
					$('a:link').css("color",color);
					$('.date').css("color",color);
					$('.date span').css("color",color);
					$('.doorBell').css('color',color);
				});
			});
			
			$(document).ready(function(){
				$("#textColor2").click(function() {
					var color = $('#textColor2').attr('value');
					$('h1').css("color",color);
					$('h2').css("color",color);
					$('h3').css("color",color);
					$('h4').css("color",color);
					$('a:hover').css("color",color);
					$('span a:link').css("color",color);
					$('.submit').css("background",color);
					$('.doorBell').css("background",color);
				});
			});

			$(document).ready(function(){
				$("#bgPost").click(function() {
					var color = $('#bgPost').attr('value');
					$('.post').css("background",color);
					$('#userInfo').css("background",color);
					$('#search').css("background",color);
				});
			});
		</script>

        <script>
            function commenta() {
                var message = document.getElementById("warning");
                message.innerHTML = "Attendi...";
                var oXHR = new XMLHttpRequest();
                var text = document.getElementById("allComments").innerHTML;
                oXHR.open("post", "comment.php", true);
                oXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                oXHR.onreadystatechange = function() {
                    if(oXHR.readyState == 4) {
                        if(oXHR.responseText != 'KO') {  
                            text += oXHR.responseText;
                            document.getElementById("allComments").innerHTML = text;
                            document.getElementById("commentInput").value="";
                            message.innerHTML = "";
                            location.href='#lastcomment';
                        } else {
                        message.innerHTML = "Si &egrave; verificato un errore. Riprovare";
                        }
                    }
                }
            var params = "idUser=<?php if(isset($_SESSION['loggedin'])) echo $user->getId(); ?>&idPost=<?php echo $_GET['id'] ?>&content="+document.getElementById("commentInput").value;
            oXHR.send(params);
    }

        </script>

		<script src="./js/ajax.js" language="javascript"></script>

		<link rel="stylesheet" type="text/css" media="screen" href="./css/room.php?r=<?php echo md5(mt_rand());
	if (isset($id))
		echo "&id=$id";
		?>" />
		
		<script src="./js/chat.js"></script>

	</head>

	<body id="body" onload="javascript:init()">
		<div id="newNotif">
			Hai una nuova notifica! <a href="notifications.php" id='readNotif'>Leggi</a>
		</div>
		<div id="topbar">
			<div id="topBarLeft" style="padding: 7px;">
				<a href="home.php" title="Torna alla home">Home</a>
				<?php
				if ($_SESSION['loggedin'])
					echo '<a href="room.php?id=' . $user -> getId() . '" title="Vai nella tua stanza">La tua stanza</a>';
				?>
			</div>
			<div id="topBarRight" style="padding: 7px;">
				<?php
				if ($_SESSION['loggedin']) {
					echo '<a href="#" id="loggedname">
' . $user -> getCompleteName() . ' <span id="notificationsName"></span> &#9660 </a><br />
<ul class="dx_menu">
<li><a href="notifications.php">Notifiche <span id="notifications"></span></a></li>
<li><a href="room.php?id=' . $user -> getId() . '">Vai nella tua stanza</a></li>
<li><a href="neighbours.php">I tuoi vicini di stanza</a></li>
<li><a href="editData.php">Modifica i tuoi dati</a></li>
<li><a href="logout.php">Esci</a></li>
</ul>';
				} else {
					echo '<a href="index.php" id="loggedname">Accedi / Registrati</a>';
					$_SESSION['url'] = $_SERVER['request_uri'];
				}
				?>
			</div>
		</div>
