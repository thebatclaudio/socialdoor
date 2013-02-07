<?php
    //script used to change password
    
    //open session
    session_start();
    //if user is not logged in i redirect him at login page
    if(!isset($_SESSION['loggedin'])){
        header('location: login.php?error=1');
    }
    
    //include mysqlclass and user class
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    
    //create user istance
    $user = new user($_SESSION['user']);
    
    //include header
    include "header.php";
    
    echo '<div id="container">';
    
    //if old password, password and repetition of password are inserted
    if(isset($_POST['oldpassword']) AND isset($_POST['password']) AND isset($_POST['password2'])){
        //if new password and repetition of new password are equals
        if($_POST['password'] == $_POST['password2']){
            //create mysqlclass istance
            $mysql = new MySqlClass();
            //connect to db
            $mysql->connect();
            //create hashing with new password and old password
            $hash = hash("sha256",$user->getEmail().$_POST['password']);
            $test = hash("sha256",$user->getEmail().$_POST['oldpassword']);
            //execute query to find user with username and password equals
            $result = $mysql->query("SELECT * FROM users WHERE idUser = ".$user->getId()." AND password = '$test'");
            if(mysql_num_rows($result)>0){
                //update row
                $mysql->query("UPDATE users SET password = '$hash' WHERE idUser = ".$user->getId());
                //disconnect db
                $mysql->disconnect();
                echo "<h4>Password cambiata</h4>";
            } else {
                //else old password is not correct
                echo "<h4>La vecchia password non corrisponde a quella presente sul database</h4>";
            }
        } else {
            //else new password and repetition of password are not equals
            echo "<h4>Le due password non corrispondono</h4>";
        }
    } else {
        //else password are not just inserted
        //print form
        echo '<div id="header">
				<div id="right">
					<form action="search.php" method="post">
						<input type="text" id="search" name="search" placeholder="Search..." autocomplete="off">
					</form>
				</div>
				<div id="left">
					<a href="home.php" title="Back to home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
				</div>
			</div>';
		echo "<div id='content'><h2>Change password</h2><div class='div'></div>";
        echo '<form action="changePassword.php" method="POST"> 
            <table align="center">
                <tr>
                    <td>Old password:</td> <td><input type="password" name="oldpassword" maxlength="20"></td>
                </tr>
                <tr>
            <td>New password:</td> <td><input type="password" name="password" maxlength="20"></td>
            </tr>
            <tr>
            <td>Repetition new password: </td><td><input type="password" name="password2" maxlength="20"></td>
           </tr><tr><td></td><td> <input type="submit" value="Change" class="submit"></td></tr></table>
            </form></div></div>';                    
    }
?>