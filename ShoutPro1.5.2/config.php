<?php
/*
ShoutPro 1.5.2 - config.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is config.php.  Edit all the variables to customize ShoutPro.
*/

$shoutboxname = "Ean's StreetPass Shoutbox"; //The name of your shoutbox.  Displayed in the title of the page and at the top if $displayname is set to "yes"
$displayname = "yes"; //Display $shoutboxname at the top of shoutbox.php and viewall.php?  Set to "yes" or "no".

$thepassword = "sh0utp455"; //IMPORTANT!  Change this file to your password.  Otherwise anyone will be able to clear your shoutbox.

$theme = "themes/default.css"; //This should point to your .css theme file.  You can get new themes from ShoutPro.com.  Default is "themes/default.css"

$width = "170"; //The width of the shoutbox.  This needs to be the same as the width of the IFRAME.
$numshoutsdisplay = 10; //The number of shouts to display before "View All" must be clicked to see more.  Default is 10.

$timeoffset = 0; //The different between your time and the time on your sever, in hours.  Basically get this by taking your local time and subtracting server time, so if your local time is 3:30 PM and the server time (that ShoutPro gives when this is set to 0) is 2:30 PM, this should be set to 1 to add 1 hour to the server time.  This will only affect shouts posted AFTER the offset is saved, since previous shouts have their date and time saved in shouts.php.  Default is 0.

//User Panel Settings
$userpanelon = "yes"; //If you would like to allow users to password protect names through the user panel, set this to "yes".
$sitename = "Ean's StreetPass Shoutbox"; //The name of your site
$siteurl = "http://www.eanbowman.com/ds/"; //The url of the site where this shoutbox is located.
$siteemail = "eanbowman@gmail.com"; //Your admin e-mail address.

$refreshmode = "both"; //If set to "auto" ShoutPro will automatically refresh every $refresh (another variable you can set in this file) seconds.  If set to "manual" a link will be displayed to manually refresh the shoutbox.  Set to "both" if you want automatic refreshing along with a button to refresh manually.  If something other than those values is entered, ShoutPro will automatically go with the "both" option.
$refresh = "10"; //The number of seconds between each automatic refresh of the shoutbox.  Default is 30.

$minlength = "1"; //The minimum length of a shout.  Shouts shorter than this will generate an error.  Set to "1" to disable.
$maxlength = "140"; //The maximum length of a shout.  Shouts longer than this will generate an error.  Set to "0" to disable.
$nameminlength = "3"; //The minimum length of a name.  Names shorter than this will generate an error.  Set to "1" to disable.
$namemaxlength = "20"; //The maximum length of a name.  Names longer than this will generate an error.  Set to "0" to disable.

//The settings below control messages that appear for various reasons during use of ShoutPro
$bannedmessage = "Sorry, you've been banned from this shoutbox."; //This message will be displayed when someone tries to use the shoutbox under a banned IP.  (Banned IPs are in the file lists/bannedips.php.)
$badnamemessage = "Sorry, that name is banned from this shoutbox."; // Message to display if the name of the poster is in the .
$inputshout = "Sorry, you have to input a shout."; //This message is shown if the user does not input a shout.  Default is "Sorry, you have to input a shout."
$inputname = "You have a name, don't you?  Please enter one."; //This message is shown in the user does not input a name.  Default is "You have a name, don't you?  Please enter one."

$version = "1.5.2"; //The version of ShoutPro.  Don't change this value or your version checking will not work.
?>