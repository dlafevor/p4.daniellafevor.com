<div class="signupBody">
	<form method='post' action='/users/p_login' class="signupBody">
		<h2>Please Login</h2>
		<input type='text' name='email' placeholder="Your email" class="signupBody">
		<input type='password' name='password' placeholder="Enter your password" class="signupBody">
		<input type='submit' value='Log in' class="signupButton">
		<?php if(isset($error)): ?>
			<span class='error'>Login failed. <br>Please double check your <br>email and password.</span>
		<?php endif; ?>
		<div class="plusOnes">
			<img src="images/Minesweeper_Icon.png" width="200" height="200" alt="Minesweeper - a JavaScript App" class="minesweeperIcon">
		</div>
	</form>
</div>