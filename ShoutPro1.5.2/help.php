<?php
/*
ShoutPro 1.5 - help.php
ShoutPro is licensed under the Creative Commons Attribution-ShareAlike 2.5 License. For more information see the file LICENSE.TXT in the documentation folder included with this distribution, or see http://creativecommons.org/licenses/by-sa/2.5/.  

This file is help.php.  It displays help for users of your shoutbox.

JavaScript functions are defined below.
*/

//include.php calls default ShoutPro functions and settings into effect.  ShoutPro cannot run without it.
require("include.php");
?>

<html><head>
<title><?=$shoutboxname ?> Help</title>
<link rel="stylesheet" href="<?=$theme ?>" type="text/css" />
<!-- Function for clickable smilies -->
<script language="javascript" type="text/javascript">
<!--
function clickemote(text) {
   text = ' ' + text + ' ';
   if (opener.document.forms['postshout'].shout.createTextRange && opener.document.forms['postshout'].shout.caretPos) {
      var caretPos = opener.document.forms['postshout'].shout.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
      opener.document.forms['postshout'].shout.focus();
   } else {
   opener.document.forms['postshout'].shout.value  += text;
   opener.document.forms['postshout'].shout.focus();
   }
}
//-->
</script> 
</head>
<body>

<table width=250 style="font-size: 8pt">
<tr><td colspan=2><div align="center" style="font-size: 8pt;font-weight:bold;"><?=$shoutboxname ?> Help</div></td></tr>

<tr>
    <td colspan=2 style="font-size: 8pt">HTML is prohibited in this shoutbox. 
      However, you can use ShoutCode to format your text. You use ShoutCode just 
      like you use HTML, except instead of using &lt; and &gt;, 
      you use [ and ]. Here are the ShoutCode tags:</td>
  </tr>

<tr><td>[B]Text[/B]</td><td><b>Text</b></td></tr>
<tr><td>[I]Text[/I]</td><td><i>Text</i></td></tr>
<tr><td>[U]Text[/U]</td><td><u>Text</u></td></tr>
<tr><td>[url]http://www.yahoo.com[/url]</td><td>[<a href=http://www.yahoo.com target=_blank>www</a>]</td></tr>
<tr><td>[mail]joe@yahoo.com[/mail]</td><td>[<a href=mailto:joe@yahoo.com>@</a>]</tr>
<tr><td colspan=2></td></tr>
<tr><td colspan=2 style="font-size: 8pt">There are also several smilies you can put into your posts.  A list is below.<br />
You may also click on an image and it wil automatically be added to your shout.</td></tr>
<?php
//Open the smilies list and output on the table.
$FileName="lists/smilies.php";
$list = file ($FileName);
$numsmilies = count($list);
for($go = "0";$go < $numsmilies; $go++){
   list ($code,$image,) = explode ("|^|", $list[$go]);
      echo ("<tr bgcolor=$bgcolor><td valign=top>$code</td><td><a href=\"javascript:clickemote(' $code ')\"><img border=\"0\" src='smilies/$image'></a></td></tr>");
}
echo ("</table>");

/* Start Copyright Text - Do not remove! */
copyrighttext();
/* End Copyright Text - Do not remove! */
?>

