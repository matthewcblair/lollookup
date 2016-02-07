<!DOCTYPE html>


<style type="text/css">

a:link { color: #FFFFFF; text-decoration: none}
a:visited { color: #FFFFFF; text-decoration: underline}
a:hover { color: #FFFFFF; text-decoration: underline}
a:active { color: #FFFFFF; text-decoration: underline}

#spectateButtonDiv {
    //float:left;
    //background-color:#FFFFFF;
    //padding:5px;
    height:24px;
}

#spectateButtonLeft {
    float:left;
    border:1px;
    height:20px;
    color:white;
    border-radius:2px;
    background: linear-gradient(to bottom, rgba(57, 163, 204, 1), rgba(33, 129, 190, 1));
    cursor:pointer;
}

#spectateButtonRight {
    float:right;
    border:1px;
    height:20px;
    color:white;
    border-radius:2px;
    background: linear-gradient(to bottom, rgba(57, 163, 204, 1), rgba(33, 129, 190, 1));
    cursor:pointer;
}

#closeInstrButton {
    border:1px;
    height:20px;
    color:white;
    border-radius:2px;
    background: linear-gradient(to bottom, rgba(57, 163, 204, 1), rgba(33, 129, 190, 1));
}

#specInstr1 {
    width:870px;
    height:150px;
    background:rgba(32,128,189,0.2);
    color:#FFFFFF;
    border:2px solid black;
    border-radius:6px;
    padding:20px;
    display:none; 
}

#specInstr2 {
    width:870px;
    height:150px;
    background:rgba(32,128,189,0.2);
    color:#FFFFFF;
    border:2px solid black;
    border-radius:6px;
    padding:20px;
    display:none; 
}

#specRunTxt {
    text-align:left;
    width:850px;
    height:29px;
    resize:none;
    background-color:#333333;
    color:white;
    font-size:11px;
}

#legal {
    width:870px;
    margin:0 auto;
    font-size:12px;
}

#forms {
    width:600px;
    height:52px;
}


#mobileForms {
    display:none;
    height:200px;
}

#lineBreakDiv {
    display:none;
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

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<LINK rel="stylesheet" type = "text/css"
    href="homepage.css" media="screen">
    
<title>lolLookup</title>

</head>
<body>

<script>
    function showDiv1() {
        document.getElementById('specInstr1').style.display = "block";
    }
    
    function closeInstr1() {
        document.getElementById('specInstr1').style.display = "none";
    }
    
    function showDiv2() {
        document.getElementById('specInstr2').style.display = "block";
    }
    
    function closeInstr2() {
        document.getElementById('specInstr2').style.display = "none";
    }
</script>

<center><img src="/BackgroundImageBro/lollookup115.png" id="desktopLogo"></center>
<hr>
	<ul id="MainNavBar">
  		<li id="NavBarLi"><a href="index.php">Home</a></li>
  		<li id="NavBarLi"><a href="playerProfile.php?summoner_name=">Profile Lookup</a></li>
  		<li id="NavBarLi"><a href="aboot.html">About Us</a></li>
	</ul>
<br><br>

<! -- DESKTOP Input Forms (Hidden on Mobile) -- >
<center>
<div id="forms">

<span id="HeaderText"><span id="LargeText1">Game Lookup</span>
<form action="getCurrentGameInfo.php" method="post">
    <input name="summonerName" id="textInput" placeholder="Summoner Name"/>
    <input type="submit" name="submitButton" value="Submit" id="submitButton"/>
</form>
</span>
<span id="HeaderText2"><span id="LargeText2">Profile Lookup</span>
<form action="playerProfile.php?" method="get">
	<input name="summoner_name" id="textInput" placeholder="Summoner Name"/>
	<input type ="submit" value="Submit" id="submitButton"/>
</form>
</span>

</div>
</center>

<! -- MOBILE Input Forms (Hidden on Desktop) -- >
<center>
<div id="mobileForms">

<span id="mobileLargeText">Game Lookup</span>
<form action="getCurrentGameInfo.php" method="post">
    <input name="summonerName" id="textInput" placeholder="Summoner Name"/>
    <input type="submit" name="submitButton" value="Submit" id="submitButton"/>
</form>
<br>
<span id="mobileLargeText">Profile Lookup</span>
<form action="playerProfile.php?" method="get">
	<input name="summoner_name" id="textInput" placeholder="Summoner Name"/>
	<input type ="submit" value="Submit" id="submitButton"/>
</form>

</div>
</center>

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
echo "<br><br>";
$FeatGames= getJSONObj('https://kr.api.pvp.net/observer-mode/rest/featured?api_key=****REDACTED****');

if($FeatGames){
    //echo "<body>";
    echo "<hr>";
    echo "<br><br><br><center><div id=\"imageContainer\"><img src=\"/BackgroundImageBro/featuredgames1.png\" style=\"align:left;\"></div></center>";
    
    echo "<center><div id=\"featGamesDiv\">";

    echo "<div id=\"spectateButtonDiv\">";
    echo "<button id=\"spectateButtonLeft\" onclick=\"showDiv1()\">Spectate</button>";
    echo "<button id=\"spectateButtonRight\" onclick=\"showDiv2()\">Spectate</button>";
    echo "</div>";
    for($z = 0; $z < 2; $z++) {
        $FeatGame= $FeatGames["gameList"][$z];
        // Read the information about all of the summoners in that game, each summoner (10 total) becomes an 
        //    element (object) in the $summoners array:
        $summoners = array(
            $FeatGame['participants'][0],
            $FeatGame['participants'][1],
            $FeatGame['participants'][2],
            $FeatGame['participants'][3],
            $FeatGame['participants'][4],
            $FeatGame['participants'][5],
            $FeatGame['participants'][6],
            $FeatGame['participants'][7],
            $FeatGame['participants'][8],
            $FeatGame['participants'][9]
        );
        
        
        
        // Construct a string consisting of a comma separated list of all of the Summoner IDs in the current game
        // (We get their IDs from the Summoner objects stored in the $summoners array)
        
            
        
        // We now have all of the information we need to start constructing the content that the user will see.
        // Begin by displaying the Game Mode at the top.
        
        
        if($z == 0)
            echo "<br><br><table id=\"curGameTable1\"><tr><th id=\"blue\"><b>Blue Team</b></th><th id=\"purple\"><b>Purple Team</b></th></tr>";
        else
            echo "<br><br><table id=\"tableRight\"><tr><th id=\"blue\"><b>Blue Team</b></th><th id=\"purple\"><b>Purple Team</b></th></tr>";
        
        
        for ($i = 0; $i < 5; $i++) {
            // Column - Blue Team Summoner
        	$summSpell1 = $spells[ (string) ($summoners[$i]['spell1Id']) ];
        	$summSpell2 = $spells[ (string) ($summoners[$i]['spell2Id']) ];
        	$championName = $champions[ (string)($summoners[$i]['championId']) ];
            echo "<tr><td id=\"tdTierLeft\">";
            echo "<img src=\"/champion_icons/" . str_replace(" ", "", str_replace(str_split(' '),"",$championName))  . ".png\" border=\"0\" title=\"" . $championName . "\" style=\"height:100%;width:auto;\">";
            echo "<img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" id=\"summSp1\" title=\"" . $summSpell1 . "\">";
            echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" id=\"summSp2\" title=\"" . $summSpell2 . "\">";
            if($summoners[$i]['summonerName'] == $playerName){
                echo "<span id=\"rankTextLeftYellow\"><a href=\"playerProfile.php?summoner_name=" . $summoners[$i]['summonerName'] . "\">" . $summoners[$i]['summonerName'] . "</a></span>";
            }
            else
                echo "<span id=\"rankTextLeft\"><a href=\"playerProfile.php?summoner_name=" . $summoners[$i]['summonerName'] . "\">" . $summoners[$i]['summonerName'] . "</a></span>";
        
            echo "</td>";   
            
            // Column - Role
            
            echo "<td id=\"tdTierRight\">";
            
            // Column - Purple Team Summoner
            $summSpell1 = $spells[ (string) ($summoners[$i+5]['spell1Id']) ];
        	$summSpell2 = $spells[ (string) ($summoners[$i+5]['spell2Id']) ];
        	$championName = $champions[ (string)($summoners[$i+5]['championId']) ];
        	
            if($summoners[$i+5]['summonerName'] == $playerName){
                echo "<span id=\"rankTextRightYellow\">" . $summoners[$i+5]['summonerName'] . "</span>";
            }
            else
                echo "<span id=\"rankTextRight\"><a href=\"playerProfile.php?summoner_name=" . $summoners[$i+5]['summonerName'] . "\">" . $summoners[$i+5]['summonerName'] . "</a></span>";
            
            echo "<img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" id=\"summSp1Right\" title=\"" . $summSpell1 . "\">";
            echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" id=\"summSp2Right\" title=\"" . $summSpell2 . "\">";
            echo "<img src=\"/champion_icons/" . str_replace(" ", "", str_replace(str_split(' '),"",$championName))  . ".png\" border=\"0\" title=\"" . $championName . "\" style=\"height:100%;width:auto;\">";
            echo "</td></tr>";
        
        
        }
        
        echo "</table>";
    
    }
    echo "</div></center><br>";
    
    
    echo "<center><div id=\"specInstr1\"><b>Spectate Instructions</b><br>";
    echo "<br><div style=\"text-align:left;width:870px;\"><b>Windows</b>: Open the \"Run\" window by pressing '[Windows Key] + R', then paste in all of the following text:<br>";
    echo "<br><center><textarea readonly id=\"specRunTxt\">" . "\"C:\Riot Games\League of Legends\RADS\solutions\lol_game_client_sln\\releases\\0.0.1.94\deploy\League of Legends.exe\" \"8394\" \"LoLLauncher.exe\" \"\" \"spectator spectator.na2.lol.riotgames.com:80 " . $FeatGames["gameList"][0]["observers"]["encryptionKey"] . " " . ((string)($FeatGames["gameList"][0]["gameId"])) . " " . "NA1\"" . "</textarea>";
    echo "<br><br><button id=\"closeInstrButton\"onclick=\"closeInstr1()\">Close</button>";
    echo "</center></div><br>"; 
    echo "</div></center>";
    
    echo "<center><div id=\"specInstr2\"><b>Spectate Instructions</b><br>";
    echo "<br><div style=\"text-align:left;width:870px;\"><b>Windows</b>: Open the \"Run\" window by pressing '[Windows Key] + R', then paste in all of the following text:<br>";
    echo "<br><center><textarea readonly id=\"specRunTxt\">" . "\"C:\Riot Games\League of Legends\RADS\solutions\lol_game_client_sln\\releases\\0.0.1.94\deploy\League of Legends.exe\" \"8394\" \"LoLLauncher.exe\" \"\" \"spectator spectator.na2.lol.riotgames.com:80 " . $FeatGames["gameList"][1]["observers"]["encryptionKey"] . " " . ((string)($FeatGames["gameList"][1]["gameId"])) . " " . "NA1\"" . "</textarea>";
    echo "<br><br><button id=\"closeInstrButton\"onclick=\"closeInstr2()\">Close</button>";
    echo "</center></div><br>"; 
    echo "</div></center>";
    
    
    
    }
    

$twitchStreams = getJSONObj('https://api.twitch.tv/kraken/streams?game=League+of+Legends');

if($twitchStreams){
    echo "<br><br><br><center><div id=\"imageContainer\"><img src=\"/BackgroundImageBro/featuredstreams1.png\" style=\"align:left;\"></div></center>";
    echo "<center><div id=\"sugItemsDiv\">";
    
    for($j = 0; $j < 3; $j++){
        $imgPreview = $twitchStreams["streams"][$j]["preview"]["small"];
        $channelURL = $twitchStreams["streams"][$j]["channel"]["url"];
        $channelName = $twitchStreams["streams"][$j]["channel"]["display_name"];
        if(strlen($channelName) > 14) { $channelName = substr($channelName, 0, 13 ) . "..."; }
        $viewers = (string) ($twitchStreams["streams"][$j]["viewers"]);
        
        
        if($j == 0) { $margin = "streamLeft"; }
        else { $margin = "streamRight"; }
        
        echo "<a href=\"" . $channelURL . "\" target=\"_blank\">" . "<span id=\"" . $margin . "\"><img src=\"" . $imgPreview . "\"><span id=\"channelName\">" . $channelName . "</span><span id=\"numViewers\"><small><small>(" . $viewers . ")</small></small></span></span></a>";
    }
    echo "<br>";
    for($j = 3; $j < 6; $j++){
        $imgPreview = $twitchStreams["streams"][$j]["preview"]["small"];
        $channelURL = $twitchStreams["streams"][$j]["channel"]["url"];
        $channelName = $twitchStreams["streams"][$j]["channel"]["display_name"];
        if(strlen($channelName) > 14) { $channelName = substr($channelName, 0, 13 ) . "..."; }
        $viewers = (string) ($twitchStreams["streams"][$j]["viewers"]);
        
        
        if($j == 3) { $margin = "streamLeft"; }
        else { $margin = "streamRight"; }
        
        echo "<a href=\"" . $channelURL . "\" target=\"_blank\">" . "<span id=\"" . $margin . "\" style=\"margin-top:28px\"><img src=\"" . $imgPreview . "\"><span id=\"channelName\">" . $channelName . "</span><span id=\"numViewers\"><small><small>(" . $viewers . ")</small></small></span></span></a>";
    }
    echo "<br>";
    for($j = 6; $j < 9; $j++){
        $imgPreview = $twitchStreams["streams"][$j]["preview"]["small"];
        $channelURL = $twitchStreams["streams"][$j]["channel"]["url"];
        $channelName = $twitchStreams["streams"][$j]["channel"]["display_name"];
        if(strlen($channelName) > 14) { $channelName = substr($channelName, 0, 13 ) . "..."; }
        $viewers = (string) ($twitchStreams["streams"][$j]["viewers"]);
        
        
        if($j == 6) { $margin = "streamLeft"; }
        else { $margin = "streamRight"; }
        
        echo "<a href=\"" . $channelURL . "\" target=\"_blank\">" . "<span id=\"" . $margin . "\" style=\"margin-top:28px\"><img src=\"" . $imgPreview . "\"><span id=\"channelName\">" . $channelName . "</span><span id=\"numViewers\"><small><small>(" . $viewers . ")</small></small></span></span></a>";
    }

    echo "</div></center><br><br><br>";
    
    
    
    
    
    
    
}



?>
<br>
<hr>
<center><div id="legal"><font color="white">
<br>
<center>
All (Game, Profile, and Match) information is obtained via the Riot Games Developer API.
<br>
LoLLookup.com isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games are trademarks or registered trademarks of Riot Games, Inc. League of Legends &copy Riot Games, Inc.
</center>
<br>

</font>
</div></center>


</body>
</html>