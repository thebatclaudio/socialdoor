<script>
                      function ringTheBell(){
var message = document.getElementById("warning");
message.innerHTML = "Attendere...";
var oXHR= new XMLHttpRequest();
oXHR.open("post","ringTheBell.php",true);
oXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
oXHR.onreadystatechange = function() {
if(oXHR.readyState == 4) {
if (oXHR.responseText == 'OK')
{
message.innerHTML = "<h3 id='ok'>Hai suonato il campanello!</h3>";
}
else
{
message.innerHTML = "<h3>Si &egrave; verificato un errore. Riprovare</h3>";
}
}
}
var params = "idUser=<?php echo $user->getId(); ?>&idDoor=<?php echo $id ?>&message="+document.getElementById('message').value;
    oXHR.send(params);
    }
        </script>
        
        <script>
                      function sendMessage(){
var message = document.getElementById("sendMessageWarning");
message.innerHTML = "<h3>Attendere...</h3>";
var oXHR= new XMLHttpRequest();
oXHR.open("post","sendMessage.php",true);
oXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
oXHR.onreadystatechange = function() {
if(oXHR.readyState == 4) {
if (oXHR.responseText != 'KO')
{
message.innerHTML = "<h3 id='ok'>Hai mandato il messaggio!</h3>";
closePopupSendMessage();
var text = document.getElementById("lastpostsContent");
text.innerHTML = oXHR.responseText+text.innerHTML;
}
else
{
message.innerHTML = "<h3>Si &egrave; verificato un errore. Riprovare</h3>";
}
}
}
var params = "idOwner=<?php echo $user->getId(); ?>&idUser=<?php echo $id ?>&postMessage="+document.getElementById('postMessage').value;
    oXHR.send(params);
    }
        </script>
        <script type="text/javascript">
            function commenta() {
                var message = document.getElementById("warning");
                message.innerHTML = "Attendi...";
                var oXHR = new XMLHttpRequest();
                var text = document.getElementById("allComments").innerHTML;
                oXHR.open("post", "comment.php", true);
                oXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                oXHR.onreadystatechange = function() {
                    if(oXHR.readyState == 4) {
                        if(oXHR.responseText != 'KO') {
                            if(text=="<h4>Nessun commento</h4>")
                                text="";
                            text += '<div id="lastcomment" class="commentBlock"><div class="inner"><div class="textarea"><div class="post"><div class="date">'+oXHR.responseText+'</div><p><span class="owner"><?php echo $user->getCompleteName(); ?>:</span><br />'+document.getElementById("commentInput").value+'</p></div></div></div><div class="sidebar"><img src="<?php if($user->getPic()==1) echo "./photos/".$user->getId().".jpg"; else echo "./css/img/profile_photo.png"; ?>"></div><div class="divFooter"></div></div>';
                            document.getElementById("allComments").innerHTML = text;
                            document.getElementById("commentInput").value="";
                            message.innerHTML = "";
                            location.href='#lastcomment';
                        } else {
                        message.innerHTML = oXHR.responseText;//"Si &egrave; verificato un errore. Riprovare";
                        }
                    }
                }
            var params = "idUser=<?php echo $user->getId(); ?>&idPost=<?php echo $_GET['id'] ?>&content="+document.getElementById("commentInput").value;
            oXHR.send(params);
    }
        
    function openPopupRingTheBell(){
    $('#dark').fadeIn('slow');
    
    $('#ringTheBell').animate({
        marginLeft : '90%'
    }, 800);
}
    function closePopupRingTheBell(){
    $('#dark').fadeOut('slow');
    
    $('#ringTheBell').animate({
        marginLeft : '-30%'
    }, 800);
}

    function openPopupSendMessage(){
    $('#dark').fadeIn('slow');
    
    $('#sendMessage').animate({
        marginRight : '90%'
    }, 800);
}
    function closePopupSendMessage(){
    $('#dark').fadeOut('slow');
    
    $('#sendMessage').animate({
        marginRight : '-30%'
    }, 800);
}
        </script>