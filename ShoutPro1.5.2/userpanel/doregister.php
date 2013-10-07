<?php
/*
ShoutPro 1.5 - User Panel - doregister.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is doregister.php.  It is part of the User Panel addon to ShoutPro.  There is no need to modify anything in this file.  All modifications should be done in the file upconfig.php.
*/

//upconfig.php is essential for using this addon script.
require("upconfig.php");

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("$path/include.php");

if ($userpanelon != "yes"){
	die ("Sorry the user panel has not been enabled in config.php");
}
?>


<html><head><title>Register your Name</title>

<link rel="stylesheet" href="<?=$path."/".$theme ?>" type="text/css" /></head><body>



<?php
$pass = $_POST["enterpass"];
$_POST["enterpass"] = md5($_POST["enterpass"]);
$_POST["confpass"] = md5($_POST["confpass"]); 

if(!$_POST["name"] || !$_POST["enterpass"] || !$_POST["confpass"] || !$_POST["enteremail"] || !$_POST["confemail"]){
	echo ("Sorry, you must fill out all fields.  <a href='javascript:history.back()'>Go back and try again.</a>");
} else if($_POST["enterpass"] != $_POST["confpass"]){
	echo ("Both passwords don't match. <a href='javascript:history.back()'>Go back and try again.</a>");
} else if($_POST["enteremail"] != $_POST["confemail"]){
	echo ("Both emails don't match.   <a href='javascript:history.back()'>Go back and try again.</a>");
} else if(strlen($_POST["name"]) < $nameminlength){
	echo ("Sorry, your name must be no less than $nameminlength characters long. <a href='javascript:history.back()'>Go back and try again.</a>");
} else if(strlen($_POST["name"]) > $namemaxlength){ 
	echo ("Sorry, your name must be no more than $namemaxlength characters long. <a href='javascript:history.back()'>Go back and try again.</a>");
} else if($check1 = thecheck($_POST["name"]) || $check2 = thecheck($_POST["enterpass"]) || $check3 = thecheck($_POST["enteremail"])){
	echo ("It looks like you've used the string\"|^|\" in your username, password, or e-mail.  You can't do that.   <a href='javascript:history.back()'>Go back and try again.</a>");
} else {
	$FileName=$path."/lists/names.php";
	$list = file ($FileName);
	foreach ($list as $value) {
		list ($restrictedname,$namepass,$nameemail) = explode ("|^|", $value);
		$_POST["name"] = strtolower($_POST["name"]);
		if ($_POST["name"] == strtolower($restrictedname)){
				$rname=1;
		}
	}
	if ($rname == 1){
		echo ("Sorry, that name has already been taken. <a href='javascript:history.back()'>Go back and try again.</a>");
	} else {
		$FileName = $path."/lists/names.php";
		$list = file($FileName);
		$newitem = $_POST["name"]."|^|".$_POST["enterpass"]."|^|".$_POST["enteremail"]."|^|";
		$FilePointer = fopen($FileName, "a+");
		fwrite($FilePointer, "\n".$newitem);
		fclose($FilePointer);
		echo ("Name added.");
		mail($enteremail,"Shoutbox Username and Password","This e-mail is being sent from $shoutboxname at $sitename.  Your username and password for $siteurl are ".$_POST["name"]." and ".$pass.".  Please keep this e-mail for your reference.","From: $siteemail");
	}
}
?>
<p><a href="index.php">User Panel Home</a>::<a href="javascript:window.close()">Close Window</a>