<!DOCTYPE html>
<head>
<style type="text/css">

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
    height: 30px;
}

#rankTextLeft {
    position: relative;
    top: -9px;
    right: 6px;   
}
#rankTextLeftYellow{
    position: relative;
    top: -9px;
    right: 6px;
    color:yellow;
}
#rankTextRight {
    position: relative;
    top: -9px;
    left: 6px;  
}
#rankTextRightYellow {
    position: relative;
    top: -9px;
    left: 6px;
    color:yellow;
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

#tdTierLeft{
     text-align: left; 
     //color: black;
     padding:0px;
}

#tdTierRight{
     text-align: right; 
     //color: black;
     padding:0px;
}

#summSp1{
    position: relative;
    top:-15px;
    width:13px;
    height:13px;
    color:black;
}

#summSp2{
    position: relative;
    //top:5px;
    right:15px;
    width:13px;
    height:13px;
    color:black;
}

#summSp1Right{
    position: relative;
    top:-15px;
    left:15px;
    width:13px;
    height:13px;
    color:black;
}

#summSp2Right{
    position: relative;
    //top:5px;
    //right:15px;
    width:13px;
    height:13px;
    color:black;
}

#blue {
    //background-color: #003380;
    background: rgb(0,51,128);
    background: -moz-linear-gradient(left, rgba(0,51,128,1) 75%, rgba(27,27,27,1) 100%);
    background: -webkit-gradient(linear, left top, right top, color-stop(75%,rgba(0,51,128,1)), color-stop(100%,rgba(27,27,27,1)));
    background: -webkit-linear-gradient(left, rgba(0,51,128,1) 75%,rgba(27,27,27,1) 100%);
    background: -o-linear-gradient(left, rgba(0,51,128,1) 75%,rgba(27,27,27,1) 100%);
    background: -ms-linear-gradient(left, rgba(0,51,128,1) 75%,rgba(27,27,27,1) 100%);
    background: linear-gradient(to right, rgba(0,51,128,1) 75%,rgba(27,27,27,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#003380', endColorstr='#1b1b1b',GradientType=1 );
}

#purple {
    //background-color: #3D003D;
    background: rgb(27,27,27);
    background: -moz-linear-gradient(left, rgba(27,27,27,1) 0%, rgba(61,0,61,1) 25%);
    background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(27,27,27,1)), color-stop(25%,rgba(61,0,61,1)));
    background: -webkit-linear-gradient(left, rgba(27,27,27,1) 0%,rgba(61,0,61,1) 25%);
    background: -o-linear-gradient(left, rgba(27,27,27,1) 0%,rgba(61,0,61,1) 25%);
    background: -ms-linear-gradient(left, rgba(27,27,27,1) 0%,rgba(61,0,61,1) 25%);
    background: linear-gradient(to right, rgba(27,27,27,1) 0%,rgba(61,0,61,1) 25%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1b1b1b', endColorstr='#3d003d',GradientType=1 );
}

#darkGray {
    background-color: #1B1B1B;
    width: 80px;
}
#sugItemsDiv {
    background-color: #1B1B1B; 
    width:400px;
    line-height:15px;
    height:115px;
    border:2px solid black;
    border-radius:6px;
    color:#FFFFFF;
}
#itemBuildImg {
    border:2px solid black;
    height: 45px;
    width: 45px;
}

#logo {
    height: 66px;
    width: auto;
    position:fixed;
    bottom:0px;
    left:0px;
    z-index:999;

}
.ver2 th {
    background-color: #3D003D;
}
	
body {
    background-image: url("simple_dashed.png");
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
#logo
{
    display:block;
}
a:link { color: #FFFFFF; text-decoration: none}
a:visited { color: #FFFFFF; text-decoration: underline}
a:hover { color: #FFFFFF; text-decoration: underline}
a:active { color: #FFFFFF; text-decoration: underline}

</style>

</head>
<body>

	<hr>
	<ul id="MainNavBar">
  		<li id="NavBarLi"><a href="index.php">Home</a></li>
  		<li id="NavBarLi"><a href="playerProfile.php?summoner_name=">Profile Lookup</a></li>
  		<li id="NavBarLi"><a href="aboot.html">About Us</a></li>
	</ul>
	
<hr><br>
</body>
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

function solveRoles($team, $championInfo, $champions, $spells){
    $team_roles = array(
        "JUNGLE" => "",
        "TOP" => "",
        "MID" => "",
        "BOT_AD" => "",
        "BOT_SUPP" => ""
    );
    
    $unresolvedChamps = array();
    
    for($i = 0; $i < 5; $i++){
        $role = $championInfo[$champions[ (string)($team[$i]['championId']) ]]["ROLE"];
        $summSpell1 = $spells[ (string) ($team[$i]['spell1Id']) ];
        $summSpell2 = $spells[ (string) ($team[$i]['spell2Id']) ];
        $redHerring = ( $role == "MID" && ($summSpell1 == "Exhaust" || $summSpell2 == "Exhaust") );
        // If the champion only has one 'possible' role ...
        if (strpos($role , '+') == FALSE && $team_roles[$role] == "" && !$redHerring)
            $team_roles[$role] = $team[$i];

        // Otherwise, the champion has more than one possible role
        else{
            $summSpell1 = $spells[ (string) ($team[$i]['spell1Id']) ];
    	    $summSpell2 = $spells[ (string) ($team[$i]['spell2Id']) ];
    	    // !!! CAUTION !!! EXPLOSIONS !!!
            $roles = explode("+", $role);
            // !!! CAUTION !!! EXPLOSIONS !!!
            // Check if the summoner has selected Smite and their champion can Jungle
            if( ($summSpell1 == "Smite" || $summSpell2 == "Smite") && $roles[0] == "JUNGLE" && $team_roles["JUNGLE"] == "" )
                $team_roles["JUNGLE"] = $team[$i];

            elseif( in_array("TOP", $roles) && ($summSpell1 == "Teleport" || $summSpell2 == "Teleport") && $team_roles["TOP"] == "" )
                $team_roles["TOP"] = $team[$i];
            
            elseif( in_array("MID", $roles) && $summSpell1 != "Exhaust" && $summSpell2 != "Exhaust" && $team_roles["MID"] == "")
                $team_roles["MID"] = $team[$i];


            elseif( in_array("BOT_AD", $roles) && $team_roles["BOT_AD"] == "")
                $team_roles["BOT_AD"] = $team[$i];

            elseif( in_array("BOT_SUPP", $roles) && $team_roles["BOT_SUPP"] == "")
                $team_roles["BOT_SUPP"] = $team[$i];

            else{
                $unresolvedRoles = TRUE;
                $unresolvedChamps[] = array( $champions[ (string)($team[$i]['championId']) ], $i );   
            }
        }
    }
    
    $all_roles = array("TOP", "JUNGLE", "MID", "BOT_AD", "BOT_SUPP");
    for($i = 0; $i < count($unresolvedChamps); $i++){
        
        $summonerIndex = $unresolvedChamps[$i][1];
        $summSpell1 = $spells[ (string) ($team[$summonerIndex]['spell1Id']) ];
    	$summSpell2 = $spells[ (string) ($team[$summonerIndex]['spell2Id']) ]; 
    	$role = $championInfo[$champions[ (string)($team[$summonerIndex]['championId']) ]]["ROLE"];
    	$roles = explode("+", $role);
    	
        // If Jungle has not been filled, and the summoner chose Smite, assign them jungle
        if ($team_roles["JUNGLE"] == "" && ($summSpell1 == "Smite" || $summSpell2 == "Smite"))
            $team_roles["JUNGLE"] = $team[$summonerIndex];
        // If Support has not been filled, and the summoner chose Exhaust, assign them support
        elseif ($team_roles["BOT_SUPP"] == "" && ($summSpell1 == "Exhaust" || $summSpell2 == "Exhaust"))
            $team_roles["BOT_SUPP"] = $team[$summonerIndex];
        // Otherwise assign them Top if they can play top
        elseif ($team_roles["TOP"] == "" && in_array("TOP", $roles))
            $team_roles["TOP"] = $team[$summonerIndex];
        // Otherwise assign them Mid if they can play mid
        elseif ($team_roles["MID"] == "" && in_array("MID", $roles))
            $team_roles["MID"] = $team[$summonerIndex];
        // Otherwise assign them ADC if they can play adc
        elseif ($team_roles["BOT_AD"] == "" && in_array("BOT_AD", $roles))
            $team_roles["BOT_AD"] = $team[$summonerIndex];
        // Otherwise assign them Support if they can play Support
        elseif ($team_roles["BOT_SUPP"] == "" && in_array("BOT_SUPP", $roles))
            $team_roles["BOT_SUPP"] = $team[$summonerIndex];
        
        // Things get a little weird here.
        // If we end up with an unfilled role, look at the champion that we did not assign a role to.
        // If that champion is a specialist ("only viable in one particular role") then we should look at the lane he is a specialist in.
        // If the other champion that was assigned the specialist's role, is NOT a specialist, then swap their roles.
        
        // e.g. Lulu is assigned (erroneously) the MID role. (She was supposed to be assigned SUPP) 
        // Lulu is NOT a specialist as she can viably be played SUPP and MID. 
        // We eventually get to Xerath, a (MID) specialist champion who was not assigned MID because Lulu was already assigned it.
        // The only Unfilled role is the SUPP role. We know that Xerath can not be viably played in the Supp role, so we bet that we made an error.
        // So we see that Xerath is a Mid specialist champion. ==> we're pretty sure that he should go MID.
        // So we look for who was assigned mid, we find out it was Lulu. We also see that Lulu is NOT a specialist champion.
        // We also see that Lulu can fill the only unfilled role (Support)
        // So we swap the two roles. Xerath goes mid, and Lulu goes support.
        
        else{
            foreach($team_roles as $x => $y ){
                if ( $y == "" ){
                    if(count($roles) == 1 && !(in_array($championInfo[$champions[ (string)($team_roles[$roles[0]]['championId']) ]]["ROLE"], $all_roles))){
                        $temp = $team_roles[$roles[0]];
                        $team_roles[$roles[0]] = $team[$summonerIndex];
                        $team_roles[$x] = $temp;
                        //$team_roles[$x] = $team[$summonerIndex];
                    }
                    else{
                        $team_roles[$x] = $team[$summonerIndex];
                        break;
                    }
                }      
            }
        }  
    }
    
    return $team_roles;
      
}

function sortSummoners($blue_team, $purple_team, $summoners){
    $roleList = array("TOP", "JUNGLE", "MID", "BOT_AD", "BOT_SUPP");
    for($i = 0; $i < 5; $i++){
        $sorted_summoners[$i] = $blue_team[$roleList[$i]];
    }
    for($i = 5; $i < 10; $i++){
        $sorted_summoners[$i] = $purple_team[$roleList[$i-5]];
    }
    
    return $sorted_summoners;
}


$summonerID = $_GET["summonerID"];

$champsFile = fopen("championInformation.txt", "r");
$fileContents = fread($champsFile,filesize("championInformation.txt"));
fclose($champsFile);
$championInfo = json_decode($fileContents, true);

$obj = getJSONObj('https://kr.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/KR/' . $summonerID . '?api_key=***REDACTED***');
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
    
    $blue_team = array(
        $obj['participants'][0],
        $obj['participants'][1],
        $obj['participants'][2],
        $obj['participants'][3],
        $obj['participants'][4],
    ); 
    
    $purple_team= array(
        $obj['participants'][5],
        $obj['participants'][6],
        $obj['participants'][7],
        $obj['participants'][8],
        $obj['participants'][9]
    ); 
    //for($i = 0; $i < 5; $i++){ echo $blue_team[$i]["summonerName"]; }
    $blue_team_roles = solveRoles($blue_team, $championInfo, $champions, $spells);
    $purple_team_roles = solveRoles($purple_team, $championInfo, $champions, $spells);
     
    // Get searched-Summoner's Name, Champion, Role, and Lane Opponent 
    for($i = 0; $i < 10; $i++){
        if((string)($summoners[$i]["summonerId"]) == $summonerID){
            $playerChamp = $champions[ (string)($summoners[$i]['championId']) ];
            $playerTeam = (string)($summoners[$i]['teamId']);
            $playerName = $summoners[$i]['summonerName'];
            if($playerTeam == "100"){
                foreach($blue_team_roles as $xRole => $xPlayer ){
                    if ( $champions[ (string)($xPlayer['championId']) ] == $playerChamp ){
                        $playerRole = $xRole;
                        $laneOpponent = $purple_team_roles[$playerRole];
                        break;
                    }    
               }
            }
            else{
                foreach($purple_team_roles as $yRole => $yPlayer ){
                   if ( $champions[ (string)($yPlayer['championId']) ] == $playerChamp ){
                       $playerRole = $yRole;
                       $laneOpponent = $blue_team_roles[$playerRole];
                       break;
                   }
                    
               }
            
            }
   
        }
        
    }
    
    $summoners = sortSummoners($blue_team_roles, $purple_team_roles, $summoners);
    
    
    echo "<br><center><table id=\"curGameTable1\"><tr><th id=\"blue\"><b>Blue Team</b></th><th id=\"darkGray\">Role</th><th id=\"purple\"><b>Purple Team</b></th></tr>";
    
    $roleList = array("Top", "Jungle", "Mid", "ADC", "Support");
    
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
            echo "<span id=\"rankTextLeftYellow\">" . $summoners[$i]['summonerName'] . "</span>";
            //echo "<span style=\"color:yellow\">" . $summoners[$i]['summonerName'] . "</span>";
        }
        else
            echo "<span id=\"rankTextLeft\">" . $summoners[$i]['summonerName'] . "</span>";

        //echo "<td><img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" title=\"" . $summSpell1 . "\" style=\"width:25px;height:25px;color:black;\"> ";
        //echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" title=\"" . $summSpell2 . "\" style=\"width:25px;height:25px;color:black;\">";
        echo "</td>";   
        
        // Column - Role
        
        echo "<td>" . $roleList[$i] . "</td><td id=\"tdTierRight\">";
        
        // Column - Purple Team Summoner
        $summSpell1 = $spells[ (string) ($summoners[$i+5]['spell1Id']) ];
    	$summSpell2 = $spells[ (string) ($summoners[$i+5]['spell2Id']) ];
    	$championName = $champions[ (string)($summoners[$i+5]['championId']) ];
    	
        if($summoners[$i+5]['summonerName'] == $playerName){
            echo "<span id=\"rankTextRightYellow\">" . $summoners[$i+5]['summonerName'] . "</span>";
            //echo "<span style=\"color:yellow\">" . $summoners[$i+5]['summonerName'] . "</span>";
        }
        else
            echo "<span id=\"rankTextRight\">" . $summoners[$i+5]['summonerName'] . "</span>";
        
        echo "<img src=\"/spell_icons/" . $summSpell1  . ".png\" border=\"1\" id=\"summSp1Right\" title=\"" . $summSpell1 . "\">";
        echo "<img src=\"/spell_icons/" . $summSpell2  . ".png\" border=\"1\" id=\"summSp2Right\" title=\"" . $summSpell2 . "\">";
        echo "<img src=\"/champion_icons/" . str_replace(" ", "", str_replace(str_split(' '),"",$championName))  . ".png\" border=\"0\" title=\"" . $championName . "\" style=\"height:100%;width:auto;\">";
        echo "</td></tr>";
    
    
    }
    
    $itemFile = fopen("itemInformation.txt", "r");
    $itemFileContents= fread($itemFile ,filesize("itemInformation.txt"));
    fclose($itemFile );
    $itemInfo = json_decode($itemFileContents, true);
    
    echo "</table></center><br><br>";
    echo "<center><div id=\"sugItemsDiv\">";
    $associativeRoles = array("TOP" => "Top Lane", "JUNGLE" => "Jungle", "MID" => "Mid Lane", "BOT_AD" => "ADC", "BOT_SUPP" => "Support" );
    echo "<br>[" . $associativeRoles[$playerRole] . "] " . $playerChamp . " - Suggested Build <br><br>";
    $itemArray = explode("+", $championInfo[$playerChamp]["BUILDS"][$playerRole]);
    for($i = 0; $i < 6; $i++){
        echo "<img src=\"/item_icons/" . $itemArray[$i] . ".png\" id=\"itemBuildImg\" border=\"0\" title=\"". $itemInfo["data"][$itemArray[$i]]["name"] . "\">";
    }
    echo "</div></center><br><br>";

    

}
else echo "<br>JSON Call Failed";

?>




</html>