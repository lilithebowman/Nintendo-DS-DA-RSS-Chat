<?php
/*
ShoutPro 1.5.1 - User Panel - dofind.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is dofind.php.  It is part of the User Panel addon to ShoutPro.  There is no need to modify anything in this file.  All modifications should be done in the file upconfig.php.
*/

//upconfig.php is essential for using this addon script.
require("upconfig.php");

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("$path/include.php");

if ($userpanelon != "yes"){
	die ("Sorry the user panel has not been enabled in config.php");
}
?>


<html><head><title>Reset your Password</title>
<link rel="stylesheet" href="<?=$path."/".$theme ?>" type="text/css" />
</head>
<body>

<?php

$_POST["name"] = strtolower($_POST["name"]); //Added in 1.5.1

if(!$_POST["name"] || !$_POST["email"]){
	echo ("Sorry, you must fill out all fields.");
} else {
	$FileName=$path."/lists/names.php";
	$list = file ($FileName);
	$numnames = count($list);
	for($x=0;$x<=$numnames;$x++){
		$value = $list[$x];
		list ($restrictedname,$namepass,$nameemail) = explode ("|^|", $value);
		if ($_POST["name"] == $restrictedname && $_POST["email"] == $nameemail){
			$rname = 1;
			$thepass = $namepass;
			$email = $nameemail;
			$line = $x;
		}
	}	
		

	if ($rname == 1){
		//Create random password
		$pass = "";
		$salt = "abchefghjkmnpqrstuvwxyz0123456789";
		srand((double)microtime()*1000000); 
		for ($i=0;$i <= 7; $i++){
			$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
		}
		$md5pass = md5($pass);
		
		$FileName = $path."/lists/names.php";
		$list = file($FileName);
		$list[$line] = $_POST["name"]."|^|".$md5pass."|^|".$_POST["email"]."|^|";
		$FileName = $path."/lists/newnames.php";
		$FilePointer = fopen($FileName, "w+");
		for ($x=0;$x<=$numnames;$x++){
			fwrite($FilePointer,$list[$x]."\n");
		}
		fclose ($FilePointer);
		unlink($path."/lists/names.php");
		rename($path."/lists/newnames.php",$path."/lists/names.php");
		
		echo ("A new password has been sent to your e-mail.");
		mail($email,"Shoutbox Username and Password","This e-mail is being sent from $shoutboxname at $sitename.  Your password has been reset at the request of you or someone else through our web form.  Your username and password for $siteurl are now ".$_POST["name"]." and ".$pass.".  If you did not request this change, just go to the shoutbox and use this password to change it back to your old one.  This is the only place your new password has been displayed.  Please keep this e-mail for your reference.","From: $siteemail");



	} else	echo ("Sorry, we couldn't find an account with that name and email in our records.");
}
?>
<p><a href="index.php">User Panel Home</a>::<a href="javascript:window.close()">Close Window</a>