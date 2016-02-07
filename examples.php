<html>
<?php
function getJSONObj($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);			
	$result = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($result, true);
	return $result;
}

$summoner_name = 'skt t1 faker';
$friendlySummonerName = rawurlencode($summoner_name);
$summObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=***REDACTED***');
$trimmedName = strtolower(str_replace(' ', '', $summoner_name));
$summID = (string) ($summObj[$trimmedName]["id"]);
$game_obj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.3/game/by-summoner/' . $summID . '/recent?api_key=***REDACTED***');
$matchID = $game_obj['games'][0]['gameId'];
$matchObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v2.2/match/' . $matchID . '?api_key=***REDACTED***');
$summRankObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v2.5/league/by-summoner/' . $summID .'/entry?api_key=***REDACTED***');

echo "<h1><center>Summoner JSON: </center></h1>";
print_r($summObj);
echo "<h1><center>Game JSON: </center></h1>";
print_r($game_obj);
echo "<h1><center>Match JSON: </center></h1>";
print_r($matchObj);
echo "<h1><center>Rank JSON: </center></h1>";
print_r($summRankObj);
?>
</html>