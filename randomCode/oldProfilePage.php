
application/x-httpd-php playerProfile.php ( HTML document text )

<!DOCTYPE html>

<head>
<style type="text/css">
	h1 {
		color:white;
	}
	h3 {
		color:white;
	}
	a {
		color: white;
		text-decoration: none;
	}
        table{
            //table-layout: fixed;
            font: 12px Helvetica;
            color: white;
            //margin:0px;padding:0px;
	    width:800px;
	    //box-shadow: 10px 10px 5px #888888;
	    border-collapse: collapse;
	    //border-radius: 5px;
	    
        }
        
        .bg-img {
            width: 100%;
            height: 100%;
            background: url('https://dl.dropboxusercontent.com/u/5049340/office%402x.png') center center no-repeat;
            background-size: cover;
  
            &:before {
                content: '';
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background-image: linear-gradient(to bottom right,#002f4b,#dc4225);
		opacity: .6; 
            }
        }
        
        td {
            line-height: 0;
            height: 30px;
        }
         
        tr{
            
            background: #1B1B1B;
            //border-bottom: 0px solid black;
            border-bottom: 4px solid black;
            
        }
        table tr:nth-child(odd) {
	     background: #222222;
	     
	}

        td{
            text-align: center;
			
        }
	
	th {
	    background-color: #003380;
	}
	
	.ver2 th {
	    background-color: #3D003D;
	}
	
	 #HeaderText
        {
           // text-align: left;
            //margin: 0 auto;
            width: 300px; 
            
            font: 24px copperplate;
 	    background: -webkit-linear-gradient(top, #fefcea 2%, #f1da36 68%);/*chrome and safari*/
 	    background: -o-linear-gradient(top, #fefcea 2%,#f1da36 68%);/*Opera*/
 	    background: -ms-linear-gradient(top, #fefcea 2%,#f1da36 68%);/*IE10*/
 	    background: linear-gradient(to bottom, #fefcea 2%,#f1da36 68%);/*W3c*/
 	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f1da36',GradientType=0 );/*IE6-9*/
  	    -webkit-background-clip: text;
 	    -webkit-text-fill-color: transparent;

            /*color:#000000;
            font: 16px copperplate;*/
            font-weight: bold;
        }
        #Title
        {
            text-align: center;
            font: 70px copperplate;
            text-shadow: 0px 1px 0px #f1da36, 0px 2px 0px #f1da36, 0px 3px 0px #f1da20, 0px 4px 0px #f1da00, 0px 5px 0px #fffcea, 0px 6px 0px #fefcaa, 0px 7px 0px #fefaaa, 0px 8px 7px #fffa00;
            background: -webkit-linear-gradient(top, #fefcea 2%, f1da36 68%);
            background: -o-linear-gradient(top, #fefcea 2%,#f1da36 68%);/*Opera*/
 	    background: -ms-linear-gradient(top, #fefcea 2%,#f1da36 68%);/*IE10*/
 	    background: linear-gradient(to bottom, #fefcea 2%,#f1da36 68%);/*W3c*/
 	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f1da36',GradientType=0 );/*IE6-9*/
  	    -webkit-background-clip: text;
 	    -webkit-text-fill-color: transparent;
        }
	
	
        body {
            background-image: url("simple_dashed.png");
        }

    </style>
</head>

<div id="HeaderText">Profile Lookup:</div>


<form action="playerProfile.php" method="post">
	<input name="summoner_name"/>

	<input type ="submit" value="Submit"/>
	
</form>

<div id="Title"><a href = "http://lollookup.com">LOL LOOKUP</a></div>

<?php 
include 'championList.php';
include 'summonerSpells.php';

/* TAYLOR'S KEY = 134105a1-c932-4cbf-b381-fc176f525f8c
   JUSTIN'S KEY = bf44e42b-ba1a-40c7-9990-a94ef7473dfd
   MATTHEW'S KEY = api_key=***REDACTED***
   NEW API KEY = 7a0b3555-7afc-4f9e-a412-20399bef78f5
*/

/* ----------------------------------------- BEGIN getJSON FUNCTION AND SUMMID --------------------------- */


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


$summoner_name = $_POST['summoner_name'];
$friendlySummonerName = rawurlencode($summoner_name);
$summObj = getJSONObj('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=***REDACTED***');
$trimmedName = strtolower(str_replace(' ', '', $summoner_name));
$summID = (string) ($summObj[$trimmedName]["id"]);
/* --------------------------------------- BEGIN UNIQUE CODE ----------------------------------*/


$game_obj = getJSONObj('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/' . $summID . '/recent?api_key=***REDACTED***');
$summRankObj = getJSONObj('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/' . $summID .'/entry?api_key=***REDACTED***');

echo "<body>";
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
for($x = 0; $x < 10; $x++)
{
	echo "<tr><td>";
	echo date('d-M-y', ($game_obj['games'][$x]['createDate']/1000));
	echo "</td>";
	echo "<td>";
	if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "RANKED_SOLO_5x5"))
		echo "R 5v5";
	else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "NORMAL_3x3"))
		echo "N 3v3";
	else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "ARAM_UNRANKED_5x5"))
		echo "ARAM";
	else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "NORMAL"))
		echo "N 5v5";
	else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "CAP_5x5"))
		echo "TEAM BUILDER";
	else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "RANKED_TEAM_3x3"))
		echo "R 3v3";
	else	
		echo " " . $game_obj['games'][$x]['subType'] . " ";
	echo "</td>";
	echo "<td>";
	echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$game_obj['games'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
	echo "</td>";
	//echo $champions[$game_obj['games'][$x]['championId']];
	
	echo sprintf ("<td>%d/%d/%d</td>", $game_obj['games'][$x]['stats']['championsKilled'], $game_obj['games'][$x]['stats']['numDeaths'], $game_obj['games'][$x]['stats']['assists']);
	echo sprintf ("<td>%d</td>", $game_obj['games'][$x]['stats']['goldEarned']);
	echo "<td>";
	if($game_obj['games'][$x]['stats']['win'])
		echo "W";
	else
		echo "L";
	echo "</td>";
	echo "<td width=\"25%\">";
	for($y = 0; $y < 6; $y++)
	{
		echo " ";
		if(isset($game_obj['games'][$x]['stats']['item'.((string) $y)])) 
		{
				echo "<img src=\"item_icons/" . $game_obj['games'][$x]['stats']['item' . ((string) $y)]  . ".png\" border=\"0\" 	style=\"width:25px;height:25px;\"> ";
				//echo $game_obj['games'][$x]['stats']['item'.((string) $y)];
		}
	}
	echo "</td>";
	echo "<td>";
	echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$x]['spell1']]  . ".png\" border=\"1\"  style=\"width:25px;height:25px;\"> ";
	echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$x]['spell2']]  . ".png\" border=\"1\"  style=\"width:25px;height:25px;\"> ";
	echo "</td>";
	//echo $spells[$game_obj['games'][$x]['spell1']] . " ";
	//echo $spells[$game_obj['games'][$x]['spell2']] . " ";
	echo "<td>";
	echo substr( (string) ($game_obj['games'][$x]['stats']['timePlayed']/60 + 1),0,2) . "m";
	echo "</td>";
	echo "</tr>";
	
}

echo "</body>";
?>