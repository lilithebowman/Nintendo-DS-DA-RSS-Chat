<?php

/*
ShoutPro 1.5 - functions.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is functions.php.  It contains functions essential to ShoutPro.  There is no need to modify this file.
*/

require("config.php");

function copyrighttext(){
	global $version;
	echo "<div class='copyrighttext'><a href='http://www.shoutpro.com' target='_blank'>Powered by ShoutPro $version</a></div>";
}

function length($shout,$minlength,$maxlength){
	if (strlen($shout) < $minlength){
		echo ("	<script language='JavaScript'>\n
				alert('Sorry, your shout must be at least $minlength characters long.');\n
				location.href='shoutbox.php';\n
				</script>");
		return false;
	} else if ((strlen($shout) > $maxlength) && ($maxlength != 0)) {
		echo ("	<script language='JavaScript'>\n
				alert('Sorry, your shout must be nore more than $maxlength characters long.');\n
				location.href='shoutbox.php';\n
				</script>");
		return false;
	} else {
		return true;
	}
}

function namelength($name,$nameminlength,$namemaxlength){
	if (strlen($name) < $nameminlength){
		echo ("	<script language='JavaScript'>\n
				alert('Sorry, your name must be at least $nameminlength characters long.');\n
				location.href='shoutbox.php';\n
				</script>");
		return false;
	} else if ((strlen($name) > $namemaxlength) && ($namemaxlength != 0)) {
		echo ("	<script language='JavaScript'>\n
				alert('Sorry, your name must be nore more than $namemaxlength characters long.');\n
				location.href='shoutbox.php';\n
				</script>");
		return false;
	} else {
		return true;
	}
}

function badname($name){
	$name = strtolower($name);
	$badnames = file("lists/badnames.php");
	foreach($badnames as $value) {
	  list($badname) = explode ("|^|",$value);
		if($name == strtolower($badname)) {
			include ("config.php");
			echo "<script>alert('$badnamemessage');\n";
			echo "location.href='shoutbox.php';</script>";
			exit;
		}
	}
}

function thecheck($value){
	if (str_replace("|^|","|*|",$value)!=$value){
		return TRUE;
	} else {
		return FALSE;
	}
}

function first($shout){
	$shout = str_replace("|^|","|*|",$shout);
	return $shout;
}

function killhtml($shout){
	//This function searches the shout for HTML tags and replaces them with the actual symbol.
	$shout = str_replace("<","&lt;",$shout);
	$shout = str_replace(">","&gt;",$shout);
	return $shout;
}

function killscript($value){
	$value = str_replace("<script>"," ",$value);
	$value = str_replace("</script>"," ",$value);
	$value = str_replace("javascript://","Sorry, no JavaScript allowed.",$value);
	return $value;
}

function shoutcode($shout){
	//This function parses the ShoutCode.
	$FileName="lists/shoutcode.php";
	$list = file ($FileName);
	foreach ($list as $value) { //Go through each ShoutCode tag.
		list ($opencode,$openhtml,$closecode,$closehtml) = explode ("|^|", $value); //Get the variables from the text file
		if ($closecode == "")	$shout = str_replace ($opencode, $openhtml, $shout); //Parse tags with no closing tag
		
		//Find the number of times the opening and closing tags each appear.
		$opencount = substr_count(strtolower($shout),strtolower($opencode));
		$closecount = substr_count(strtolower($shout),strtolower($closecode));
		
		//If the counts aren't equal, we have an unclosed tag, so only parse if they're equal.
		if ($opencount == $closecount){ 
			$shout = str_replace ($opencode, $openhtml, $shout);
			$shout = str_replace ($closecode, $closehtml, $shout);
		} //Close if
	} //Close foreach loop
	return $shout;
}

function smilies($shout){
	//This function searches the shout for the smilies and replaces it with the image code.
	$FileName="lists/smilies.php";
	$list = file ($FileName);
	foreach ($list as $value) {
		list ($code,$image,) = explode ("|^|", $value);
		$shout = str_replace ($code, "<img src='smilies/".$image."'>", $shout);
	}
	return $shout;
}

function profanityfilter($shout){
	//This function filters profanities from the shout.
	$FileName="lists/profanities.php";
	$list = file ($FileName);
	foreach ($list as $value) {
		list ($profanity,$filter,) = explode ("|^|", $value);
		$shout = eregi_replace($profanity, $filter, $shout);
	}
	return $shout;
}


function restrictedName($name,$pass){
	$FileName="lists/names.php";
	$list = file ($FileName);
	$pass = md5($pass);
	foreach ($list as $value) {
		list ($restrictedname,$namepass,$nameemail,) = explode ("|^|", $value);
		if ((strtolower($restrictedname) == strtolower($name)) && ($namepass != $pass)){
			echo "<script language='JavaScript'>alert('Incorrect password!');location.href='shoutbox.php';</script>";
			die();
		}
	}
}

function colornames($name,$namecolor){
	//This function searches to see if the username has a color assigned to it and sets the color variable if it does.
	$FileName="lists/colornames.php";
	$list = file ($FileName);
	foreach ($list as $value) {
		list ($name1,$namecolor1,) = explode ("|^|", $value);
		if (strtolower($name) == $name1) {
			$namecolor = $namecolor1;
		}
	}
	return $namecolor;
}
?>