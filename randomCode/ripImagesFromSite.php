<?php
//http://ddragon.leagueoflegends.com/cdn/5.2.1/img/profileicon/
//$lines = file("/home/toup162/public_html/randomCode/itemIDs.txt", FILE_IGNORE_NEW_LINES);
	for($x = 4000; $x < 5000; $x++){
		$url = "http://ddragon.leagueoflegends.com/cdn/5.2.1/img/mastery/$x.png";
		$img = "/home/toup162/public_html/mastery_icons/$x.png";
		file_put_contents($img, file_get_contents($url));
	}
	
/*
***** Alternative method using cURL *****

$ch = curl_init('http://example.com/image.php');
$fp = fopen('/my/folder/flower.gif', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
*/


?>
