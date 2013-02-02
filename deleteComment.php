<?php
//funzione utilizzata in ajax per cancellare i commenti

//apro la sessione
session_start();

//se l'utente non è loggato lo reindirizzo alla pagina di login
if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('location: login.php?error=1');

//includo la classe mysqlclass
include "./includes/mysqlclass.class.php";

//creo l'oggetto user
$mysql = new MySqlClass();
$mysql->connect();

//se l'id del post passato non è numerico chiudo lo script
if(!is_numeric($_POST['id'])){
    die('KO');
}

//altrimenti lo passo nella variabile id
$id = $_POST['id'];

//cancello il commento e disconnetto
$mysql->query("DELETE FROM comments WHERE idComment = $id");
$mysql->disconnect();

echo "OK";
?>