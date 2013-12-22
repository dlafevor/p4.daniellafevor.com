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