<?php
header("Access-Control-Allow-Origin: *");
?><!DOCTYPE html>
<html>
<head>
	<title>Chess JavaScript</title>
    <meta charset="UTF-8">
    <meta name="description" content="JavaScript implementation of chess API">
	<style type="text/css">
		.chess_board
		{
			border:1px solid #333;
			margin-left:40px;
		}
		.chess_board td
		{
			background:#fff;
			background:-moz-linear-gradient(top,#fff,#eee);
			box-shadow:inset 0 0 0 1px #fff;
			-moz-box-shadow:inset 0 0 0 1px #fff;
			-webkit-box-shadow:inset 0 0 0 1px #fff;
			height:40px;
			text-align:center;
			vertical-align:middle;
			width:40px;
			font-size:30px;
		}
		.chess_board tr:nth-child(odd) td:nth-child(even),.chess_board tr:nth-child(even) td:nth-child(odd)
		{
			background:#ccc;
			background:-moz-linear-gradient(top,#ccc,#eee);
			box-shadow:inset 0 0 10px rgba(0,0,0,.4);
			-moz-box-shadow:inset 0 0 10px rgba(0,0,0,.4);
			-webkit-box-shadow:inset 0 0 10px rgba(0,0,0,.4);
		}
		.horizontallabels td,.verticallabels td
		{
			height:38px;
			text-align:center;
			vertical-align:middle;
			width:36px;
			font-size:29px;
		}
		.verticallabels
		{
			float:left;
			width:40px
		}
		.statusHTMLClass
		{
			font-size: 30px;
			color: red;
		}
	</style>
</head>
<body>
	<section>
		<table class="verticallabels">
			<tr>
				<td>8<td>
			</tr>
			<tr>
				<td>7<td>
			</tr>
			<tr>
				<td>6<td>
			</tr>
			<tr>
				<td>5<td>
			</tr>
			<tr>
				<td>4<td>
			</tr>
			<tr>
				<td>3<td>
			</tr>
			<tr>
				<td>2<td>
			</tr>
			<tr>
				<td>1<td>
			</tr>
		</table>
		<table class="chess_board" cellspacing="0" cellpadding="0" id="chessBoard">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr><tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<table class="horizontallabels">
			<tr>
				<td>a</td>
				<td>b</td>
				<td>c</td>
				<td>d</td>
				<td>e</td>
				<td>f</td>
				<td>g</td>
				<td>h</td>
			</tr>
		</table>
	</section>
	<div id="statusHTML" class="statusHTMLClass"></div>
</body>
<script type="text/javascript" src="chessgameinterface.js"></script>
<script type="text/javascript" src="chessgame.js"></script>
<script type="text/javascript">
	let chessBoardHTML=document.getElementById('chessBoard'), statusHTML=document.getElementById('statusHTML');
	const chessGameInterface=new ChessGameInterface(chessBoardHTML);
	let chessGame=new ChessGame("chess-api-chess.herokuapp.com", 80);
	let humanPlayerLetterMove=[null, null], humanPlayerHTMLMove=[null, null];
	let globGameOver=false;

	for (let i = 0; i < chessBoardHTML.rows.length; i++) {
        for (let j = 0; j < chessBoardHTML.rows[i].cells.length; j++) {
        	chessBoardHTML.rows[i].cells[j].onclick = function () {
            	chessBoardHTMLClickCell(this, i, j);
        	};
        }
    }

	chessGame.newGame(changeFen);

	function changeFen() {
		chessGame.getCurrentFen(function(fen) {
			chessGameInterface.fillHTMLTableFromFen(fen);
		});
		chessGame.checkGameOver(function(gameOver) {
			if(gameOver) {
				globGameOver=true;
				statusHTML.innerHTML="Game-over";
			}
		});
	}

	function chessBoardHTMLClickCell(chessBoardHTMLCell, i, j) {
		if(globGameOver) {
			return;
		}
		let lettersChessBoard="abcdefgh";
		let arrayLettersChessBoard=Array.from(lettersChessBoard);
		let cellLetter=arrayLettersChessBoard[j]+(8-i).toString();
		statusHTML.innerHTML="";
		if(humanPlayerLetterMove[0]==null && humanPlayerHTMLMove[0]==null) {
			humanPlayerHTMLMove[0]=chessBoardHTMLCell;
			humanPlayerLetterMove[0]=cellLetter;
            humanPlayerHTMLMove[0].style.background="aqua";
			return;
		}
		if(humanPlayerLetterMove[0]!=null && humanPlayerHTMLMove[0]!=null && humanPlayerLetterMove[1]==null && humanPlayerHTMLMove[1]==null) {
			if(chessBoardHTMLCell==humanPlayerHTMLMove[0]) {
				humanPlayerHTMLMove[0].style.background="";
				humanPlayerHTMLMove[0]=null;
				humanPlayerLetterMove[0]=null;
				return;
			}
			humanPlayerHTMLMove[1]=chessBoardHTMLCell;
			humanPlayerLetterMove[1]=cellLetter;
			chessGame.playHuman(humanPlayerLetterMove[0], humanPlayerLetterMove[1], function(moveOk) {
				changeFen();
				if(!moveOk) {
					humanPlayerHTMLMove[1]=null;
					humanPlayerLetterMove[1]=null;
					statusHTML.innerHTML="Mouvement invalide";
				}
				if(moveOk) {
					humanPlayerHTMLMove[0].style.background="";
					humanPlayerHTMLMove[0]=null;
					humanPlayerLetterMove[0]=null;
					humanPlayerHTMLMove[1]=null;
					humanPlayerLetterMove[1]=null;
					chessGame.playAI(changeFen);
				}
			});
		}
	}
</script>
</html>
