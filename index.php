<?php
	if ( ! session_start() ) die('FATAL: session couldn\'t start!  Check configs/server disk space.');
	if (isset($_SESSION['name'])) {
		if ( ! strlen(trim($_SESSION['name'])) )
			unset($_SESSION['name']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ztpShout: your simple/flexible shoutbox!</title>
<link href="ztpShout.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
var holdLoop = false;
function getChats() {
	if (holdLoop==false) {
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET","<?php echo(basename(__FILE__).'?Get=Msg'); ?>",false);
		xmlhttp.send();
		xmlDoc=xmlhttp.responseXML;
		myChat=htmlDecode(xmlDoc.getElementsByTagName("chatCode")[0].childNodes[0].nodeValue);
		document.getElementById('chatView').innerHTML = myChat;
	}
}
function sendChat() {
	holdLoop = true;
	// TODO send chat text...
	
	holdLoop = false;
}
function chatLoop() {
	if (document.getElementById('chatView').innerHTML != 'Chat items unavailable, unauthenticated.') {
		setInterval(function() {
			getChats();
		},5000);
	}
}
function htmlDecode(value) {
	if (value) {
		return $('<div />').html(value).text();
	} else {
		return '';
	}
}
</script>
</head>
<body onload="chatLoop()">
<h1>Welcome to the Shoutbox!</h1>
<?php if (!isset($_SESSION['name'])) { ?>
<form action="index.php" method="POST">
Enter your name, please?<br />
<input type="text" name="name" /><br />
<br />
<input type="submit" name="Let's go!" value="Let's go!" />
</form>
<div id="chatView" style="visibility: hidden;">Chat items unavailable, unauthenticated.</div>
<?php } ?>
<?php if (isset($_SESSION['name'])) { ?>
<div id="chatView" style="visibility: visible;">Chat items loading, standby...</div>
<div id="chatSend" style="visibility: visible;">
	<form>
    <input type="text" name="cMessage" id="cMessage" style="width: 100%;" /><br />
    <input type="button" name="Send" value="Send" onclick="sendChat()" />
    </form>
</div>
<?php } ?>
</body>
</html>