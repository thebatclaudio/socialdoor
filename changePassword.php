<?php
    //script per cambiare la password
    
    //apro la sessione
    session_start();
    //se l'utente non è connesso lo reindirizzo alla pagina di login
    if(!isset($_SESSION['loggedin'])){
        header('location: login.php?error=1');
    }
    
    //includo le due classi mysqlclass e user
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    
    //creo l'oggetto user
    $user = new user($_SESSION['user']);
    
    //includo l'header
    include "header.php";
    
    echo '<div id="container">';
    
    //se sono state inserite vecchia password, nuova password e la ripetizione della nuova password
    if(isset($_POST['oldpassword']) AND isset($_POST['password']) AND isset($_POST['password2'])){
        //se la nuova password e la ripetizione della password sono uguali
        if($_POST['password'] == $_POST['password2']){
            //creo l'oggetto mysql
            $mysql = new MySqlClass();
            //mi connetto al db
            $mysql->connect();
            //creo l'hash con la nuova password e con la vecchia password
            $hash = hash("sha256",$user->getEmail().$_POST['password']);
            $test = hash("sha256",$user->getEmail().$_POST['oldpassword']);
            //eseguo la query per cercare l'utente con id e password uguali
            $result = $mysql->query("SELECT * FROM users WHERE idUser = ".$user->getId()." AND password = '$test'");
            //se il risultato della query mi da più di una riga
            if(mysql_num_rows($result)>0){
                //aggiorno la riga
                $mysql->query("UPDATE users SET password = '$hash' WHERE idUser = ".$user->getId());
                //disconnetto dal db
                $mysql->disconnect();
                echo "<h4>Password cambiata</h4>";
            } else {
                //altrimenti la password non corrisponde 
                echo "<h4>La vecchia password non corrisponde a quella presente sul database</h4>";
            }
        } else {
            //altrimenti le due password non corrispondono
            echo "<h4>Le due password non corrispondono</h4>";
        }
    } else {
        //altrimenti la password deve ancora essere inserita
        //stampo il form
        echo '<div id="header">
				<div id="right">
					<form action="search.php" method="post">
						<input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
					</form>
				</div>
				<div id="left">
					<a href="home.php" title="Torna alla home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
				</div>
			</div>';
		echo "<div id='content'><h2>Cambia password</h2><div class='div'></div>";
        echo '<form action="changePassword.php" method="POST"> 
            <table align="center">
                <tr>
                    <td>Vecchia password:</td> <td><input type="password" name="oldpassword" maxlength="20"></td>
                </tr>
                <tr>
            <td>Nuova password:</td> <td><input type="password" name="password" maxlength="20"></td>
            </tr>
            <tr>
            <td>Conferma nuova password: </td><td><input type="password" name="password2" maxlength="20"></td>
           </tr><tr><td></td><td> <input type="submit" value="Cambia" class="submit"></td></tr></table>
            </form></div></div>';                    
    }
?>