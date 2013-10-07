<?php
/*
ShoutPro 1.5.1 - User Panel - dochange.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is dochange.php.  It is part of the User Panel addon to ShoutPro.  There is no need to modify anything in this file.  All modifications should be done in the file upconfig.php.
*/

//upconfig.php is essential for using this addon script.
require("upconfig.php");

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("$path/include.php");

if ($userpanelon != "yes"){
	die ("Sorry the user panel has not been enabled in config.php");
}
?>


<html><head><title>Change your Password</title>
<link rel="stylesheet" href="<?=$path."/".$theme ?>" type="text/css" />
</head>
<body>
<?php

$_POST["name"] = strtolower($_POST["name"]); //Added in 1.5.1

$_POST["oldpass"] = md5($_POST["oldpass"]);
$upass = $_POST["newpass1"];
$_POST["newpass1"] = md5($_POST["newpass1"]);
$pass = $_POST["newpass1"];
$_POST["newpass2"] = md5($_POST["newpass2"]);
if(!$_POST["name"] || !$_POST["oldpass"] || !$_POST["newpass1"] || !$_POST["newpass2"]){
	echo ("Sorry, you must fill out all fields.");
} else if($_POST["newpass1"] != $_POST["newpass2"]){
	echo ("Both new passwords don't match.  Please try again.");
} else if($check1 = thecheck($_POST["newpass1"])){
	echo ("It looks like you've used the string\"|^|\" in your new password.  You can't do that.  Sorry.");
} else {
	$FileName=$path."/lists/names.php";
	$list = file ($FileName);
	$numnames = count($list);
	for($x=0;$x<=$numnames;$x++){
		$value = $list[$x];
		list ($restrictedname,$namepass,$nameemail) = explode ("|^|", $value);
		if ($_POST["name"] == $restrictedname){
			$rname = 1;
			$email = $nameemail;
			$line = $x;
		}
		if ($_POST["oldpass"] == $namepass){
			$rpass = 1;
		}
		if ($rname == 1 && $rpass == 1){
			$rgo = 1;
		}
	}	
		
//	foreach ($list as $value) {

//	}
	if ($rgo == 1){
		$FileName = $path."/lists/names.php";
		$list = file($FileName);
		$list[$line] = $_POST["name"]."|^|".$_POST["newpass1"]."|^|".$email."|^|";
		$FileName = $path."/lists/newnames.php";
		$FilePointer = fopen($FileName, "w+");
		for ($x=0;$x<=$numnames;$x++){
			fwrite($FilePointer,$list[$x]."\n");
		}
		fclose ($FilePointer);
		unlink($path."/lists/names.php");
		rename($path."/lists/newnames.php",$path."/lists/names.php");
		echo ("Password changed.");
		mail($email,"Shoutbox Username and Password","This e-mail is being sent from $shoutboxname at $sitename.  Your password has been changed.  Your username and password for $siteurl are now ".$_POST["name"]." and ".$upass.".  Please keep this e-mail for your reference.","From: $siteemail");


	} else if ($rname == 0) {
		echo ("That name doesn't appear to be registered yet.");
	} else {
		echo ("Sorry, the old password you entered doesn't match the current one for that username.");
	}
}
?>
<p><a href="index.php">User Panel Home</a>::<a href="javascript:window.close()">Close Window</a>