<?php if($user): ?>
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
	</div>
	
	<form id="gameDataForm" action="/posts/p_addGame">
		<input type="hidden" name="gameTime" id="gameTime">
		<input type="hidden" name="isWon" id="isWon">
		<input type="hidden" name="difficulty" id="difficulty">
	</form>
	
	<script>
		$('#gameDifficulty').change(loadGameBoard);
		$('#newGameBtn').click(function(){
			$('.appWrapper').load('/index/', function(){
				$('#timer').css('display','none');
				$('#gameBoardLayer').fadeIn('slow');
			}).css('width','275px');
			
		});
	</script>
<?php else: ?>
	<div class="signupBody">
		<form method='post' action='/users/p_login' class="signupBody">
			<h2>Please Login</h2>
			<input type='text' name='email' placeholder="Your email" class="stField">
			<input type='password' name='password' placeholder="Enter your password" class="stField">
			<input type='submit' value='Log in' class="stButton">
			<?php if(isset($error)): ?>
				<span class='error'>Login failed. <br>Please double check your <br>email and password.</span>
			<?php endif; ?>
		</form>
		<img src="/images/Minesweeper_Icon.png" alt="MineSweeper!!!" name="titleIcon" width="200" height="200" id="titleIcon" title="MineSweeper!">
	</div>
<?php endif; ?>