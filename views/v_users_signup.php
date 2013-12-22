<div class="signupBody">
	<?php if(isset($error) && $error == 'blank-fields'): ?>
		<div class='error'>
				Signup Failed. All fields are required.
		</div>
	 <?php endif; ?>
	<article class="formInstructions">
		Please fill out the form below to signup. All fields are required!
	</article>
	<form method='post' action='/users/p_signup' class="signupBody">
		<input type='text' name='firstName' placeholder="Your first name" required  class="stField">
		<input type='text' name='lastName' placeholder="Your last name" required class="stField">		
		<?php if(isset($error) && $error == 'email-exists'): ?>
			<div class='error'>There is already an account associated with this email.</div>
		 <?php endif; ?>
		<input type='text' name='email' placeholder="Your email address" class="stField">
		<input type='password' name='password' placeholder="Pick a password" class="stField">
		<input type="submit" value="Sign Up for MineSweeper!" class="stButton">
	</form>
	<article class="formInstructions">
		Once you have signed up, you can change finish telling us about yourself by visiting your profile page in MineSweeper!
	</article>
</div>