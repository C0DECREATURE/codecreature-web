"use strict";

const merchShelf = {
	// called every time the window resizes
	resize: ()=>{
		// get the width of the table's parent
		let size = this.parent.offsetWidth;
		// set the table width in columns based on parent width
		if (size < 500) merchShelf.setTableWidth(3);
		else merchShelf.setTableWidth(4);
	},
	// set the width of the table, in columns
	// wrap td elements as needed to fit
	setTableWidth: (width)=>{
		// if the width being set is not the same as existing width
		if (!this.tableWidth || this.tableWidth != width) {
			console.log(`resizing #${this.table.id} table to ${width} columns`);
			// save the new width in variable
			this.tableWidth = width;
			// current table row length
			let curRows = this.rows.length;
			console.log(`initial row count: ${curRows}; goal row count: ${Math.ceil(this.cols.length / width)}`);
			console.log(`column count: ${this.cols.length}`);
			// create new rows
			for ( let i = 0; i < Math.ceil(this.cols.length / width); i++ ) {
				let newRow = document.createElement('tr');
				// add columns to the row
				for ( let c = i * width; c < Math.min((i + 1) * width, this.cols.length); c++ ) {
					let newCol = this.cols[c].cloneNode(true);
					newRow.appendChild(newCol);
				}
				// add the new row
				this.table.appendChild(newRow);
				// if there is already a row in this position
				if ( i < curRows ) {
					// delete the existing row
					this.rows[i].remove();
				}
			}
		}
	},
	// assign table elements to variables when window loads
	init: ()=>{
		this.table = document.getElementById('shelves');
		this.parent = this.table.parentNode;
		this.rows = Array.from(this.table.getElementsByTagName('tr')); 
		this.cols = Array.from(this.table.getElementsByTagName('td'));
		console.log(`rows: ${this.rows.length}; columns: ${this.cols.length}`);
		// resize immediately
		merchShelf.resize();
	},
}

// add event listeners to trigger merchShelf functions
window.addEventListener('load', merchShelf.init);
window.addEventListener('resize', merchShelf.resize);