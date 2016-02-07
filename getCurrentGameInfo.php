<!DOCTYPE html>

<head>
<style type="text/css">

<!--
a:link { color: #FFFFFF; text-decoration: none}
a:visited { color: #FFFFFF; text-decoration: none}
a:hover { color: #FFFFFF; text-decoration: underline}
a:active { color: #FFFFFF; text-decoration: none}
-->

        table{
            table-layout: fixed;
            font: 14px Helvetica;
            color: white;
            //margin:0px;padding:0px;
	    width:600px;
	    //box-shadow: 10px 10px 5px #888888;
	    border-collapse: collapse;
	    //border-radius: 5px;
	    
        }
        
        
        td {
            line-height: 0;
            height: 25px;
        }
        
        #rankText {
            position: relative;
            top: -9px;
            right: -6px;
            
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
        
        #tdTier{
             text-align: left;
             //color: black;
             //padding:6px;
        }
	
	th {
	    background-color: #003380;
	}
	
	.ver2 th {
	    background-color: #3D003D;
	}
	
        body {
            background-image: url("simple_dashed.png");
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

<center><a href="http://www.lollookup.com"><img src="/BackgroundImageBro/lollookup115.png" style="height:150px;width:auto;"></a></center>
<hr>
	<ul id="MainNavBar">
  		<li id="NavBarLi"><a href="index.php">Home</a></li>
  		<li id="NavBarLi"><a href="playerProfile.php?summoner_name=">Profile Lookup</a></li>
  		<li id="NavBarLi"><a href="aboot.html">About Us</a></li>
	</ul>

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

// TODO: Problems (probably) arise when no one in the game is currently ranked
// TODO: Add functionality for regions other than North America

// Get the Summoner name from the Input field; given their name, make an API call to get their Summoner ID, it will be needed later.

$summonerName = $_POST['summonerName'];
$friendlySummonerName = rawurlencode($summonerName);
//$friendlySummonerName = str_replace(' ', '%20', $summonerName);
//bf44e42b-ba1a-40c7-9990-a94ef7473dfd


$summObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=***REDACTED***');
//$summObj = json_decode(file_get_contents('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $friendlySummonerName . '?api_key=api_key=***REDACTED***'), true);
$trimmedName = strtolower(str_replace(' ', '', $summonerName));
$summID = (string) ($summObj[$trimmedName]["id"]) ;


// Get current game information for inputted Summoner, store the raw JSON data in $obj
//$obj = json_decode(file_get_contents('https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/' . $summID . '?api_key=api_key=***REDACTED***'), true);
$obj = getJSONObj('https://kr.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/KR/' . $summID . '?api_key=***REDACTED***');
// If the API call was successful (the summoner is currently in a game) ... 
if($obj){

    // Read the information about all of the summoners in that game, each summoner (10 total) becomes an 
    //    element (object) in the $summoners array:
    $summoners = array(
        $obj['participants'][0],
        $obj['participants'][1],
        $obj['participants'][2],
        $obj['participants'][3],
        $obj['participants'][4],
        $obj['participants'][5],
        $obj['participants'][6],
        $obj['participants'][7],
        $obj['participants'][8],
        $obj['participants'][9]
    );
    
    // Construct a string consisting of a comma separated list of all of the Summoner IDs in the current game
    // (We get their IDs from the Summoner objects stored in the $summoners array)
    $idsString = (string)($summoners[0]["summonerId"]) . ',' . 
        (string)($summoners[1]["summonerId"]) . ',' . 
        (string)($summoners[2]["summonerId"]) . ',' . 
        (string)($summoners[3]["summonerId"]) . ',' . 
        (string)($summoners[4]["summonerId"]) . ',' . 
        (string)($summoners[5]["summonerId"]) . ',' . 
        (string)($summoners[6]["summonerId"]) . ',' . 
        (string)($summoners[7]["summonerId"]) . ',' . 
        (string)($summoners[8]["summonerId"]) . ',' . 
        (string)($summoners[9]["summonerId"]);
    
    // Use the string containing the summoner IDs to get rank information for all Summoners in inputted Summoner's current game
    // (This particular API call requires a comma separated list of Summoner IDs) it returns 10 objects, 
    //   each containing 'Current Rank' information for each summoner)
    $summRankObj = getJSONObj('https://kr.api.pvp.net/api/lol/kr/v2.5/league/by-summoner/' . $idsString . '/entry?api_key=api_key=***REDACTED***');
    
    
    // There's a problem though, the output (JSON data) of the above API call gives us an UNORDERED list of rank information
    //  i.e. We don't know which Current Rank information belongs to which Summoner without searching for IDs in the JSON data
    //  ==> Rather than referencing $summRankObj iteratively (summoner[0], summoner[1], ...), we have to use the IDS as a reference instead.
    // The resulting array is a list of STRINGS. The array looks like this:
    //              (Summoner1)  (Summoner2)   (Summoner3)    (Summoner4)          (Summoner10)
    // $summRanks: {"DIAMOND I", "DIAMOND II", "PLATINUM I", "PLATINUM III",  ..., "DIAMOND II"}
    
    $summRanks = array(
    // Simplifies to: $summRankObj[summonerID][0]["tier"]  e.g. "DIAMOND"   +     $summRankObj[summonerID][0]["entries"][0]["division"] e.g. "III"
        $summRankObj[ (string)($summoners[0]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[0]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[1]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[1]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[2]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[2]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[3]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[3]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[4]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[4]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[5]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[5]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[6]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[6]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[7]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[7]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[8]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[8]["summonerId"]) ][0]["entries"][0]["division"],
        $summRankObj[ (string)($summoners[9]["summonerId"]) ][0]["tier"] . ' ' . $summRankObj[ (string)($summoners[9]["summonerId"]) ][0]["entries"][0]["division"]
        
    );
    
    // We now have all of the information we need to start constructing the content that the user will see.
    // Begin by displaying the Game Mode at the top.
    echo "<body>";
    echo "<br><center><span style=\"color:white;font:18px Helvetica\"><b>Game Mode: </b><i>";
    echo $obj['gameMode'];
    echo "</i></span></center><br>";
   
    // Next, display the Blue Team table (the first 5 Summoners).
    echo "<center><table id=\"curGameTable1\"><tr><th><b>Summoner Name</b></th><th><b>Champion</b></th><th><b>Summoner Spells</b></th><th><b>Current Rank</b></th></tr>";
    
    for ($i = 0; $i < 5; $i++) {
    	$summSpell1 = $spells[ (string) ($summoners[$i]['spell1Id']) ];
    	$summSpell2 = $spells[ (string) ($summoners[$i]['spell2Id']) ];
    	$championName = $champions[ (string)($summoners[$i]['championId']) ];
        echo "<tr><td>";
        if($summoners[$i]['summonerName'] == $summonerName)
            echo "<span style=\"color:yellow\">" . "<a href=\"playerProfile.php?summoner_name=" . $summoners[$i]['summonerName'] . "\">" . $summoners[$i]['summonerName'] . "</a>" . "</span>";
            
        else
            echo "<a href=\"playerProfile.php?summoner_name=" . $summoners[$i]['summonerName'] . "\">" . $summoners[$i]['summonerName'] . "</a>";
        echo "</td><td id=\"tdTier\">";
        
        echo "<img src=\"/champion_icons/" . str_replace(" ", "", str_replace(str_split(' '),"",$championName))  . ".png\" border=\"0\" title=\"" . $championName . "\" style=\"height:28px;width:auto;\"> ";
        echo "<span id=\"rankText\">" . $championName . "</span>";
        echo "</td><td>";
        echo "<img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" title=\"" . $summSpell1 . "\" style=\"width:25px;height:25px;color:black;\"> ";
        echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" title=\"" . $summSpell2 . "\" style=\"width:25px;height:25px;color:black;\">";
        echo "</td><td id=\"tdTier\">";
        
        
        switch ($summRanks[$i][0]) {
    		case "B":
        		echo "<img src=\"/tier_icons/bronze_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		case "S":
        		echo "<img src=\"/tier_icons/silver_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		case "G":
        		echo "<img src=\"/tier_icons/gold_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "P":
        		echo "<img src=\"/tier_icons/platinum_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		case "D":
        		echo "<img src=\"/tier_icons/diamond_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		case "M":
        		echo "<img src=\"/tier_icons/master_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		case "C":
        		echo "<img src=\"/tier_icons/challenger_badge.png\" style=\"width:25px;height:25px;top:5px\"> ";
        		break;
    		default:
        		echo "<img src=\"/tier_icons/unrankedgray_badge.png\" style=\"width:25px;height:25px;top:5px\"><span id=\"rankText\">UNRANKED</span>";
	}
	echo "<span id=\"rankText\">" . $summRanks[$i] . "</span>";
        echo "</td></tr>";   
    }
    echo "</table></center><br>";
    
    // Next, display the Purple Team table (the last 5 Summoners).
    echo "<center><table id=\"curGameTable2\" class=\"ver2\"><tr><th><b>Summoner Name</b></th><th><b>Champion</b></th><th><b>Summoner Spells</b></th><th><b>Current Rank</b></th></tr>";
    for ($i = 5; $i < 10; $i++) {

    	$summSpell1 = $spells[ (string) ($summoners[$i]['spell1Id']) ];
    	$summSpell2 = $spells[ (string) ($summoners[$i]['spell2Id']) ];
    	$championName = $champions[ (string)($summoners[$i]['championId']) ];
        echo "<tr><td>";
        echo  "<a href=\"playerProfile.php?summoner_name=" . $summoners[$i]['summonerName'] . "\">" . $summoners[$i]['summonerName'] . "</a>";
        echo "</td><td id=\"tdTier\">";
        
        echo "<img src=\"/champion_icons/" . str_replace(" ", "", str_replace(str_split('. '),"",$championName))  . ".png\" border=\"0\" title=\"" . $championName . "\" style=\"height:28px;width:auto;\"> ";
        echo "<span id=\"rankText\">" . $championName . "</span>";
        echo "</td><td>";
        echo "<img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" title=\"" . $summSpell1 . "\" style=\"width:25px;height:25px;color:black;\"> ";
        echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" title=\"" . $summSpell2 . "\" style=\"width:25px;height:25px;color:black;\">";
        echo "</td><td id=\"tdTier\">";
        
        
        switch ($summRanks[$i][0]) {
    		case "B":
        		echo "<img src=\"/tier_icons/bronze_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "S":
        		echo "<img src=\"/tier_icons/silver_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "G":
        		echo "<img src=\"/tier_icons/gold_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "P":
        		echo "<img src=\"/tier_icons/platinum_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "D":
        		echo "<img src=\"/tier_icons/diamond_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "M":
        		echo "<img src=\"/tier_icons/master_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		case "C":
        		echo "<img src=\"/tier_icons/challenger_badge.png\" style=\"width:25px;height:25px;\"> ";
        		break;
    		default:
        		echo "<img src=\"/tier_icons/unrankedgray_badge.png\" style=\"width:25px;height:25px;\"><span id=\"rankText\">UNRANKED</span>";
	}
        echo "<span id=\"rankText\">" . $summRanks[$i] . "</span>";
        //echo $summRanks[$i];
        echo "</td></tr>";   
    }
    
    echo "</table></center><br><br>";
    
    if($obj['gameMode'] == "CLASSIC")
        echo "<center><a href = \"getGameAnalysis.php?summonerID=" . $summID . "\" target=\"_blank\" style=\"text-decoration: underline\"><font color=\"FFFF00\">Game Analysis</font></a></center>";
    /*
    echo "<br>Development Testing:<br>";
    echo "<form action=\"getGameAnalysis.php\">";
    echo "<input type =\"submit\" value=\"Game Analysis\" action=\"getGameAnalysis.php?summonerID=43514941\"/>";
    echo "</form>";
    */
      
    echo "</body>";
 
}


// If the "current game" API call was not successful and the game does not exist, try instead to 
//   build and go to the Summoners profile page:

// Note: This File should probably be called something else if we are doing things other than getting Current Game information
else{
    echo "<br><br><center><h1 style=\"color:white\">That Summoner either does not exist or is not currently in a game.</h1></center>";
}

	

?>


</html>