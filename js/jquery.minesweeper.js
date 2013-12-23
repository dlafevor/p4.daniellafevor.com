$randomRange = function( minValue, maxValue ){
	// Get the range of our random values.
	var maxMinValue = (maxValue - minValue);
	// Select a random number for our range and truncate it.
	var randomValue = Math.floor( Math.random() * maxMinValue );

	return( minValue + randomValue );
};

$repeatString = function( value, count ){
	return(
		(new Array( count + 1 )).join( value )
	);
};

$.fn.randomFilter = function( size ){

	// Build an array of possible index values.
	var indexes = new Array( this.size() );

	// Loop over the size of the collection to use in the lookup array
	for (var i = 0 ; i < this.size() ; i++){
		indexes[ i ] = i;
	};

	var randomIndexes = {};
	for (var i = 0 ; i < size ; i++){
		// Select an index from the array.
		randomIndex = $randomRange( 0, indexes.length - 1 );
		// Add the selected index to the collection.
		randomIndexes[ indexes[ randomIndex ] ] = true;
		// Remove the selected index from the collection.
		indexes.splice( randomIndex, 1 );
	};

	// Return the filtered collection.
	return(
		this.filter(
			function( index ){
				return( index in randomIndexes );
			})
	);
};
$.fn.near = function(){
		var nearMines = $( [] );
		var currentCell = $( this );
		var currentRow = currentCell.parent( "tr" );
		var tbody = currentRow.parent();
		var prevRow = currentRow.prev();
		var nextRow = currentRow.next();
		var currentCellIndex = currentRow.find( "td" ).index( currentCell );
		// Check to see if there is a previous row.
		if (prevRow.size()){
			// Get the cell above the clicked cell.
			var prevRowCell = prevRow.find( "td:eq(" + currentCellIndex + ")" );
 			// Add the top 3 near cells
			nearMines = nearMines.add( prevRowCell.prev() ).add( prevRowCell ).add( prevRowCell.next() );
 		}
 
		// Add left/right near cells
		nearMines = nearMines.add( currentCell.prev() ).add( currentCell.next() );
 
		// Check to see if there is a next row.
		if (nextRow.size()){
 			// Grab the cell below the clicked cell.
			var nextRowCell = nextRow.find( "td:eq(" + currentCellIndex + ")" );
 			// Add the bottom 3 cells
			nearMines = nearMines.add( nextRowCell.prev() ).add( nextRowCell ).add( nextRowCell.next() ); 
		}
 
		// Return the collection
		return( nearMines );
	};

  // ----------------------------------------------------------------
	// Game controller.
	// ----------------------------------------------------------------
	function MineSweeper( selector, columnCount, rowCount, mineCount ){
		var self = this;
		this.table = $( selector );
		this.columnCount = (columnCount);
		this.rowCount = (rowCount);
 
		// Calc. the number of mines
		this.mineCount = Math.floor(
			(this.columnCount * this.rowCount) *
			(parseInt( mineCount ) / 100)
		);
 
		// Bind the handler to the table.
		this.table.click(
			function( event ){
				self.onClick( event );
 				event.preventDefault();
			});
 		// Initialize the table.
		this.initTable();
	};
 
 	// build table based on values when table is init. 
	MineSweeper.prototype.buildTable = function(){
		// Build the markup for a given row.
		var rowHtml = ('<tr>' + $repeatString('<td class="active">&nbsp;</td>', this.columnCount ) + '</tr>');
 		var tableHtml = $repeatString( rowHtml, this.rowCount );
 
		this.table.html( tableHtml );
	};
 
	// Load the won page if it is the end of the game and no mines have been hit
	MineSweeper.prototype.checkEndGame = function(){
		 if (!this.noMineCells.filter( '.active' ).size()){
			$('#isWon').val(1);
			var formValues = $('#gameDataForm').serialize();
			$.post('/posts/p_addGame', formValues, function(data) {
				$('#timer').replaceWith('<span id="timer"></span>');
				$('#gameBoardLayer').css('display','none').load('win.php');
			});
			
			 
		}
	};
 
	// Clear the table of any markup.
	MineSweeper.prototype.clearTable = function(){
		this.table.empty();
	};
 
 	// I initialize the table.
	MineSweeper.prototype.initTable = function(){
		var self = this;
 
		// Clear the table if there is any existing markup.
		this.clearTable();
		this.buildTable();
 
		// Gather the cells of the table.
		this.cells = this.table.find( "td" );
 
		// set near mines to 0
		this.cells.data( "nearMines", 0 );
 
		// For each cell, keep a collection of the cells that are near this cell.
		this.cells.each(
			function( index, cellNode ){
				var cell = $( this );
 
				// Store the near cells.
				cell.data( "near", cell.near() );
			});
 
		// Randomly select and gather the mine cells.
		this.mineCells = this.cells.randomFilter( this.mineCount ).addClass( "mine" );
		 
		// Get the cells without mines
		this.noMineCells = this.cells.filter(
			function( index ){
				// If this cell is not in the mines collection - it is not a mine.
				return( self.mineCells.index( this ) == -1 );
			});
 
		// Apply the near collections to each cell
		this.mineCells.each(
			function( index, node ){
				var cell = $( this );
				var nearCells = cell.data( 'near' );
		
				// For each near cell, increment the near data counter.
				nearCells.each(
					function(){
						var nearCell = $( this );
		
						// Get the current near data and increase it by one.
						nearCell.data(
							'nearMines',
							(nearCell.data( 'nearMines' ) + 1)
						);
					});
				});
			};
			
	MineSweeper.prototype.onClick = function( event ){
		// Get the trigger for the event.
		var target = $( event.target );
 
		// Check to make sure the target is an active cell - if not do nothing.
		if (!target.is( "td.active" )){
			return;
		};
  
		// Check to see if the ALT key was pressed. If yes, then toggle the caution action.
		// ALT because, well, the CTRL and Shift keys make for some odd screen display
		if (event.altKey){
			this.toggleCaution( target );
		} else {
			// Check to see if the target was a mine cell.
			if (target.is( ".mine" )){
 				// if a mine, then load the loose screen
 				$('#isWon').val(0);
				
				var formValues = $('#gameDataForm').serialize();
				$.post('/posts/p_addGame', formValues, function(data) {
					$('#gameBoardLayer').css('display','none').load('loose.php');
				});
			} else {
				this.showCell( target ); // show the cell
 			}
			this.checkEndGame();
		}
	}; 
 
	// Show the cell function
	MineSweeper.prototype.showCell = function( cell ){
		var self = this;
    cell.removeClass( "active" ).removeClass( "caution" );
 
		// Check to see if the current cell is near any mines.
		if (cell.data( "nearMines" )){
 
			// Set the content of the cell.
			cell.html( cell.data( "nearMines" ) );
		} else {
 
			// Make sure the cell has no markup.
			cell.html( "&nbsp;" );
 
			// If cell is not near a mine then reveal all surrounding cells
			cell.data( "near" ).filter( ".active" ).each(
						function( index, cellNode ){
							self.showCell( $( this ) );
						});
		}
	};
 
	// Toggle the caution on a given cell
	MineSweeper.prototype.toggleCaution = function( cell ){
		if (cell.is( ".caution" )){
 			// If there is a caution on the cell, then remove it and place a space in the cell
			cell.removeClass( "caution" );
 			cell.html( "&nbsp;" );
		} else {
			// Add caution class.
			cell.addClass( "caution" );
		}
	};
	
	// function for loading various difficulty levels and toggling visibilty of the logo, 
	// difficulty select, starts game timer, and "new game" button
	function loadGameBoard() {
		var selectDifficulty = $('#gameDifficulty').val();

		var timeSec = 0;
		var counter = setInterval(timer, 1000);
		var timeMin = 0;
		
		function timer(){
			if (timeSec !== -1) {
				timeSec=timeSec + 1;
				timeMin = parseInt(timeSec/60);
					
				$('#timer').replaceWith('<span id="timer">' + timeMin + ':' + (timeSec%60) + '</span>');
				$('#gameTime').val(timeSec);
			};
		};
		
		$(function() {
			$('#difficulty').val(selectDifficulty);
			if (selectDifficulty == 2) {
				var mineSweerper = new MineSweeper( $('table.mineSweeper'), 20, 20, 25 );
				$('.appWrapper').css('width','500px');
				$('#gameBoardLayer').fadeIn('slow');
			}
			else if (selectDifficulty == 3) {
				var mineSweerper = new MineSweeper( $('table.mineSweeper'), 30, 20, 40 );
				$('.appWrapper').css('width','750px');
				$('#gameBoardLayer').fadeIn('slow');
			}
			else if (selectDifficulty == 1){
				var mineSweerper = new MineSweeper( $('table.mineSweeper'), 10, 10, 10 );
				$('.appWrapper').css('width','275px');
				$('#gameBoardLayer').fadeIn('slow');
			}
			if (selectDifficulty !== '') {
				$('.minesweeperIcon').css('display','none');
				$('.gameFormLayer').css('display','none');
				$('.gameNewLayer').css('display','block');
			}
		});
	};