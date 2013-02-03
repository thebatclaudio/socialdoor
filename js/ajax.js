var first=true;
var title = document.title;
function refresh()
{
	var oXHR = new XMLHttpRequest();
	oXHR.open("get", "getNotifications.php", true);
	oXHR.onreadystatechange = function() {
		if(oXHR.readyState == 4){
			if(oXHR.status == 200){
				if(oXHR.responseText!=0)
				{
					document.getElementById("notifications").innerHTML = "("+oXHR.responseText+")";
					document.getElementById("notificationsName").innerHTML = "("+oXHR.responseText+")";
					document.title = "(" + oXHR.responseText + ") " + title;
					document.getElementById("newNotif").setAttribute("style","display: block");
					if(oXHR.responseText>1)
					{
						document.getElementById("newNotif").innerHTML = "Hai "+oXHR.responseText+" nuove notifiche. <a href='notifications.php' id='readNotif'>Leggi</a>";
					}
				}
			} else {
				if(first) {
					document.getElementById("notifications").innerHTML = "";
				}
			}
			first = false;
			setTimeout("refresh()",2*1000);
		}
		
	}
	oXHR.send(null);
}

function init()
{
	setTimeout("refresh()",0);
}
