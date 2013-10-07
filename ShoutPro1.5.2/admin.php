<?php
/*
ShoutPro 1.5 - admin.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is admin.php.  It is the basic admin panel.
*/

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("include.php");

function compareVersions($latest,$current){
	if (($latest[0] > $current[0]) || ($latest[0] == $current[0] && $latest[1] > $current[1]) || ($latest[0] == $current[0] && $latest[1] == $current[1] && $latest[2] > $current[2]))	return -1;
	else if (($latest[0] < $current[0]) || ($latest[0] == $current[0] && $latest[1] < $current[1]) || ($latest[0] == $current[0] && $latest[1] == $current[1] && $latest[2] < $current[2]))	return 1;
	else return 0;
}
?>

<html><head>
<title>ShoutPro Admin</title>
<link rel="stylesheet" href="<?=$theme ?>" type="text/css" />
</head>
<body>
<div align="center" style="font-size:20pt">ShoutPro Admin</div><br />
<div align="center" style="font-size:10pt">

<?php
	
//Shoutbox clearing
if($_GET["action"]=="clear" && $_POST["password"]==$thepassword){
   $FilePointer=fopen("shouts.php", "w+");
   echo("Shoutbox cleared.");
} else if($_GET["action"]=="clear" && $_POST["password"]!=$thepassword){ 
	echo("Wrong password!");
} else {
	echo("<form name='clear' method='post' action='admin.php?action=clear'>To clear the shoutbox, please enter your password as specified in config.php: <input type='password' name='password' size='10'><input type='submit' value='Submit'></form>");
}
?>

<br /><br /><div align="center"><a href="documentation/">Click here to view ShoutPro documentation.</a></div><br />
Version checking below.  This may take a while to load...<br /><br >
<?php
	//Version checking
	if ($latestr = @trim(file_get_contents("http://www.shoutpro.com/latest_stable"))){
		$latest = explode(".",$latestr);
		$current = explode(".",$version);
		$flag = false;
		if (compareVersions($latest,$current) == -1)
			echo "<div style='font-weight:bold;color:red'>You are using an outdated version of ShoutPro!  You are using version <em>$version</em> and the latest stable version is <em>$latestr</em>.<br /><a href='http://shoutpro.com'>Click here to go to shoutpro.com and download the latest version.</a></div><br />";
		else if (compareVersions($latest,$current) == 0)
			echo "You are running the latest stable version of ShoutPro.<br /><br />";
	} else echo "<div style='font-weight:bold;color:red'>ERROR: Version check failed.  Shoutpro.com may be down.</div><br />";
	
	//Testing version checking
	if ($latestrt = @trim(file_get_contents("http://www.shoutpro.com/latest_testing"))){		
		$latestt = explode(".",$latestrt);
		if (compareVersions($latestt,$latest) == -1){
			$current = explode(".",$version);
			$flag = false;
			if (compareVersions($latestt,$current) == -1)
				echo "<div style='font-weight:bold;'>A new public testing version of ShoutPro is available.  You are using version <em>$version</em> and the latest testing version is <em>$latestr</em>.<br /><a href='http://shoutpro.com'>If you would like to test this new version, click here to go to shoutpro.com and download it.</a></div><br />";
			else if (compareVersions($latestt,$current) == 0)
				echo "You are running the latest testing version of ShoutPro.<br /><br />";
			else
				echo "Wow, you're running a version of ShoutPro that is newer than the latest testing version.  Strange...<br /><br />";
		}
	} else echo "<div style='font-weight:bold;color:red'>ERROR: Testing version check failed.  Shoutpro.com may be down.</div><br />";
/* Start Copyright Text - Do not remove! */
copyrighttext();
/* End Copyright Text - Do not remove! */
?>
</body></html>