<?
session_start();

if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
    header('location: login.php?error=1');
}

include "./includes/mysqlclass.class.php";
include "./includes/user.class.php";

$user = new user($_SESSION['user']);

include "header.php";

?>
<div id="container">
    <h3>Carica un'immagine di sfondo</h3>
    <form action="saveBg.php" method="post" enctype="multipart/form-data" width="100px">
                            <input type="file" name="upfile" id="upfile" />
                            <br />
                            <input type="submit" class="submitPhoto" value="Carica" /><br />
                            <p>Possono essere caricate solo JPEG</p>
                         </form>
</div></body></html>
