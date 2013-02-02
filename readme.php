<?php
session_start();
include ('./includes/user.class.php');
include ('./includes/mysqlclass.class.php');
if (isset($_SESSION['loggedin']))
    $user = new user($_SESSION['user']);
?>
<html>
    <head>
        <title>Informativa sulla privacy</title>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/css.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta content="Termini e condizioni d'uso di SocialDoor che vengono accettate nel momento della registrazione" name="description" />
        <script src="./js/jquery.min.js"></script>
        <script language="javascript">
			$(document).ready(function() {
				$('#loggedname').click(function() {
					$('ul.dx_menu').slideToggle('medium');
				});
			});

        </script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="./js/ajax.js" language="javascript"></script>
        <style>
            p{
                font-size: 14px;
                padding-left: 20px;
            }
            li{
                font-size: 14px;
            }
            h3, h4{
            	color: #55F;
            }
            h3{
            	text-transform: uppercase;
            }
        </style>
    </head>
    <body onload="javascript:init()">
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
                if ($_SESSION['loggedin'])
                    echo '<a href="#" id="loggedname">
' . $user -> getCompleteName() . ' <span id="notificationsName"></span> &#9660 </a><br />
<ul class="dx_menu">
<li><a href="notifications.php">Notifiche <span id="notifications"></span></a></li>
<li><a href="room.php?id=' . $user -> getId() . '">Vai nella tua stanza</a></li>
<li><a href="neighbours.php">I tuoi vicini di stanza</a></li>
<li><a href="editData.php">Modifica i tuoi dati</a></li>
<li><a href="logout.php">Esci</a></li>
</ul>';
                else
                    echo '<a href="index.php">Accedi / Registrati</a>';
                ?>
            </div>
        </div>
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
            <div id="content" style="padding-bottom: 20px;">
                <h2 style="margin-top: 30px">Informativa sulla privacy</h2>
                <div id="div"></div>
                <h3>Trattamento dei dati personali</h3>
                <p>SocialDoor raccoglie i tuoi dati automaticamente attraverso alcune operazioni come registrazione, condivisione di post e commenti.</p>
                <h3>Titolare del trattamento dei dati personali</h3>
                <p>Claudio La Barbera<br />info@socialdoor.it</p>
                <div id="div"></div>
                <h3>Come funziona SocialDoor?</h3>
                <p><img src="./css/img/whatissocialdoor.png" alt="Come funziona SocialDoor?" align="left" width="180" style="border: 0"/>
                	Per spiegare come vengono raccolti e utilizzati i tuoi dati, bisogna prima spiegare nel dettaglio come funziona SocialDoor.</p>
                <h4>Cos'&egrave; la stanza?</h4>
                <p>Registrandoti su SocialDoor creerai la tua stanza. Ma cos'&egrave; di preciso? La stanza &egrave; la tua pagina personale su SocialDoor, dove saranno presenti i tuoi dati personali e tutto ci&ograve; che decidi di condividere con la gente. Pu&ograve; essere modificata a tuo piacimento, cambiando i colori e l'immagine di sfondo. Tutte le modifiche saranno visibili a chiunque visiti la tua stanza.</p>
                <h4>Cosa succede se viene suonato il campanello di qualcuno?</h4>
                <p>Suonare il campanello di qualcuno vuol dire chiedergli di condividere con te tutti i suoi post precedenti e futuri. Se suoni il campanello di un amico quindi, dovrai aspettare che questo ti apra la porta per poter visualizzare i suoi post. Nel momento in cui suoni il campanello di qualcuno, automaticamente stai aprendo a lui la tua porta e stai quindi condividendo con lui tutti i tuoi post.</p>
              	<h4>Da chi possono essere visualizzati i post?</h4>
              	<img src="./css/img/newpost.jpg" align="center" alt="Cos'hai da dire oggi?" style="border: 0" />
                <p>I post possono essere visualizzati solo dalle persone a cui hai aperto la porta. Se non vuoi che qualcuno possa vedere ci&ograve; che condividi, non aprirgli la porta nemmeno se suona il tuo campanello.</p>

                <div id="div"></div>
                <h3>Quali informazioni riceve SocialDoor?</h3>
                <p>Quando ti registri, pubblichi un post, un commento o compi un'azione su SocialDoor, vengono raccolte automaticamente alcune informazioni personali che ci aiutano a migliorare il sistema e renderlo un posto pi&ugrave; sicuro.</p>
                <p>Le informazioni raccolte durante la registrazione sono:</p>
               	<ul>
                	<li>Nome</li>
                	<li>Cognome</li>
                	<li>Data di nascita</li>
                	<li>Sesso</li>
                	<li>Email</li>
                	<li>Citt&agrave; di residenza</li>
                	<li>Indirizzo IP</li>
                </ul>
                <p>Il nome, il cognome, la data di nascita e la citt&agrave; di residenza verranno rese pubbliche a chiunque visiter&agrave; la tua stanza.
                </p>
                <p>Vengono comunque raccolti altri dati su di te nel momento in cui compi qualunque azione. Ad esempio, quando pubblichi un post o un commento, viene registrato il tuo indirizzo IP.</p>
                <h4>Altre informazioni ricevute da SocialDoor</h4>
                <p>Dopo la registrazione, puoi completare i tuoi dati inserendo la situazione sentimentale, il lavoro che svolgi, il tuo sito web e una foto personale. Sono dati opzionali che, se inseriti, saranno resi pubblici e visualizzabili quindi da chiunque visiti la tua stanza.</p>         
            </div>
        </div>
    </body>
</html>
