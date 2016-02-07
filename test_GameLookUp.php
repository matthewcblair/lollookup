<!DOCTYPE html>
<html>
<head>
<style type = "text/css">
	tr 
	{
    		display: none;
	}

	tr.header 
	{
    		display: table-row;
	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('tr.header').click(function(){
    			$(this).nextUntil('tr.header').css('display', function(i,v){
        			return this.style.display === 'table-row' ? 'none' : 'table-row';
    			});	
		});
	});
</script>

</head>

<body>

<?php 

include 'championList.php';
include 'summonerSpells.php';

function getJSONObj($url){
    $curl = curl_init();
    $options = [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL            => $url
    ];
    curl_setopt_array($curl, $options);
    $JSONObj = json_decode(curl_exec($curl), true);
    curl_close($curl);
    
    return $JSONObj;
}
$summoner_name = 'foreo';
//$summoner_name = $_POST['summoner_name'];
$friendlySummonerName = rawurlencode($summoner_name);
$summObj = getJSONObj('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=***REDACTED***');
$trimmedName = strtolower(str_replace(' ', '', $summoner_name));
$summID = (string) ($summObj[$trimmedName]["id"]);
$game_obj = getJSONObj('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/' . $summID . '/recent?api_key=***REDACTED***');
$summRankObj = getJSONObj('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/' . $summID .'/entry?api_key=***REDACTED***');

echo "<center><table id=\"curGameTable1\"><tr><th><b>Date</b></th><th><b>Type</b></th><th><b>Champion</b></th><th><b>K/D/A</b></th><th><b>Gold</b></th><th><b>Result</b></th><th>Items</th><th></th><th><b>Duration</b></th></tr>";
echo "<h1>";
echo "<img src=\"profile_icons/" . $summObj[$trimmedName]['profileIconId'] . ".png\" border=\"0\" 	style=\"width:75px;height:75px;\"> "; 
echo "</h1>";
echo "<h1>";
echo strtoupper($summoner_name . "    ");
echo "</h1>";
echo "<h3>";
if($summRankObj)
{
	echo (string) $summRankObj[$summID][0]['tier']. " " . $summRankObj[$summID][0]['entries'][0]['division'] . " " . $summRankObj[$summID][0]['entries'][0]['leaguePoints'] . "LP</br>";
	echo (string) $summRankObj[$summID][0]['entries'][0]['wins'] . "W / " . $summRankObj[$summID][0]['entries'][0]['losses'] . "L ";
}
else
	echo "UNRANKED PLAYER";
echo "</h3>";
 
	//echo $summObj[$trimmedName]['profileIconId'];

echo "</br></br>";

?>
<table border="0">
  <tr class="header">
    <td colspan="2">Header</td>
  </tr>
  <tr>
    <td>data</td>
    <td>data</td>
  </tr>
  <tr>
    <td>data</td>
    <td>data</td>
  </tr>
  <tr class="header">
    <td colspan="2">Header</td>
  </tr>
  <tr>
    <td>date</td>
    <td>data</td>
  </tr>
  <tr>
    <td>data</td>
    <td>data</td>
  </tr>
  <tr>
    <td>data</td>
    <td>data</td>
  </tr>
</table>
</body>
</html>
