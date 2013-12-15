<div class="signupBody">
	<?php if(isset($error) && $error == 'blank-fields'): ?>
		<div class='error'>
				Signup Failed. All fields are required.
		</div>
	 <?php endif; ?>

	<form method='post' action='/users/p_signup' class="signupBody">
		<input type='text' name='first_name' placeholder="Your first name" required  class="signupBody">
		<input type='text' name='last_name' placeholder="Your first name" required class="signupBody">		
		<?php if(isset($error) && $error == 'email-exists'): ?>
			<div class='error'>There is already an account associated with this email.</div>
		 <?php endif; ?>
		<input type='text' name='email' placeholder="Your email address" class="signupBody">
		<input type='password' name='password' placeholder="Pick a password" class="signupBody">
		<input type="submit" value="Sign Up for Backyard Barker!" class="signupButton">
	</form>
	<img src="/images/murphy_theBackyardBarker.png" width="191" height="344" alt="Murphy - the Backyard Barker" title="Murphy - the Backyard Barker" id="titleIcon">
</div>