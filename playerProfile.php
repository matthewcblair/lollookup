<!DOCTYPE html>
<html>
<head>
<style type = "text/css">
	p
	{
		color:white;
	}
	tr.header 
	{
    		display: table-row;
    		cursor:pointer;
    		
	}
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
        
hr {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(55, 55, 55, 0.75), rgba(0, 0, 0, 0));
}


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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function() {
$('tr[data-href]').on("click", function() {
    document.location = $(this).data('href');
});
});
</script>
</head>


<center><a href = "http://lollookup.com/"><img src="/BackgroundImageBro/lollookup115.png" style="height:100px;width:auto;"></center></a>
<hr>
	<ul id="MainNavBar">
  		<li id="NavBarLi"><a href="index.php">Home</a></li>
  		<li id="NavBarLi"><a href="playerProfile.php?summoner_name=">Profile Lookup</a></li>
  		<li id="NavBarLi"><a href="aboot.html">About Us</a></li>
	</ul>
<br>

<center>
<form action="playerProfile.php?" method="get">
	<input name="summoner_name" id="textInput" placeholder="Profile Lookup"/>
	<input type ="submit" value="Submit" id="submitButton"/>
	
</form>
</center>
<br>
<hr>


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
//SUPER KEY: 7a0b3555-7afc-4f9e-a412-20399bef78f5
$summoner_name = $_GET['summoner_name'];
//$summoner_name = $_POST['summoner_name'];
$friendlySummonerName = rawurlencode($summoner_name);
$summObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=***REDACTED***');
$trimmedName = strtolower(str_replace(' ', '', $summoner_name));
$summID = (string) ($summObj[$trimmedName]["id"]);
$game_obj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.3/game/by-summoner/' . $summID . '/recent?api_key=***REDACTED***');
$summRankObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v2.5/league/by-summoner/' . $summID .'/entry?api_key=***REDACTED***');
if($summObj)
{
	echo "<body>";
	echo "<center><table id=\"curGameTable1\"><tr><th><b>Date</b></th><th><b>Type</b></th><th><b>Champion</b></th><th><b>K/D/A</b></th><th><b>Gold</b></th><th><b>Result</b></th><th>Items</th><th></th><th><b>Duration</b></th></tr>";
	echo "<h1>";
	echo "<img src=\"profile_icons/" . $summObj[$trimmedName]['profileIconId'] . ".png\" border=\"0\" 	style=\"width:75px;height:75px;\">"; 
	echo "<span style=\"position:relative; bottom:28px; padding-left:10px;\">" . $summoner_name . "</span>";
	echo "</h1>";
	echo "<h3>";

	if($summRankObj)
	{
    		switch ($summRankObj[$summID][0]['tier'][0]) {
    			case "B":
        			echo "<img src=\"/tier_icons/bronze_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "S":
        			echo "<img src=\"/tier_icons/silver_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "G":
        			echo "<img src=\"/tier_icons/gold_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "P":
        			echo "<img src=\"/tier_icons/platinum_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "D":
        			echo "<img src=\"/tier_icons/diamond_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "M":
        			echo "<img src=\"/tier_icons/master_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			case "C":
        			echo "<img src=\"/tier_icons/challenger_badge.png\" style=\"width:60px;height:auto;\"> ";
        			break;
    			default:
        			echo "<img src=\"/tier_icons/unrankedgray_badge.png\" style=\"width:60px;height:60px;\"><span id=\"rankText\">UNRANKED</span>";
		}
		echo "<span style=\"position:relative;bottom:20px;\">" . ((string)$summRankObj[$summID][0]['tier']). " " . $summRankObj[$summID][0]['entries'][0]['division'] . " - " . $summRankObj[$summID][0]['entries'][0]['leaguePoints'] . "LP (";
		echo (string) $summRankObj[$summID][0]['entries'][0]['wins'] . "W / " . $summRankObj[$summID][0]['entries'][0]['losses'] . "L)</span>";
	}
	else
		echo "UNRANKED PLAYER";
	echo "</h3>";
	echo "</br></br>";

	for($x = 0; $x < 10; $x++)
	{
		$url = "http://lollookup.com/matchLookup.php";
		$url .= "?summoner_name=" . urlencode($summID);
		$url .= "&game=" . urlencode($x);
		if(!$game_obj['games'][$x]['stats']['goldEarned'])
			break;
		echo "<tr class = \"header\" data-href=$url>";
		echo "<td>";
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
		else if(!strcasecmp((string)$game_obj['games'][$x]['subType'], "RANKED_TEAM_5x5"))
			echo "R 5v5";
		else	
			echo " " . $game_obj['games'][$x]['subType'] . " ";
		echo "</td>";
		echo "<td>";
		echo "<img src=\"champion_icons/" . str_replace(" ", "", $champions[$game_obj['games'][$x]['championId']])  . ".png\" border=\"0\" style=\"width:50px;height:50px;\">";
		echo "</td>";
		echo sprintf ("<td>%d/%d/%d</td>", $game_obj['games'][$x]['stats']['championsKilled'], $game_obj['games'][$x]['stats']['numDeaths'], $game_obj['games'][$x]['stats']['assists']);
		echo sprintf ("<td>%d</td>", $game_obj['games'][$x]['stats']['goldEarned']);
		echo "<td>";
		if($game_obj['games'][$x]['stats']['win'])
			echo "W";
		else
			echo "L";
		echo "</td>";
		echo "<td>";
		for($y = 0; $y < 6; $y++)
		{
			echo " ";
			if(isset($game_obj['games'][$x]['stats']['item'.((string) $y)])) 
					echo "<img src=\"item_icons/" . $game_obj['games'][$x]['stats']['item' . ((string) $y)]  . ".png\" border=\"0\" 	style=\"width:25px;height:25px;\"> ";	
		}
		echo "</td>";
		echo "<td>";
		echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$x]['spell1']]  . ".png\"   style=\"width:25px;height:25px;\"> ";
		echo "<img src=\"spell_icons/" . $spells[$game_obj['games'][$x]['spell2']]  . ".png\"   style=\"width:25px;height:25px;\"> ";
		echo "</td>";
		echo "<td>";
		echo substr( (string) ($game_obj['games'][$x]['stats']['timePlayed']/60 + 1),0,2) . "m";
		echo "</td>";
		echo "</a></tr>";
	
	}

}
else
{
	echo "<center><h1> What'chu talkin' 'bout Willis? </h1></center>"; 
	echo "<center><p color=white> (Enter valid Summoner Name) </p></center>";
}
	
	
echo "</center>";
echo "</table>";
echo "</body>";
?>

</html>