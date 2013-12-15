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
			+1 Delete A Post<br>
			+1 View/Edit Profile
		</div>
	</form>
	<img src="/images/murphy_theBackyardBarker.png" width="191" height="344" alt="Murphy - the Backyard Barker" title="Murphy - the Backyard Barker" id="titleIcon">
</div>