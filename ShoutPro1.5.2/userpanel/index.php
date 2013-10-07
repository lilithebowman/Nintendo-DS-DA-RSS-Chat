<?php

/*
ShoutPro 1.5 - User Panel - index.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is index.php.  It is part of the User Panel addon to ShoutPro.  There is no need to modify anything in this file.  All modifications should be done in the file upconfig.php.
*/

//upconfig.php is essential for using this addon script.
require("upconfig.php");

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("$path/include.php");

if ($userpanelon != "yes"){
	die ("Sorry the user panel has not been enabled in config.php");
}
?>


<html><head><title><?php echo("$sitename Shoutbox User Panel"); ?></title>
<link rel="stylesheet" href="<?=$path."/".$theme ?>" type="text/css" />
</head>
<body>

Welcome to the user panel for <?php echo($sitename); ?>'s shoutbox.  Please follow the links below to your desired location. <p>
<a href="register.php">Register a Name</a><br />
<a href="changepass.php">Change your Password</a><br />
<a href="findpass.php">Reset your Password</a>
<p><a href="javascript:window.close()">Close Window</a>