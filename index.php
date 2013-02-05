<?php require_once('Connections/settings.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_GET['Put'])) {
	if ($_GET['Put']=='Msg') {
		mysql_select_db($database_settings, $settings);
		$query_theChats = "INSERT INTO ztpShout VALUES (".strval(time()).",'".mysql_real_escape_string($_GET['user'],$settings)."','".mysql_real_escape_string($_GET['Msg'],$settings)."')";
		mysql_query($query_theChats, $settings) or die(mysql_error());
		die('<ztpShout><gotMsg>OK</gotMsg></ztpShout>');
	}
}
if (isset($_GET['Get'])) {
	if ($_GET['Get']=='Msg') {
		mysql_select_db($database_settings, $settings);
		$query_theChats = "SELECT * FROM ztpShout ORDER BY `time` ASC";
		$theChats = mysql_query($query_theChats, $settings) or die(mysql_error());
		$outputs = '';
		while ($row_theChats = mysql_fetch_assoc($theChats)) {
			$outputs .= '<strong>';
			$outputs .= $row_theChats['user'];
			$outputs .= ':</strong>&nbsp;';
			$outputs .= $row_theChats['text'];
			$outputs .= '<br />';
		}
		//FIXME: crappy way to handle no messages yet!
		if ( ! mysql_num_rows($theChats) ) $outputs = 'There are no messages yet in the shoutbox!';
		header('Content-type: text/xml');
		die('<ztpShout><chatCode>'.htmlentities($outputs).'</chatCode></ztpShout>');
	}
}

if ( ! session_start() ) die('FATAL: session couldn\'t start!  Check configs/server disk space.');
if (isset($_POST['name']))
	if ( strlen(trim($_POST['name'])) )
		$_SESSION['name'] = $_POST['name'];
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
		myChat=xmlDoc.getElementsByTagName("chatCode")[0].childNodes[0].nodeValue;
		document.getElementById('chatView').innerHTML = myChat;
	}
}
function sendChat() {
	holdLoop = true;
	// TODO send chat text...
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","<?php echo(basename(__FILE__).'?Put=Msg&user='.rawurlencode($_SESSION['name']).'&Msg='); ?>"+document.getElementById('cMessage').value,false);
	document.getElementById('cMessage').value = '';
	xmlhttp.send();
	holdLoop = false;
	getChats();
}
function chatLoop() {
	if (document.getElementById('chatView').innerHTML != 'Chat items unavailable, unauthenticated.') {
		getChats();
		setInterval(function() {
			getChats();
		},5000);
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
	<form style="display: block; width: 100%; margin-top: 12px;">
    <input type="text" name="cMessage" id="cMessage" style="width: 100%;" /><br />
    <input type="button" name="Send" value="Send" onclick="sendChat()" />
    </form>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($theChats);
?>
