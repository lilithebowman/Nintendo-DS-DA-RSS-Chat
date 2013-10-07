<?php

/*
ShoutPro 1.5 - include.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is include.php.  It is required to run ShoutPro, calling the settings and functions and using IP banning.  There is no need to modify anything in this file.  All modifications should be done in the file config.php.
*/

include("config.php");
include("functions.php");

error_reporting(4);

if ($path)	$ips = file("$path/lists/bannedips.php");
else		$ips = file("lists/bannedips.php");

foreach($ips as $ip)
	if ($_SERVER["REMOTE_ADDR"] == trim($ip)){
		echo $bannedmessage;
		die;
	}

?>