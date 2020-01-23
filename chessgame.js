class ChessGame {
	constructor(host, port) {
		this.host=host;
		this.port=port;
		this.gameId=null;
	}

	getXDomainRequest() {
		var xdr = null;
		if (window.XDomainRequest) {
			xdr = new XDomainRequest(); 
		} else if (window.XMLHttpRequest) {
			xdr = new XMLHttpRequest(); 
		} else {
			alert("Votre navigateur ne gère pas l'AJAX cross-domain !");
		}
		return xdr;	
	}

	newGame(callback) {
		let xhttp=this.getXDomainRequest();
		if(xhttp==null) {
			return;
		}
		let thisChessGame=this;
		xhttp.onreadystatechange = function() {
  			if (this.readyState == 4 && this.status == 200) {
  				const JSONreturn=JSON.parse(this.responseText);
  				thisChessGame.gameId=JSONreturn.game_id;
  				if (callback && typeof(callback) === "function") {
					callback();
				}
  			}
		};
		xhttp.open("GET", "http://"+this.host+":"+this.port.toString()+"/api/v1/chess/one", true);
		xhttp.send();
	}

	getCurrentFen(callback) {
		let xhttp=this.getXDomainRequest();
		if(xhttp==null) {
			return;
		}
		xhttp.onreadystatechange = function() {
  			if (this.readyState == 4 && this.status == 200) {
  				const JSONreturn=JSON.parse(this.responseText);
  				if (callback && typeof(callback) === "function" && !JSONreturn.game_over_status) {
					callback(JSONreturn.fen_string);
				}
  			}
		};
		xhttp.open("POST", "http://"+this.host+":"+this.port.toString()+"/api/v1/chess/one/fen", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("game_id="+this.gameId);
	}

	playAI(callback) {
		let xhttp=this.getXDomainRequest();
		if(xhttp==null) {
			return;
		}
		xhttp.onreadystatechange = function() {
  			if (this.readyState == 4 && this.status == 200) {
  				if (callback && typeof(callback) === "function") {
					callback();
				}
  			}
		};
		xhttp.open("POST", "http://"+this.host+":"+this.port.toString()+"/api/v1/chess/one/move/ai", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("game_id="+this.gameId);
	}

	playHuman(from, to, callback) {
		let xhttp=this.getXDomainRequest();
		if(xhttp==null) {
			return;
		}
		xhttp.onreadystatechange = function() {
  			if (this.readyState == 4 && this.status == 200) {
  				const JSONreturn=JSON.parse(this.responseText);
  				let moveOk=false;
  				if(JSONreturn.status=="figure moved") {
  					moveOk=true;
  				}
  				if (callback && typeof(callback) === "function") {
					callback(moveOk);
				}
  			}
		};
		xhttp.open("POST", "http://"+this.host+":"+this.port.toString()+"/api/v1/chess/one/move/player", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("from="+from+"&to="+to+"&game_id="+this.gameId);
	}

	checkGameOver(callback) {
		let xhttp=this.getXDomainRequest();
		if(xhttp==null) {
			return;
		}
		xhttp.onreadystatechange = function() {
  			if (this.readyState == 4 && this.status == 200) {
  				const JSONreturn=JSON.parse(this.responseText);
  				let gameOver=true;
  				if(JSONreturn.status=="game continues") {
  					gameOver=false;
  				}
  				if (callback && typeof(callback) === "function") {
					callback(gameOver);
				}
  			}
		};
		xhttp.open("POST", "http://"+this.host+":"+this.port.toString()+"/api/v1/chess/one/check", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("game_id="+this.gameId);
	}

	getGameId() {
		console.log(this.gameId);
		return this.gameId;
	}
}