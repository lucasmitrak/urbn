
/**
 * Module dependencies.
 */
var express  = require('express');
var connect  = require('connect');
var app      = express()
var server   = require('http').createServer(app);
var port     = process.env.PORT || 8080;


// Configuration
app.use(express.static(__dirname + '/public'));
app.use(connect.logger('dev'));
app.use(connect.json());  
//app.use(connect.urlencoded());

// Routes

require('./routes/routes.js')(app);

server.listen(port);

console.log('The App runs on port ' + port);