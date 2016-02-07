var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);//this initializes a new instance of socket.io by pass the http object then...

app.get('/', function(request, respond){//app is a function handler in express that you can supply to an http server
	//  / is a route handler that gets called when I hit the website home 
  respond.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){//add a socket parameter to the function to allow events
// ...then this listens on the conneciton event for incomming sockets
	socket.on('chat message', function(msg){//each socket also has a disconnect event
		//console.log('message: '+ msg);
		io.emit('chat message', msg);//instead of printing to console it prints 
	});
});

http.listen(21, function(){//the http server listens on port 3000
  //console.log('listening on *:3000');
});



