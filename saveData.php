<?php
    session_start();
    if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
        header('location: login.php?error=1');
    }
    
    include('./includes/mysqlclass.class.php');
    include('./includes/user.class.php');
    
    $flag = 0;
    
    $user = new user($_SESSION['user']);
    
    $mysql = new MySqlClass();
    $mysql->connect();
    
    $query = "UPDATE users SET ";
    
    if(isset($_POST['name']) AND $_POST['name']!=""){
        $flag = 1;
        $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
        $query .= "name = '$name',";
        $_SESSION['user']->name = $name;
    }
    
    if(isset($_POST['surname']) AND $_POST['surname']!=""){
        $flag = 1;    
        $surname = htmlspecialchars(strip_tags(trim($_POST['surname'])));
        $query .= "surname = '$surname',";
        $_SESSION['user']->surname = $surname;
    }
    
    if(isset($_POST['email']) AND $_POST['email']!=""){
        $flag = 1;    
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $query .= "email = '$email',";
        $_SESSION['user']->email = $email;
    }

    if(isset($_POST['city']) AND $_POST['city']!=""){
        $flag = 1;   
        $city = htmlspecialchars(strip_tags(trim($_POST['city'])));
        $query .= "city = '$city',";
        $_SESSION['user']->city =$city;
    }
    
    if(isset($_POST['work']) AND $_POST['work']!=""){
        $flag = 1;
        $work = htmlspecialchars(strip_tags(trim($_POST['work'])));
        $query .= "work = '$work',";
        $_SESSION['user']->work = $work;
    }

    if(isset($_POST['website']) AND $_POST['website']!=""){
        $flag = 1;
        $website = htmlspecialchars(strip_tags(trim($_POST['website'])));
        $query .= "website = '$website',";
        $_SESSION['user']->website = $website;
    }
	
    if(isset($_POST['relationship']) AND $_POST['relationship']!=""){
        $flag = 1;
        $relationship = htmlspecialchars(strip_tags(trim($_POST['relationship'])));
        $query .= "relationship = '$relationship',";
        $_SESSION['user']->relationship = $relationship;
    }
    
    if($_POST['sex']!=0){
        $flag = 1;
        $sex = $_POST['sex'];
        $query .= "sex = $sex,";
        $_SESSION['user']->sex = $sex;
    }

    if($_POST['dd']!=-1 AND $_POST['mm']!=-1 AND $_POST['yy']!=-1){
        $flag = 1;
        $birthday = $_POST['yy']."-".$_POST['mm']."-".$_POST['dd'];
        $query .= "birthday = '$birthday',";
        $_SESSION['user']->birthday = $birthday;
    }
    
    $query=substr($query,0,strlen($query)-1);
    $query.= " WHERE idUser = ".$user->getId();
    
    if($flag==1){
        $mysql->query($query);
    }
    $mysql->disconnect();
    
    header('location: editData.php');      
?>