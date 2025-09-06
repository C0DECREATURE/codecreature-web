"use strict";

const merchShelf = {
	init: ()=>{
		this.shelf = document.getElementById('shelves');
		this.parent = this.shelf.parentNode;
		this.rows = this.shelf.getElementsByTagName('tr'); 
		this.cols = this.shelf.getElementsByTagName('td');
	},
	resize: ()=>{
	},
}

window.addEventListener('load',merchShelf.init);