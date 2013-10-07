<?php

/*
ShoutPro 1.5 - User Panel - register.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is register.php.  It is part of the User Panel addon to ShoutPro.  There is no need to modify anything in this file.  All modifications should be done in the file upconfig.php.
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
<link rel="stylesheet" href="<?=$path."/".$theme ?>" type="text/css" /></head>
<body>
You are about to register a username.  Registering a username will allow you to add a password to it and prevent others from using it.  Your e-mail will be used to retrieve and change your password.<p>
<form name="register" action="doregister.php" method="POST">
<?php
if (!$_COOKIE['shoutpro_username']){
	echo("Name to Register: <input class='textbox' name='name' type='text' size='10' value=''><br />\n"); 
} else {
	echo("Name to Register: <input class='textbox' name='name' type='text' size='10' value='".$_COOKIE['shoutpro_username']."'><br />\n"); 
	}
?>
Password: <input class='textbox' type="password" name="enterpass"><br />
Confirm: <input class='textbox' type="password" name="confpass"><br />
Email: <input class='textbox' type="text" name="enteremail"><br />
Confirm: <input class='textbox' type="text" name="confemail"><br />
<input class='textbox' type='submit' value='Register'>
</form>
<p><a href="index.php">User Panel Home</a>::<a href="javascript:window.close()">Close Window</a>