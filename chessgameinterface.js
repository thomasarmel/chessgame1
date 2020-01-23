class ChessGameInterface {
	constructor(cbHTML) {
		this.chessBoardHTML=cbHTML;
		this.mapChessHTML=new Map();
		this.mapChessHTML.set("r", "&#9820;");
		this.mapChessHTML.set("n", "&#9822;");
		this.mapChessHTML.set("b", "&#9821;");
		this.mapChessHTML.set("k", "&#9818;");
		this.mapChessHTML.set("q", "&#9819;");
		this.mapChessHTML.set("p", "&#9823;");
		this.mapChessHTML.set("R", "&#9814;");
		this.mapChessHTML.set("N", "&#9816;");
		this.mapChessHTML.set("B", "&#9815;");
		this.mapChessHTML.set("K", "&#9812;");
		this.mapChessHTML.set("Q", "&#9813;");
		this.mapChessHTML.set("P", "&#9817;");
	}

	fillHTMLTableFromFen(fen) {
		let arrayFen=(fen.split(' ')[0]).split('/');
		for(let i=0; i<arrayFen.length; i++) {
			if(i>=8) {
				break;
			}
			let rowChessBoardHTML=this.chessBoardHTML.rows[i];
			let arrayRowChessBoardFen=Array.from(arrayFen[i]);
			let cellNumber=0;
			for(let j=0; j<arrayRowChessBoardFen.length; j++) {
				let cellChessBoardHTML=rowChessBoardHTML.cells[j];
				if(arrayRowChessBoardFen[j].match(/[0-9]/i)) {
					let numberArrayRowChessBoardFen=parseInt(arrayRowChessBoardFen[j], 10);
					for(let k=0; k<numberArrayRowChessBoardFen; k++) {
						rowChessBoardHTML.cells[cellNumber].innerHTML="";
						cellNumber++;
					}
					continue;
				}
				rowChessBoardHTML.cells[cellNumber].innerHTML=this.mapChessHTML.get(arrayRowChessBoardFen[j]);
				cellNumber++;
			}
		}
	}
}