<?php
    session_start();
    
    if(!isset($_SESSION['loggedin'])){
        header('location: login.php?error=1');
    }
    
    if(!isset($_POST['idUser']) OR !isset($_POST['n'])){
        die("KO");
    }
    
    include("includes/mysqlclass.class.php");
    include("includes/user.class.php");
    include("includes/post.class.php");
    
    $mysql = new MySqlClass();
    $mysql->connect();
    
    $result = $mysql->query("SELECT * FROM users WHERE idUser = '".$_POST['idUser']."'");
    $owner = new user(mysql_fetch_object($result));
    
    $result = $mysql -> query("SELECT * FROM posts WHERE idUser = " . $_POST['idUser'] . " ORDER BY idPost DESC LIMIT ".$_POST['n'].",5");
                
           if(mysql_num_rows($result)<1){
               die("nomore");
           }     
                
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
<span><a href="room.php?id='.$postOwner->getId().'">'.utf8_encode($postOwner -> getCompleteName()) . "</a></span><br /><p> ". utf8_encode(nl2br($post -> getContent())) . '
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
<span><a href="room.php?id='.$owner->getId().'">'.utf8_encode($owner -> getCompleteName()) . '</a></span><br /><p>
' . utf8_encode(nl2br($post -> getContent())) . '
</p>
</div>
</div>
</div>
<div class="sidebar">';
                        if ($owner -> getPic() == 1)
                            echo '<img src="./photos/' . $owner -> getId() . '.jpg?imm='.rand(0,99999).'">';
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
