<?php
    session_start();
    
    function data_it($date) {
        $array2 = explode(" ",$date);
        //divido in un array la data
        $array = explode("-", $array2[0]);
        //correggo i numeri da 1 a 9 cancellando lo 0 davanti (es. 01 diventa 1)
        switch($array[2]) {
            case "01" :
                $array[2] = "1";
                break;
            case "02" :
                $array[2] = "2";
                break;
            case "03" :
                $array[2] = "3";
                break;
            case "04" :
                $array[2] = "4";
                break;
            case "05" :
                $array[2] = "5";
                break;
            case "06" :
                $array[2] = "6";
                break;
            case "07" :
                $array[2] = "7";
                break;
            case "08" :
                $array[2] = "8";
                break;
            case "09" :
                $array[2] = "9";
                break;
        }
        //trasformo i mesi da numeri in stringe (es. 1 diventa Gennaio)
        switch($array[1]) {
            case "01" :
                $array[1] = "Gennaio";
                break;
            case "02" :
                $array[1] = "Febbraio";
                break;
            case "03" :
                $array[1] = "Marzo";
                break;
            case "04" :
                $array[1] = "Aprile";
                break;
            case "05" :
                $array[1] = "Maggio";
                break;
            case "06" :
                $array[1] = "Giugno";
                break;
            case "07" :
                $array[1] = "Luglio";
                break;
            case "08" :
                $array[1] = "Agosto";
                break;
            case "09" :
                $array[1] = "Settembre";
                break;
            case "10" :
                $array[1] = "Ottobre";
                break;
            case "11" :
                $array[1] = "Novembre";
                break;
            case "12" :
                $array[1] = "Dicembre";
                break;
        }
        //creo la stringa con la data in italiano
        $itDate = $array[2] . " " . $array[1] . " " . $array[0]." <span>alle ore</span> ". substr($array2[1],0,5);
        return $itDate;
    }
    
    if(!isset($_SESSION['loggedin'])){
        header('location: login.php?error=1');
    }
    
    if(!isset($_POST['idUser']) OR !isset($_POST['n'])){
        die("KO");
    }
    
    include("includes/mysqlclass.class.php");
    
    $mysql = new MySqlClass();
    $mysql->connect();
    
    $query = "SELECT idDoor, name, surname, pic, idPost, date, content FROM posts,openedDoors,users WHERE openedDoors.idDoor = posts.idUser AND openedDoors.idDoor = users.idUser AND openedDoors.idUser = ".$_POST['idUser']." AND accepted = 1 AND posts.idOwner IS NULL ORDER BY idPost DESC LIMIT ".$_POST['n'].",10";
    
    $result = $mysql->query($query);
    
    if(mysql_num_rows($result)<1)
        die("nomore");
        
    while($homePost = mysql_fetch_array($result)){
        echo '
        <div class="postBlock">
        <div class="inner">
        <div class="textarea">
        <div class="post">
        <div class="date">
        '.data_it($homePost['date']).'
        </div>
        <p>
        <span class="owner"><a href="room.php?id='.$homePost['idDoor'].'">'.utf8_encode($homePost['name']).' '.utf8_encode($homePost['surname']).'</a></span> scrive:
        <br />
        '.utf8_encode($homePost['content']).'
        </p>
        </div>
        </div>
        </div>
        <div class="sidebar">
        <a href="room.php?id='.$homePost['idDoor'].'">';
        if($homePost['pic']==0)
        echo '<img src="./css/img/profile_photo.png">';
        else
        echo '<img src="./photos/'.$homePost['idDoor'].'.jpg?imm='.rand(0,99999).'">';
        echo '</a>
        </div>
        <div class="divFooter">
        <a href="post.php?id='.$homePost['idPost'].'">Commenta</a>
        </div>
        </div>
        ';
        }
    ?>
