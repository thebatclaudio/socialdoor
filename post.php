<?php
	session_start();
	
	if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1){
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];
		header("Location: login.php?error=1");
	}

	include "./includes/user.class.php";
	
	$user = new user($_SESSION['user']);
	
    if (!isset($_GET['id']) OR !is_numeric($_GET['id']))
        echo "<h3>Ops! Si &egrave; verificato un errore... Sicuro di aver inserito il link giusto?</h3>";
    else {
        include "./includes/post.class.php";
        include "./includes/mysqlclass.class.php";

        $mysql = new MySqlClass();
        $mysql -> connect();
        $idPost = trim($_GET['id']);
        $result = $mysql -> query("SELECT * FROM posts WHERE idPost = $idPost");
        if(mysql_num_rows($result)<1){
            include "header.php";
            echo '<div id="container">
            <div id="header">
                <div id="right">
                    <form action="search.php" method="post">
                        <input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
                    </form>
                </div>
                <div id="left">
                    <a href="home.php" title="Torna alla home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
                </div>
            </div>
            <div id="content" style="text-align: center"><h3>Ops! Si &egrave; verificato un errore... Sicuro di aver inserito il link giusto?</h3></div>';
			exit();
        }
        $post = mysql_fetch_object($result, 'post');
        
        $title = substr(html_entity_decode($post->getContent()),0,30)."... - SocialDoor";
        if($post->getIdOwner()!="")
            $id=$post->getIdOwner();
        else
            $id=$post->getIdUser();
        include "header.php";
?>
<div id="container">
    <div id="header">
        <div id="right">
            <form action="search.php" method="post">
                <input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
            </form>
        </div>
        <div id="left">
            <a href="home.php" title="Torna alla home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
        </div>
    </div>
<?php
    if ($user -> canIsee($post -> getIdUser()) == 1) {
        if ($post -> getIdOwner() != NULL) {
            $result = $mysql -> query("SELECT * FROM users WHERE idUser = " . trim($post -> getIdOwner()));
            $result2 = $mysql -> query("SELECT * FROM users WHERE idUser = " . trim($post -> getIdUser()));
            $roomOwner = new user(mysql_fetch_object($result2));
        } else
            $result = $mysql -> query("SELECT * FROM users WHERE idUser = " . trim($post -> getIdUser()));
        $owner = new user(mysql_fetch_object($result));
        echo '
    <div class="postBlock" style="margin-top: 40px">
        <div class="inner">
            <div class="textarea">
                <div class="post">
                    <div class="date">
                        ' . $post -> getDate();
        if ($owner -> getId() == $user -> getId()) {
            echo ' - <a href="deletePost.php?id=' . $post -> getId() . '" alt="Cancella questo post">Cancella</a>';
        }
        echo '
                    </div>
                    <p>
                        <span class="owner"><a href="room.php?id=' . $owner -> getId() . '">' . $owner -> getCompleteName() . '</a></span>';
        if (isset($roomOwner)) {
            echo ' > <span class="owner"><a href="room.php?id=' . $roomOwner -> getId() . '">' . $roomOwner -> getCompleteName() . '</a></span>';
        }
        echo ':
                        <br />
                        ' . $post -> getContent() . '
                    </p>
                </div>
            </div>
            <div id="allComments">
                ';

        include "./includes/comment.class.php";
        $result = $mysql -> query("SELECT * FROM comments WHERE idPost = $idPost ORDER BY idComment ASC");
        while ($obj = mysql_fetch_object($result, 'comment')) {
            $res = $mysql -> query("SELECT * FROM users WHERE idUser = " . $obj -> getIdUser());
            $commentUser = new user(mysql_fetch_object($res));
            echo '
                <div id="' . $obj -> getId() . '" class="commentBlock">
                    <div class="inner">
                        <div class="textarea">
                            <div class="post">
                                <div class="date">
                                    ' . $obj -> getDate();
            if ($obj -> getIdUser() == $user -> getId()) {
                echo ' - <a href="#" onClick="deleteComment(' . $obj -> getId() . ')">Cancella</a>';
            }
            echo '
                                </div>
                                <p>
                                    <span class="owner"><a href="room.php?id=' . $commentUser -> getId() . '">' . $commentUser -> getCompleteName() . ':</a></span>
                                    <br />
                                    ' . $obj -> getContent() . '
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar">
                        <a href="room.php?id=' . $commentUser -> getId() . '"><img src="';
            if ($commentUser -> getPic() == 1)
                echo "./photos/" . $commentUser -> getId() . ".jpg?imm=" . rand(0, 99999);
            else
                echo "./css/img/profile_photo.png";
            echo '"></a>
                    </div><div class="divFooter"></div>
                </div>
                ';
        }

        echo '
            </div>
            ';

        echo ' <h3>Inserisci un commento</h3>
            <div id="div"></div>
            <div class="commentBlock">
                <div class="inner">
                    <div class="textarea">
                        <form>
                            <textarea id="commentInput" style="width: 570px"></textarea>
<br />                            <input type="button" class="submit" onClick="commenta()" value="Commenta" />
                            <div id="warning"></div>
                        </form>
                    </div>
                </div>
                <div class="sidebar">
                    ';
        if ($user -> getPic() == 0)
            echo '<img src="./css/img/profile_photo.png">';
        else {
            echo '<img src="./photos/' . $user -> getId() . '.jpg?imm=' . rand(0, 99999) . '">';
        }
        echo '
                </div>
                <div class="divFooter"></div>
            </div>
        </div>
        <div class="sidebar">
            ';
        echo '<a href="room.php?id=' . $owner -> getId() . '" title="' . $owner -> getCompleteName() . '">';
        if (!$owner -> getPic())
            echo '<img src="./css/img/profile_photo.png">';
        else
            echo '<img src="./photos/' . $owner -> getId() . '.jpg?imm=' . rand(0, 99999) . '">';
        echo '</a>
        </div>
        ';
        echo '
    </div>
    ';
    } else {
        echo "Non puoi visualizzare questo post... Se conosci il proprietario, prova a bussare alla sua porta!";
    }
    }
    ?>
</div>
<script type="text/javascript">
	function deleteComment(id) {
		var oXHR = new XMLHttpRequest();
		var text = document.getElementById("allComments").innerHTML;
		oXHR.open("post", "deleteComment.php", true);
		oXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		oXHR.onreadystatechange = function() {
			if(oXHR.readyState == 4) {
				if(oXHR.responseText == 'OK') {
					jQuery("#" + id).fadeOut("slow");
				}
			}
		}
		var params = "id=" + id;
		oXHR.send(params);
	}
</script>
</body>
</html> 