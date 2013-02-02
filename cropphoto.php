<?php
//script usato per ritagliare la foto

//apro la sessione
session_start();
//se l'utente non è loggato lo reindirizzo al login
if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('location: login.php?error=1');

//includo la classe mysqlclass
include "./includes/mysqlclass.class.php";

//funzione per cancellare la foto passandogli per parametro il nome del file
function deletePhoto($file)
    {
        //se il file non esiste ritorno 0
        if (!file_exists($file)) 
        {
            return 0;
        } 
        else 
        {
            //altrimenti cancello il file
            if (!unlink($file)) 
            {
                //se non l'ho cancellato ritorno 0
                return 0;
            } 
            else 
            {
                //altrimenti ritorno 1
                return 1;
            }
        }
    }

//includo la classe user
include "./includes/user.class.php";
//creo l'oggetto user
$user = new user($_SESSION['user']);

$ext=$_GET['ext'];//estensione del file passata come querystring
$imgsrc = './photos/'.$user->getId().'temp.'.$ext;// URL del file sorgente (immagine originale)
 
//se già il file è stato ritagliato
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  // imposto larhezza ed altezza dell'immagine ritagliata
  $targ_w = $targ_h = 79;
  // imposto la qualità dell'output
  $jpeg_quality = 90;
  // creo l'immagine sorgente
  if($ext == "jpg" OR $ext == "jpeg" OR $ext == "JPG" OR $ext == "jpg")
    $img_r = imagecreatefromjpeg($imgsrc);
  else if($ext == "png" OR $ext == "PNG")
      $img_r = imagecreatefrompng($imgsrc);
  else if($ext == "gif" OR $ext == "GIF")
    $img_r = imagecreatefromgif($imgsrc);
  // creo la nuova immagine delle dimensioni specificate
  $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
  // creo una copia dell'immagine sorgente opportunamente ritagliata
  imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
  // creo l'immagine
  imagejpeg($dst_r,"./photos/".$user->getId().".jpg",$jpeg_quality);
  //cancello la foto
  $flag=deletePhoto($imgsrc);
  //apro il db e setto 1 nel campo pic dell'user (anche nella sessione)
  $mysql = new MySqlClass();
  $mysql->connect();
  $mysql->query("UPDATE `users` SET `pic` = '1' WHERE `idUser` =" . $user->getId() . ";");
  $_SESSION['user']->pic=1;
  $mysql->disconnect();
  //reindirizzo l'user alla home
  header('location: home.php');
}
?>
<html>
<head>
    <title>Socialdoor</title>
<script src="./js/jquery.min.js"></script>
<script src="./js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="./css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" href="./css/css.css" type="text/css" />
        <script language="javascript">
            $(document).ready(function() {
                $('#loggedname').click(function() {
                    $('ul.dx_menu').slideToggle('medium');
                });
            });

        </script>
<script language="Javascript">
$(function(){
  // inizializzo Jcrop
  $('#cropbox').Jcrop({
    // proporzioni quadrate
    aspectRatio: 1,
    // alla selezione aggiorno le coordinate nel form
    onSelect: updateCoords
  });
});
 
// funzione per l'aggiornamento delle coordinate
function updateCoords(c) {
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#w').val(c.w);
  $('#h').val(c.h);
}
 
// funzione di controllo
function checkCoords() {
  if (parseInt($('#w').val())) return true;
  else{
    alert("Per favore seleziona un'area e poi clicca su ritaglia.");
    return false;
  }
}
</script>
</head>
<body>
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
                    echo '<a href="#" id="loggedname" onClick="displayOn()">
' . $user -> getCompleteName() . ' <span id="notificationsName"></span> &#9660 </a><br />
<ul class="dx_menu">
<li><a href="notifications.php">Notifiche <span id="notifications"></span></a></li>
<li><a href="room.php?id=' . $user -> getId() . '">Vai nella tua stanza</a></li>
<li><a href="editData.php?id=' . $user -> getId() . '">Modifica i tuoi dati</a></li>
<li><a href="logout.php">Esci</a></li>
</ul>';
                else
                    echo '<a href="index.php">Accedi / Registrati</a>';
                ?>
            </div>
        </div>
        <div id="container">
            <h1>Ritaglia la foto</h1>
<div style="width: <?php $infoImage = getimagesize($imgsrc); echo $infoImage[0]; ?>px; margin: 0px auto; "><img src="<?php echo $imgsrc."?imm=".rand(0,99999); ?>" id="cropbox" /></div>
<div>
<form action="cropphoto.php?ext=<?php echo $ext ?>" method="post" onsubmit="return checkCoords();">
<input type="hidden" id="x" name="x" />
<input type="hidden" id="y" name="y" />
<input type="hidden" id="w" name="w" />
<input type="hidden" id="h" name="h" />
<input type="submit" class="submitPhoto" value="Ritaglia" />
</form>
</div>
 </div> 
</body>
</html>