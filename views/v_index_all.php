<div class="signupBar"></div>
<div class="signupBody">
	<form method='post' action='/users/p_login' class="signupBody">
		<input type='text' name='email' placeholder="Your email" class="signupBody">
		<input type='password' name='password' placeholder="Enter your password" class="signupBody">
		<input type='submit' value='Log in' class="signupButton">
		<?php if(isset($error)): ?>
			<span class='error'>Login failed. <br>Please double check your <br>email and password.</span>
		<?php endif; ?>
		<div class="plusOnes">
			+1 <br>
			+1
		</div>
	</form>
	<div class="leftBar">
		<img src="/images/barker_logo.png" width="151" height="113" alt="The Backyard Barker" title="The Backyard Barker" class="headerLogo">
		<div class="welcomeBar">
			<img src="/images/welcome_header.png" width="103" height="30" alt="Welcome!">
			Welcome to Backyard Barker. Get to know others, and keep up with what’s going on! So start barking!
		</div>
	</div>
	<img src="/images/murphy_theBackyardBarker.png" width="191" height="344" alt="Murphy - the Backyard Barker" title="Murphy - the Backyard Barker" id="titleIcon">
</div>