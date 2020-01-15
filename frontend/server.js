var Server = require('ws').Server;
var port = process.env.PORT || 9030;
var ws = new Server({port: port});
var s;

ws.on('connection', function(w){
  s = w;

  w.on('message', function(msg){
    console.log(msg);
  });

  w.on('close', function() {
    console.log('closing connection');
  });

  // var interval = setInterval(() => w.send(`counter/${Date.now()}$`), 1);
});
