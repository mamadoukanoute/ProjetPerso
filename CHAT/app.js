	var express = require('express');
	var session = require('cookie-session'); // Charge le middleware de sessions
	var bodyParser = require('body-parser'); // Charge le middleware de gestion des paramètres
	var urlencodedParser = bodyParser.urlencoded({ extended: false });
	var app = express();
	server = require('http').createServer(app),

			io = require('socket.io').listen(server);
	var users = {};
	var login;
	io = require('socket.io').listen(server),
			 ent = require('ent'), // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)
			 fs = require('fs');
			var encode = require('ent/encode');

	/* On utilise les sessions */
	app.use(session({secret: 'todotopsecret'}))



	// Chargement de la page index.html
	app.get('/', function (req, res) {
		res.sendfile('index.html');
	});



	io.sockets.on('connection', function (socket) {
		// Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
		socket.on('new_user', function(data,callback) {
			if(data in users){

				callback(false);
			}else{
				callback(true);
				socket.pseudo=data;			
				users[socket.pseudo]=socket;
				updatelisteusers();
			}

		});

		function updatelisteusers(){
			io.sockets.emit('usernames',Object.keys(users));
		}



		// Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet au destinataire
		socket.on("send_message", function (message,callback) {
			var msgerror;
			message = encode(message);
			var ind=message.indexOf(' ');
			if(ind!=-1){
				var name=message.substring(0,ind);
				var msg=message.substring(ind+1);
				if(name in users){
					users[name].emit("whisper",{msg:msg,pseudo:socket.pseudo});


				}else{ 
					//console.log("Error:Enter a valid user");
					msgerror="Error:Enter a valid user";
					socket.emit("msgerror",msgerror);

					// callback("Error:Enter a valid user");                                
				}

			}else{
				//console.log("Error:Please enter a message for your whisper");
				msgerror="Error:Please enter a message";
				socket.emit("msgerror",msgerror);

				//callback("Error:Please enter a message for your whisper"); 

			}

		}); 


	});


	server.listen(8080);
	
	
