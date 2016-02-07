function getSummonerInfo(){
	
	var xmlhttp = new XMLHttpRequest();
	var sum_Name = document.getElementById('summonerName').value;
	var url = 'https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' + sum_Name + '?api_key=api_key=***REDACTED***';
	
	xmlhttp.onreadystatechange = function() {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	    	
	        var arr = JSON.parse(xmlhttp.responseText);
	        var out = "";
	        var sumNamenospace = sum_Name.replace(" ", "");
		sumNamenospace = sumNamenospace.toLowerCase().trim();
		summonerLevel = arr[sumNamenospace].summonerLevel;
		summonerID = arr[sumNamenospace].id.toString();
		getSelectedMastery(summonerID);
	    }
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function getSelectedMastery(sum_ID){
	var xmlhttp = new XMLHttpRequest();
	
	var url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/" + sum_ID + "/masteries?api_key=api_key=***REDACTED***";
	// 22421317
	xmlhttp.onreadystatechange = function() {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	    	
	        var arr = JSON.parse(xmlhttp.responseText);
	        var out = "";
		var i;
		
	        for(i = 0; i < arr[sum_ID].pages.length; i++) {
			if (arr[sum_ID].pages[i].current == true){
				out += '<b>' + arr[sum_ID].pages[i].name + '</b><br>';
			}	
		}
		document.getElementById("id01").innerHTML = out;
	    }
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
} 

function getCurGameInfo(){
	var url = "https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/26082266?api_key=api_key=***REDACTED***";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, true);
	console.log('good');

	xmlhttp.setRequestHeader('Access-Control-Allow-Headers', '*');
	xmlhttp.setRequestHeader('Content-type', 'application/ecmascript');
	xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
	console.log('ok')
	//var url = "https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/" + sum_ID + "?api_key=api_key=***REDACTED***";
	//var url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/" + sum_ID + "/masteries?api_key=api_key=***REDACTED***";
	
	
	
	xmlhttp.onreadystatechange = function() {

	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	    	alert("got it");
	    	
	    	var out = "";
	        var arr = JSON.parse(xmlhttp.responseText);
	        
	        out = arr["participants"][0].summonerName;
	        document.getElementById("id01").innerHTML = out;
	    }
	    
	}

	
	xmlhttp.send();
	return false;

}