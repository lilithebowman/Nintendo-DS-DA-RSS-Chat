<?php

/*
ShoutPro 1.5.2 - shoutbox.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is shoutbox.php.  It is the main part of ShoutPro.  Do not modify this file unless you know what you're doing.  Simple customization should be done in config.php and your .css stylesheet.
*/

if ($_POST["action"]!="")		$action = $_POST['action'];	
else if ($_GET["action"]!="")	$action = $_GET["action"];

if ($_POST["name"]!="")			$name = $_POST['name'];
else if ($_GET["name"]!="")		$name = $_GET["name"];

if ($_POST["pass"]!="")			$pass = $_POST['pass'];
else if ($_GET["pass"]!="")		$pass = $_GET["pass"];

if ($_POST["shout"]!="")		$shout = $_POST['shout'];
else if ($_GET["shout"]!="")	$shout = $_GET["shout"];


//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("include.php");

//Generate an array of password protected names, to be transferred to JavaScript later.
$restricted_names = array();
$index = 0;
$FileName="lists/names.php";
$list = file ($FileName);
foreach ($list as $value) {
	list ($restrictedname,$namepass,$nameemail,) = explode ("|^|", $value);
	$restricted_names[$index] = trim(strtolower($restrictedname));	
	$index++;
}

extract($HTTP_REQUEST_VARS); //Extract all GET and POST variables to avoid annoying errors on strangely configured machines.

if($action == "post" && $name && $name != "Name"){
		//Prepare the name
		$shout = trim($shout);
		$shout = stripslashes($shout);
		$shout = str_replace ("\n", " ", $shout);
		$shout = str_replace ("\r", " ", $shout);
		$name = trim($name);
		$name = killhtml(killscript($name));
		restrictedname($name,$pass);
		//Store username in a cookie
		setcookie("shoutpro_username", "", time() - 31536000);
		$cookielife = time() + 31536000;
		setcookie("shoutpro_username", $name, $cookielife);
}
?>

<html><head><title><?=$shoutboxname ?></title>
<link rel="stylesheet" href="<?=$theme ?>" type="text/css" />
<style type="text/css">.shout {overflow: hidden;}</style>
<SCRIPT language="JavaScript">
function reload() { 
   var loc = "shoutbox.php?";
   if (document.getElementById('moreshouts').style.display == 'inline')
		loc += "viewall=true&";
	<? if ($userpanelon == "yes"){ ?>
   if (document.getElementById('userpaneloff').style.display == 'inline')
		loc += "userpanelon=true&";
	<? } ?>
	location.href = loc;
} 

function checkrname() {
	//This function is called after a name is entered in the form field, and checks if it is registered.
	//If it is, it alerts the user, shows the password box, and focus on it.
	//If not, it focus on the shout textarea.
	var isin = false;
	if (document.getElementById('name').value != ""){
		for (var i = 0; i < namesarray.length; i++){
			if (namesarray[i] == document.getElementById('name').value.toLowerCase()){
				alert("You have entered a registered name.  Please provide the password.");
				document.getElementById('passwordfield').style.display = 'inline';
				document.getElementById('pass').focus();
				isin = true;
			}
		}
	}
	if (isin == false){
		document.getElementById('passwordfield').style.display = 'none';
		document.getElementById('shout').focus();
		document.getElementById('shout').select();
		return false;
	}
	else return true;
}

function CheckForm(){
	//Check if a name has been entered
	if (document.getElementById('name').value == "" || document.getElementById('name').value == "Name"){
		alert("<?=$inputname ?>");
		document.getElementById('name').focus();
		document.getElementById('name').select();
		return false;
	}
	
	//Check if a shout has been entered
	if (document.getElementById('shout').value == "" || document.getElementById('shout').value == "Shout!"){
		alert("<?=$inputshout ?>");
		document.getElementById('shout').focus();
		document.getElementById('shout').select();
		return false;
	}
	
	return true ;
}

function doviewall() {
	//Make the rest of the shouts viewable
	document.getElementById('moreshouts').style.display = 'inline';
	document.getElementById('viewall').style.display = 'none';
	document.getElementById('viewless').style.display = 'inline';
}

function doviewless() {
	//Hide more shouts
	document.getElementById('moreshouts').style.display = 'none';
	document.getElementById('viewall').style.display = 'inline';
	document.getElementById('viewless').style.display = 'none';
}

function openhelp() {
	//Pop up the help window
	window.open('help.php','help_window','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=270,height=400')
}

function stoptmr(){ 
	if(tmron){ 
		clearTimeout(timerID); 
		tmron = false; 
	}
} 

function starttmr(){ 
   stoptmr(); 
   timerID = setTimeout('reload()', <?=$refresh ?>000); 
   tmron = true; 
} 

var tmron = false;
var tmrid;
<? if($refreshmode != "manual")	echo("starttmr();"); ?>

var namesarray = new Array("<?=implode('","', $restricted_names); ?>"); //Convert the PHP array of names to JavaScript for client-side access
</SCRIPT>

</head>
<body style="width: <?=$width ?>px !important;">
<?php

//The following code posts a message.
if($action=="post"){
	if (!$name)	echo("<script>alert(\"".$inputname."\");</script>");
	else if (!$shout || $shout=="Shout!")	echo("<script>alert(\"".$inputshout."\");</script>");
	else {
		//Prepare the shout
		$shout = trim($shout);
		$shout = stripslashes($shout);
		$shout = str_replace ("\n", " ", $shout);
		$shout = str_replace ("\r", " ", $shout);
		badname($name);
		if(!namelength($name,$nameminlength,$namemaxlength)) die();  //Check length of name to min and max lengths
		$shout = first($shout);
		$name = first($name);
		if(!length($shout,$minlength,$maxlength)) die(); //Check length of shout to min and max lengths
		//Find the date and time
		$date = date("F j, Y", time() + $timeoffset * 3600);
		$time = date("g:i A", time() + $timeoffset * 3600);
		//Add the shout to the end of shouts.php
		if($FilePointer = fopen("shouts.php", "a+")){
			fwrite($FilePointer,"$name|^|$shout|^|$date|^|$time|^|$_SERVER[REMOTE_ADDR]|^|\n");
			fclose($FilePointer);
		}
	}
	echo("<script>location.href='shoutbox.php';</script>");
}

//Show the shoutbox name if selected
if ($displayname == "yes")	echo ("<div align=center><b>$shoutboxname</b><br /><br />");
//Show the form.
echo("<form name='postshout' method='post' action='shoutbox.php?action=post'>\n");
echo("<input id='name' class='textbox' name='name' type='text' value='");
if ($_COOKIE["shoutpro_username"])	echo $_COOKIE["shoutpro_username"];
else	echo "Name";
echo ("' onFocus=\"stoptmr()\" onBlur=\"checkrname();\"><br />\n"); 
if ($_COOKIE["shoutpro_username"] && in_array(strtolower($_COOKIE["shoutpro_username"]),$restricted_names))
	echo "<div id='passwordfield' style='display:inline'>";
else
	echo "<div id='passwordfield' style='display:none'>";
echo("<input class='textbox' name='pass' id='pass' type='password' value='' onBlur=\"if(this.value != ''){document.getElementById('shout').focus();document.getElementById('shout').select();}\" onFocus=\"stoptmr()\" /><br />\n</div><textarea id='shout' class=textbox name='shout' rows='5' onFocus=\"stoptmr()\">Shout!</textarea><br />\n");
echo("<div id='buttons'><input class=textbox type='submit' id='post' name='post' onFocus=\"this.select();\" value='Post' onclick='return CheckForm();'>\n");
if ($refreshmode != "auto")	echo("<input class=textbox type=button value='Refresh' onClick=\"reload()\">\n");
echo("</div></div>");
$row_count = 0;
//Display shouts
$shouts = file("shouts.php");
$shouts = array_reverse($shouts);
foreach ($shouts as $item){
	if ($row_count == $numshoutsdisplay){
		if ($_REQUEST["viewall"] == true)	echo "<div id='moreshouts' style='display:inline'>";
		else	echo "<div id='moreshouts' style='display:none'>";
		$viewalled = true; //We already displayed the viewall div
	}
	$row = ($row_count % 2) ? "one" : "two";
	list ($poster,$message,$date,$time,$ip) = explode ("|^|", $item);
	$thisnamecolor = "";
	$thisnamecolor = colornames($poster,$thisnamecolor);
	$message=profanityfilter(shoutcode(smilies(killhtml($message))));		
	$thisshout = "<span style='color: $thisnamecolor !important;' class='name'>$poster:</span> $message";
	$thisshout = killscript($thisshout);
	echo "<div class='shout' id='row-$row' title=\"Posted $date @ $time\">$thisshout</div>";
	$row_count++;
}

if (!$viewalled) echo "<div id='moreshouts' style='display:none'>";

echo "</div><br /><div id='bottomlinks'>";

if ($row_count > $numshoutsdisplay){
	if ($_REQUEST["viewall"] == true)	echo "<a href='shoutbox.php?viewall=true' onClick='doviewall();' style='display:none' id='viewall'>View All</a><a href='shoutbox.php' onClick='doviewless();' id='viewless'>View Less</a>::";
	else	echo "<a href='shoutbox.php?viewall=true' onClick='doviewall();' id='viewall'>View All</a><a href='shoutbox.php' onClick='doviewless(); ' style='display:none' id='viewless'>View Less</a>::";
}

echo "<a href=\"javascript:openhelp();\">Help</a>";

if($userpanelon == "yes")
	if ($_REQUEST["userpanelon"] == true) echo "<br /><a href='#' id='userpanelon' onClick=\"document.getElementById('userpanel').style.display='inline';document.getElementById('userpanelon').style.display='none';document.getElementById('userpaneloff').style.display='inline';\" style='display:none'>Open User Panel</a><a href='#' id='userpaneloff' onClick=\"document.getElementById('userpanel').style.display='none';document.getElementById('userpanelon').style.display='inline';document.getElementById('userpaneloff').style.display='none';\" style='display:inline'>Close User Panel</a>";
	else	echo "<br /><a href='#' id='userpanelon' onClick=\"document.getElementById('userpanel').style.display='inline';document.getElementById('userpanelon').style.display='none';document.getElementById('userpaneloff').style.display='inline';\">Open User Panel</a><a href='#' id='userpaneloff' onClick=\"document.getElementById('userpanel').style.display='none';document.getElementById('userpanelon').style.display='inline';document.getElementById('userpaneloff').style.display='none';\" style='display:none'>Close User Panel</a>";
?>
</div><br />
<div id='userpanel' style='display:<? if ($_REQUEST["userpanelon"] == true) echo "inline"; else echo "none"; ?>'>
<a href='#' onClick="window.open('userpanel/register.php','userpanel','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=400,height=400');">&nbsp;-->Register a Name</a><br />
<a href='#' onClick="window.open('userpanel/changepass.php','userpanel','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=400,height=400');">&nbsp;-->Change your Password</a><br />
<a href='#' onClick="window.open('userpanel/findpass.php','userpanel','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=400,height=400');">&nbsp;-->Reset your Password</a><br /><br />
</div>
<?php
/* Start Copyright Text - Do not remove! */
copyrighttext();
/* End Copyright Text - Do not remove! */
?>