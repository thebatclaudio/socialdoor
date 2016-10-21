<?
session_start();

if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
    header('location: login.php?error=1');
}

include "./includes/mysqlclass.class.php";
include "./includes/user.class.php";

function deletePhoto($file)
    {
        if (!file_exists($file)) 
        {
            return 0;
        } 
        else 
        {
            if (!unlink($file)) 
            {
                return 0;
            } 
            else 
            {
                return 1;
            }
        }
    }
    
function fExt($string)
    { 
        //controllo il file
        $trova_punto = explode(".", $string);
        $estensione = $trova_punto[count($trova_punto) - 1];
        $estensione = strtolower($estensione);
    
        //se non ci sono estensioni ritorno ''
        if (isset($trova_punto[1]) == FALSE)
        {
            return '';
        }
        //ritorno il valore dell' estensione
        return $estensione;
    }

$user = new user($_SESSION['user']);

// compatibilità con versioni precedenti
if (!isset($_FILES))
    $_FILES = $HTTP_POST_FILES;
if (!isset($_SERVER))
    $_SERVER = $HTTP_SERVER_VARS;

if(!eregi('image/', $_FILES['upfile']['type'])){
    include "header.php";
    die("<div id='container'><h3>Il formato $ext non &egrave; supportato</h3></div>");    
}
    
$upload_dir = "./photos/";

$est = array('.jpg', '.JPG', '.jpeg', '.JPEG', '.gif', '.GIF', '.png', '.PNG');

$i = 0;
$flag = FALSE;

while ($i < count($est) && $flag == 0) {
    $name = $user->getId() . $est[$i];
    $flag = deletePhoto("./photos/" . $name);
    $i++;
}

$ext=fExt($_FILES["upfile"]["name"]);

$i=0;
$flag==0;
while ($i < count($est) && $flag == 0) { 
    if(".".$ext == $est[$i]){
        $flag=1;
    }
    $i++;
}

if($flag==0){
    include "header.php";
    die("<div id='container'><h3>Format $ext is not supported</h3></div>");
}

$new_name = $user->getId() . "temp." . $ext;

$file_name = ($new_name) ? $new_name : $_FILES["upfile"]["name"];

if (trim($_FILES["upfile"]["name"]) == "") {
    include "header.php";
    die("<div id='container'><h3>You didn't selected a photo!</div>");

}

if (@is_uploaded_file($_FILES["upfile"]["tmp_name"])) {

    @move_uploaded_file($_FILES["upfile"]["tmp_name"], "$upload_dir/$file_name") or die("Unable to copy the photo!");

} else {

    die("Ops! There was an error! " . $_FILES["upfile"]["name"]);

}

header("location: cropphoto.php?ext=$ext");
?>
