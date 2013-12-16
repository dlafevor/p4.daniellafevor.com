<div id="minesweepGame">
	<div class="gameFormLayer">
		<form id="gameForm">
			<label for="gameDifficulty">Difficulty</label>: 
			<select name="gameDifficulty" id="gameDifficulty">
				<option value="">Select Difficulty</option>
				<option value="1">Easy</option>
				<option value="2">Medium</option>
				<option value="3">Hard</option>
			</select>
		</form>
	</div>
	<div class="gameNewLayer">
		<form id="newGameForm">
			<input type="button" name="newGameBtn" id="newGameBtn" value="New Game?">
		</form>
	</div>
	<img src="images/Minesweeper_Icon.png" width="200" height="200" alt="Minesweeper - a JavaScript App" class="minesweeperIcon">
	<div id="gameBoardLayer">	
		<table class="mineSweeper">
		<!--- Will be populated dynamically. --->
		</table>
	</div>
	<span id="timer"></span>
</div>

<form id="gameDataForm">
	<input type="hidden" name="gameStart" id="gameStart">
	<input type="hidden" name="gameEnd" id="gameEnd">
</form>
<script>
	$('#gameDifficulty').change(loadGameBoard);
	$('#newGameBtn').click(function(){
		$('#gameLayer').load('gameBoard.php');
		$('.appWrapper').css('width','275px');
		$('#gameBoardLayer').fadeIn('slow');
	});
</script>