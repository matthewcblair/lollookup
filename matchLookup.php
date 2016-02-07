<!DOCTYPE = html>
<html>
<head>
<LINK rel="stylesheet" type="text/css"
     href="profilePageStyling.css" media="screen">
<style>
#textInput {
    height: 26px;
    border: 1px;
    padding-left: 5px;
    border-top-left-radius:2px;
    border-bottom-left-radius:2px;
    //width:25%;
}
#submitButton {
    height: 28px;
    border:1px;
    border-top-right-radius:2px;
    border-bottom-right-radius:2px;
    position:relative;
    background: linear-gradient(to bottom, rgba(64, 179, 224, 1), rgba(33, 129, 190, 1));
    color:white;
    right:4px;
    cursor:pointer;
}
hr {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(55, 55, 55, 0.75), rgba(0, 0, 0, 0));
}


#MainNavBar 
{
    font-size: 24px;
    text-align: center;
    list-style-type: none;
    margin: 0;
    padding: 0;
    
    
}

#NavBarLi
{
    padding-right: 15px;
    display: inline;
}
</style>
</head>
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

function getSummonerIDs($gameNumber, $playerID)
{
	$numberOfPlayers =  (count($GLOBALS['game_obj']['games'][$gameNumber]['fellowPlayers']));
	for($y=0;$y<$numberOfPlayers;$y++)
		$summonerIDs = $summonerIDs.(string)$GLOBALS['game_obj']['games'][$gameNumber]['fellowPlayers'][$y]['summonerId'] . ",";
	$summonerIDs .= $playerID;
	return $summonerIDs;		
}

function setTeamArrays($gameNumber)
{
	$numberOfPlayers =  (count($GLOBALS['game_obj']['games'][$gameNumber]['fellowPlayers'])) + 1;
	$y = 0; $v = 0;
	for($x=0;$x<$numberOfPlayers;$x++)
	{
		if($GLOBALS['game_obj']['games'][$gameNumber]['fellowPlayers'][$x]['teamId'] == 100)
			$GLOBALS['teamOneArray'][$y++] = $x;
		else
			$GLOBALS['teamTwoArray'][$v++] = $x;
	}
}

function printRankIcon($participantIndex)
{
    	switch ($GLOBALS['matchObj']['participants'][$participantIndex]['highestAchievedSeasonTier'][0]) {
    		case "B":
        		echo "<img src=\"/tier_icons/bronze_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "S":
        		echo "<img src=\"/tier_icons/silver_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "G":
        		echo "<img src=\"/tier_icons/gold_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "P":
        		echo "<img src=\"/tier_icons/platinum_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "D":
        		echo "<img src=\"/tier_icons/diamond_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "M":
        		echo "<img src=\"/tier_icons/master_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		case "C":
        		echo "<img src=\"/tier_icons/challenger_badge.png\" style=\"width:35px;height:auto;\"> ";
        		break;
    		default:
        		echo "<img src=\"/tier_icons/unrankedgray_badge.png\" style=\"width:35px;height:auto;\">";
        }
		
}

function printMatchObjData($gameNumber)
{
	global $teamOneArray, $teamTwoArray, $game_obj, $summonerNamesObj, $matchObj, $champions, $spells;
	$numberOfPlayers =  (count($game_obj['games'][$gameNumber]['fellowPlayers'])) + 1;
	
	if($game_obj['games'][$gameNumber]['teamId'] == 100)
	{
		if($game_obj['games'][$gameNumber]['stats']['win'])
			echo "<h1> WINNER </h1>";
		else
			echo "<h1> LOSER </h1>";
		echo "<table id=\"curGameTable1\"><tr><th><b>Name</b></th><th><b>Champion</b></th><th><b>Rank</b></th><th><b>K/D/A</b></th><th><b>CS</b></th><th><b>Damage</b></th><th>Items</th></tr>";	
		
		$i = 0;
		for($z=0; $z<($numberOfPlayers/2); $z++)
		{	
			for($x = 0; $x < ($numberOfPlayers/2); $x++)
			{
				if($game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['championId'] == $matchObj['participants'][$x]['championId'])
				{	
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . urlencode($summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['summonerId']]['name']);
					echo "<tr><td>";
					echo "<a href = $url>";
					echo $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['summonerId']]['name'];
					echo "</a>";
					echo "</td>";
					echo "<td>";
					//border=\"1\" id=\"summSp1\"
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$matchObj['participants'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell1Id']]  . ".png\"   border=\"1\" id=\"summSp1\"> ";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell2Id']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf("<td>%d/%d/%d</td>", $matchObj['participants'][$x]['stats']['kills'], $matchObj['participants'][$x]['stats']['deaths'], $matchObj['participants'][$x]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if($matchObj['participants'][$x]['stats']['item'.((string) $y)])
							echo "<img src = \"item_icons/" . $matchObj['participants'][$x]['stats']['item' . ((string) $y)] . ".png\" border=\"0\" style=\"width:25px;height:25px;\">";
					echo "</td>";
					echo "</tr>";
				}
				else if($game_obj['games'][$gameNumber]['championId'] == $matchObj['participants'][$x]['championId'] && !$i)
				{
					$i++;
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . $summonerNamesObj[$game_obj['summonerId']]['name'];
					echo "<tr><td><a href = $url>" . $summonerNamesObj[$game_obj['summonerId']]['name'] . "</a></td>";
					echo "<td>";
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$game_obj['games'][$gameNumber]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$gameNumber]['spell1']]  . ".png\"   border=\"1\" id=\"summSp1\">";
					echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$gameNumber]['spell2']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf ("<td>%d/%d/%d</td>", $game_obj['games'][$gameNumber]['stats']['championsKilled'], $game_obj['games'][$gameNumber]['stats']['numDeaths'], $game_obj['games'][$gameNumber]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if(isset($game_obj['games'][$gameNumber]['stats']['item'.((string) $y)])) 
							echo "<img src=\"item_icons/" . $game_obj['games'][$gameNumber]['stats']['item' . ((string) $y)]  . ".png\" border=\"0\" style=\"width:25px;height:25px;\"> ";
					echo "</td>";
					echo "</tr>";
				}
			}
		}
		echo "</table>";
		if($game_obj['games'][$gameNumber]['stats']['win'])
			echo "<h1> LOSER </h1>";
		else
			echo "<h1> WINNER </h1>";
		echo "<table id=\"curGameTable1\"><tr><th><b>Name</b></th><th><b>Champion</b></th><th><b>Rank</b></th><th><b>K/D/A</b></th><th><b>CS</b></th><th><b>Damage</b></th><th>Items</th></tr>";	
		for($z = 0; $z < ($numberOfPlayers/2); $z++)
		{
			for($x = ($numberOfPlayers/2); $x < $numberOfPlayers; $x++)
			{
				if($game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['championId'] == $matchObj['participants'][$x]['championId'])
				{
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['summonerId']]['name'];
					echo "<tr><td><a href = $url>" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['summonerId']]['name'] . "</a></td>";
					echo "<td>";
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$matchObj['participants'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell1Id']]  . ".png\"   border=\"1\" id=\"summSp1\"> ";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell2Id']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf("<td>%d/%d/%d</td>", $matchObj['participants'][$x]['stats']['kills'], $matchObj['participants'][$x]['stats']['deaths'], $matchObj['participants'][$x]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if($matchObj['participants'][$x]['stats']['item'.((string) $y)])
							echo "<img src = \"item_icons/" . $matchObj['participants'][$x]['stats']['item' . ((string) $y)] . ".png\" border=\"0\" style=\"width:25px;height:25px;\">";
					echo "</td>";
					echo "</tr>";
				}
			}
		}
		echo "</table>";
	}
	
	else
	{
		if($game_obj['games'][$gameNumber]['stats']['win'])
			echo "<h1> LOSER </h1>";
		else
			echo "<h1> WINNER </h1>";
		echo "<table id=\"curGameTable1\"><tr><th><b>Name</b></th><th><b>Champion</b></th><th><b>Rank</b></th><th><b>K/D/A</b></th><th><b>CS</b></th><th><b>Damage</b></th><th>Items</th></tr>";
		$i = 0;
		//Populate the profile lookup player's data in subtable
		for($z = 0; $z <($numberOfPlayers/2); $z++)
		{
			for($x = 0; $x < ($numberOfPlayers/2); $x++)
			{
				if($game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['championId'] == $matchObj['participants'][$x]['championId'])
				{
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['summonerId']]['name'];
					echo "<tr><td><a href = $url>" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamOneArray[$z]]['summonerId']]['name'] . "</a></td>";
					echo "<td>";
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$matchObj['participants'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell1Id']]  . ".png\"   border=\"1\" id=\"summSp1\"> ";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell2Id']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf("<td>%d/%d/%d</td>", $matchObj['participants'][$x]['stats']['kills'], $matchObj['participants'][$x]['stats']['deaths'], $matchObj['participants'][$x]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if($matchObj['participants'][$x]['stats']['item'.((string) $y)])
							echo "<img src = \"item_icons/" . $matchObj['participants'][$x]['stats']['item' . ((string) $y)] . ".png\" border=\"0\" style=\"width:25px;height:25px;\">";
					echo "</td>";
					echo "</tr>";
				}
			}
		}
		echo "</table>";
		if($game_obj['games'][$gameNumber]['stats']['win'])
			echo "<h1> WINNER </h1>";
		else
			echo "<h1> LOSER </h1>";
		echo "<table id=\"curGameTable1\"><tr><th><b>Name</b></th><th><b>Champion</b></th><th><b>Rank</b></th><th><b>K/D/A</b></th><th><b>CS</b></th><th><b>Damage</b></th><th>Items</th></tr>";
		for($z = 0; $z < ($numberOfPlayers/2); $z++)
		{
			for($x = ($numberOfPlayers/2); $x < $numberOfPlayers; $x++)
			{
				if($game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['championId'] == $matchObj['participants'][$x]['championId'])
				{
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['summonerId']]['name'];
					echo "<tr><td><a href = $url>" . $summonerNamesObj[$game_obj['games'][$gameNumber]['fellowPlayers'][$teamTwoArray[$z]]['summonerId']]['name'] . "</a></td>";
					echo "<td>";
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$matchObj['participants'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell1Id']]  . ".png\"   border=\"1\" id=\"summSp1\"> ";
					echo "<img src=\"spell_icons/" . $spells[$matchObj['participants'][$x]['spell2Id']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf("<td>%d/%d/%d</td>", $matchObj['participants'][$x]['stats']['kills'], $matchObj['participants'][$x]['stats']['deaths'], $matchObj['participants'][$x]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if($matchObj['participants'][$x]['stats']['item'.((string) $y)])
							echo "<img src = \"item_icons/" . $matchObj['participants'][$x]['stats']['item' . ((string) $y)] . ".png\" border=\"0\" style=\"width:25px;height:25px;\">";
					echo "</td>";
					echo "</tr>";
				}
				else if($game_obj['games'][$gameNumber]['championId'] == $matchObj['participants'][$x]['championId'] && !$i)
				{
					$i++;
					$url = "http://lollookup.com/playerProfile.php";
					$url .= "?summoner_name=" . $summonerNamesObj[$game_obj['summonerId']]['name'];
					//player whose profile we came from is printed here
					echo "<tr><td><a href = $url>" . $summonerNamesObj[$game_obj['summonerId']]['name'] . "</a></td>";
					echo "<td>";
					echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$game_obj['games'][$gameNumber]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
					echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$gameNumber]['spell1']]  . ".png\"   border=\"1\" id=\"summSp1\"> ";
					echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$gameNumber]['spell2']]  . ".png\"   border=\"1\" id=\"summSp2\"> ";
					echo "</td>";
					echo "<td>";
					//echo $matchObj['participants'][$x]['highestAchievedSeasonTier'];
					printRankIcon($x);
					echo "</td>";
					echo sprintf ("<td>%d/%d/%d</td>", $game_obj['games'][$gameNumber]['stats']['championsKilled'], $game_obj['games'][$gameNumber]['stats']['numDeaths'], $game_obj['games'][$gameNumber]['stats']['assists']);
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['minionsKilled'];
					echo "</td>";
					echo "<td>";
					echo $matchObj['participants'][$x]['stats']['totalDamageDealtToChampions'];
					echo "</td>";
					echo "<td>";
					for($y = 0; $y < 6; $y++)
						if(isset($game_obj['games'][$gameNumber]['stats']['item'.((string) $y)])) 
							echo "<img src=\"item_icons/" . $game_obj['games'][$gameNumber]['stats']['item' . ((string) $y)]  . ".png\" border=\"0\" style=\"width:25px;height:25px;\"> ";
					echo "</td>";
					echo "</tr>";
				}
			}
		}
		echo "</table>";
	}
}

?>
<body>
<center><a href = "http://lollookup.com/"><img src="/BackgroundImageBro/lollookup115.png" style="height:100px;width:auto;"></a>
<hr>
	<ul id="MainNavBar">
  		<li id="NavBarLi"><a href="index.php">Home</a></li>
  		<li id="NavBarLi"><a href="playerProfile.php?summoner_name=">Profile Lookup</a></li>
  		<li id="NavBarLi"><a href="aboot.html">About Us</a></li>
	</ul>
<br>

<form action="playerProfile.php?" method="get">
	<input name="summoner_name" id="textInput" placeholder="Profile Lookup"/>
	<input type ="submit" value="Submit" id="submitButton"/>
	
</form>
<hr><br>
</center>

<?php

include 'championList.php';
include 'summonerSpells.php';

$summID = $_GET['summoner_name'];
$game = $_GET['game'];
$game_obj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.3/game/by-summoner/' . $summID . '/recent?api_key=***REDACTED***');
$matchID = $game_obj['games'][$game]['gameId'];
$matchObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v2.2/match/' . $matchID . '?api_key=***REDACTED***');
$teamOneArray = array();
$teamTwoArray = array();
$summonerIDs = getSummonerIDs($game,$summID);
$summonerNamesObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.4/summoner/' .  $summonerIDs . '?api_key=***REDACTED***');
setTeamArrays($game);

echo "<center>";
echo "<h1>";
/*
if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "RANKED_SOLO_5x5"))
		echo "RANKED 5v5";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "NORMAL_3x3"))
		echo "NORMAL 3v3";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "ARAM_UNRANKED_5x5"))
		echo "ARAM";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "NORMAL"))
		echo "NORMAL 5v5";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "CAP_5x5"))
		echo "TEAM BUILDER";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "RANKED_TEAM_3x3"))
		echo "RANKED 3v3";
	else if(!strcasecmp((string)$game_obj['games'][$game]['subType'], "RANKED_TEAM_5x5"))
		echo "RANKED 5v5";
	else	
		echo " " . $game_obj['games'][$game]['subType'] . " ";*/
echo "</h1>";
echo "<h1>";
//echo date('d-M-y', ($game_obj['games'][$game]['createDate']/1000));
echo "</h1>";
printMatchObjData($game);
echo "</center>";

?>
</body>
</html>