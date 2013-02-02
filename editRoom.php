<?php
    session_start();
    
    if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
        header('location: login.php?error=1');
    
    include "./includes/mysqlclass.class.php";
    include "./includes/user.class.php";
    include "./includes/post.class.php";
    include "./includes/room.class.php";
    
    $user = new user($_SESSION['user']);
    $mysql = new MySqlClass();
    $mysql->connect();
    $result = $mysql->query("SELECT * FROM rooms WHERE idUser = ".$user->getId());
    $room = mysql_fetch_object($result,'room');
    
    $id=$user->getId();
    $title = "Modifica la tua stanza - SocialDoor";
    include "header.php";
?>
<div id="edit">
<form action="saveRoom.php" method="post" style="margin: 0; padding: 0; color: white;">
    Colore di sfondo:
    <input type="text" value="<?php if($room->getBg()=="url('./css/img/bg.jpg) repeat") echo "#000"; else echo $room->getBg(); ?>" name="bgColor" id="bgColor" class="color-picker" size="6" autocomplete="on" maxlength="10" style="display: none" />
 - Colore del testo:
    <input type="text" value="<?php echo $room->getTextColor1(); ?>" name="textColor1" id="textColor1" class="color-picker" size="6" autocomplete="on" maxlength="10" style="display: none" />
 - Colore dei titoli:
    <input type="text" value="<?php echo $room->getTextColor2(); ?>" name="textColor2" id="textColor2" class="color-picker" size="6" autocomplete="on" maxlength="10" style="display: none" />
 - Sfondo dei post:
    <input type="text" value="<?php echo $room->getBgPost(); ?>" name="bgPost" id="bgPost" class="color-picker" size="6" autocomplete="on" maxlength="10" style="display: none" />
 - <a href="uploadBg.php">Carica un'immagine di sfondo</a>    
    <input type="submit" class="submit" value="Salva" style="float: right; width: 80px; margin: 0; padding: 0; margin-right: 100px;" id="saveroom" />
</form>
</div>
<div id="container" style="padding-top: 80px">
    <div id="header">
        <div id="right">
            <form action="search.php" method="post" style="margin-top: 10px;">
                <input type="text" id="search" name="search" placeholder="Cerca...">
            </form>
        </div>
        <div id="left">
            <h3>Stanza di</h3>
            <h1><?php echo $user -> getCompleteName();?></h1>
        </div>
        <div id="divFooter"></div>
    </div>
    <div id="userInfo">
        <div id="userInfoRight">
            <ul>
                <li>
                    Nome: <?php echo $user -> getCompleteName();?>
                </li>
                <li>
                    Nat<?php
                    if ($user -> getSex() == 1)
                        echo "o";
                    else
                        echo "a";
                    ?>
                    il: <?php echo $user -> getBirthday();?>
                </li>
                <li>
                    Vive a: <?php echo "<a href='http://maps.google.it/maps?hl=it&q=" . $user -> getCity() . "' target='_blank'>" . $user -> getCity() . "</a>";?>
                </li>
                <?php if($user -> getRelationship() != NULL) echo '<li>Situazione sentimentale: '.$user -> getRelationship().'</li>';
                if($user -> getWork() != NULL) echo '<li>Lavoro: '.$user -> getWork().'</li>';
                if($user -> getWebsite() != 'http://') echo '<li>Sito web: <a href="'.$user -> getWebsite().'">'.$user -> getWebsite().'</a></li>'; ?>
            </ul>
            <div id="buttons">
                <input id="ringTheBellButton" type="button" class="doorBell" value="Pulsante" />
            </div>
        </div>
        <div id="userInfoLeft">
            <?php
            if ($user -> getPic() == 1)
                echo '<img src="./photos/' . $user -> getId() . '.jpg?imm='.rand(0,99999).'" style="border: 1px solid #999">';
            else
                echo '<img src="./css/img/profile_photo.png" style="border: 1px solid #999">';
            ?>
        </div>
        <div class="divFooter"></div>
    </div>
    <div id="lastposts">
        <h2>Ultimi post di <?php echo $user -> getName();?></h2>
        <div id="div"></div>
        <div id="lastpostsContent">
            <?php
                            $result = $mysql -> query("SELECT * FROM posts WHERE idUser = " . $user -> getId() . " ORDER BY idPost DESC LIMIT 0,6");
                while ($post = mysql_fetch_object($result, 'post')) {   
                    if ($post -> getIdOwner()!=NULL) {
                        $postOwnerResult = $mysql -> query("SELECT * from users WHERE idUser = ".$post->getIdOwner());
                        $postOwner = new user(mysql_fetch_object($postOwnerResult));    
                        echo '<div class="postBlock">
<div class="inner">
<div class="textarea">
<div class="post">
<div class="date">
' . $post -> getDate() . '
</div>
<span><a href="room.php?id='.$postOwner->getId().'">'.$postOwner -> getCompleteName() . "</a></span><br /><p> ". $post -> getContent() . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($postOwner -> getPic() == 1)
                            echo '<img src="./photos/' . $postOwner -> getId() . '.jpg?imm='.rand(0,99999).'">';
                        else
                            echo '<img src="./css/img/profile_photo.png">';
                        echo '</div>
<div class="divFooter">
<a href="post.php?id=' . $post -> getId() . '">Leggi tutto</a>
</div>
</div>';
                    } else {
                        echo '<div class="postBlock">
<div class="inner">
<div class="textarea">
<div class="post">
<div class="date">
' . $post -> getDate() . '
</div>
<span><a href="room.php?id='.$user->getId().'">'.$user -> getCompleteName() . '</a></span><br /><p>
' . $post -> getContent() . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($user -> getPic() == 1)
                            echo '<img src="./photos/' . $user -> getId() . '.jpg?imm='.rand(0,99999).'">';
                        else
                            echo '<img src="./css/img/profile_photo.png">';
                        echo '</div>
<div class="divFooter">
<a href="post.php?id=' . $post -> getId() . '">Leggi tutto</a>
</div>
</div>';
                    }
                }
            ?>
        </div>
    </div>
</div>
</body> </html>