<?php
ini_set( 'display_errors', 'on' );
error_reporting( E_ALL & ~E_NOTICE );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ean's StreetPass Portal</title>
	<style type="text/css">
		body {
			font-family: Tahoma, Geneva, sans-serif;
		}
		a {
			color: #333333;
			font-weight: bold;
		}
		.header {
			text-align: left;
			text-transform: uppercase;
			margin-bottom: 10px;
			padding-bottom: 10px;
			border-bottom: 1px solid #333333;
		}
		#domo {
			width: 100%;
		}
		#shout {
			width: 170px;
			float: left;
			padding-right: 10px;
		}
		#devArtFeed {
			/*
			float: left;
			max-width: 900px;
			height: 500px;
			margin-left: 10px;
			*/
		}
			#devArtFeed .heading {
				color: #333333;
				font-weight: bold;
				padding-bottom: 1em;
			}
			#devArtFeed .deviation {
				width: 290px;
				float: left;
				margin-right: 10px;
			}
				#devArtFeed .deviation img { width: 290px; }
				
			#moreInfo {
				clear: both;
				float: none;
				width: 100%;
				padding-top: 10px;
			}
	</style>
</head>

<body>

	<div class="header"><a href="../">Site</a> | <a href="http://p0-.deviantart.com" target="_blank">DeviantArt</a><br />3DS FC: 1891-1164-0979</div>

	<div id="shout">
		<div id="domo"><img src="HNI_0085.jpg" alt="Holding hands with Domo-kun" width="170" /></div>
		<iframe id="shoutBox" src="ShoutPro1.5.2/shoutbox.php" width="170" height="500" border="0" style="margin: 0px; padding: 0px; outline: none; border: none;"></iframe>
	</div>

	<div id="devArtFeed">
<?php
$feed = 'http://backend.deviantart.com/rss.xml?q=gallery%3Ap0-%2F29496&type=deviation&limit=3';

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $feed);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt ($ch, CURLOPT_USERAGENT, $_ENV['HTTP_USER_AGENT']);
$data = curl_exec($ch);
curl_close($ch);

$p = xml_parser_create();
xml_parse_into_struct($p, $data, $vals, $index);
xml_parser_free($p);
//echo "Index array\n";
//print_r($index);
//echo "\nVals array\n";
//print_r($vals);
$count = 0;
foreach( $vals as $val ) {
	if( $val['tag'] == 'DESCRIPTION' ) {
		if( $count > 0 ) {
			echo '<div class="deviation" title="DeviantArt RSS Feed" onclick="window.location=\'http://p0-.deviantart.com\';">';
			echo $val['value'];
			echo '</div>' . "\n";
		} 
		$count ++;
		//$images[] = $val['value'];
	}
} 
?>
	</div>
	
	<div id="moreInfo">
		<p>MAC Address: A4-C0-E1-76-BC-1F</p>
		<p><img src="eanmii.jpg" width="176" height="176" alt="My Mii" /></p>
	</div>

<!-- BEGIN GOOGLE ANALYTICS CODE -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-644699-9']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- END   GOOGLE ANALYTICS CODE -->

</body>
</html>
