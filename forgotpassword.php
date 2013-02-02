<?php
session_start();
include ('./includes/user.class.php');
include ('./includes/mysqlclass.class.php');
if (isset($_SESSION['loggedin']))
    $user = new user($_SESSION['user']);
?>
<html>
    <head>
        <title>SocialDoor</title>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/css.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <script src="./js/jquery.min.js"></script>
        <script language="javascript">
            $(document).ready(function() {
                $('#loggedname').click(function() {
                    $('ul.dx_menu').slideToggle('medium');
                });
            });

        </script>
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

        </script>
        <script src="./js/ajax.js" language="javascript"></script>
        <style>
            p{
                font-size: 14px;
                padding-left: 20px;
            }
            li{
                font-size: 14px;
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
            <div id="content" style="text-align: center">
<?php
    if($_POST['email']!="") {
        $mysql = new MySqlClass();
        $mysql->connect();
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_STRING));
        $result = $mysql->query("SELECT * FROM users WHERE email = '$email'");
        if(mysql_num_rows($result)==0){
            die("Non risulta iscritto nessun utente con l'indirizzo email $email");
        }
        $user = new user(mysql_fetch_object($result));   
        $password = substr(md5(time()+rand(0,99)),0,20);
        $header = "To: ".$user->getCompleteName()." <".$user->getEmail().">\n";
        $header .= "From: SocialDoor <noreply@socialdoor.it>\n";
        $oggetto = "Password Dimenticata";
        $messaggio = "Ciao ".$user->getName().", \nabbiamo saputo che hai perso la password e per aiutarti ne abbiamo generata una nuova! ";
        $messaggio .= "Se non sei stato tu a dircelo per favore contattaci all'indirizzo info@socialdoor.com.\n";
        $messaggio .= "Dovrai comunque accedere con la tua nuova password e cambiarla. Ci scusiamo per il disagio.\n";
        $messaggio .= "\nLa nuova password è $password";
        mail($email,$oggetto,$messaggio,$header);
        $hash = hash("sha256",$email.$password);
        $mysql->query("UPDATE users SET password = '$hash' WHERE email = '$email'");
        echo "<p>La nuova password &egrave; stata inviata all'indirizzo <strong>$email</strong></p> ";
    } else {
        echo '<p>Inserisci la tua email e ti manderemo una nuova password!</p><br /><form action="forgotpassword.php" method="POST" style="width: 400px; margin: 0px auto"> <input type="text" name="email"><input class="submit" type="submit" value="Invia"></form>';
    }
?>
</div></div></body></html>