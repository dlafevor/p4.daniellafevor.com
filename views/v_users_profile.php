<div class="signupBody">
	<br><br>
	<?php foreach($userProfile as $profile): ?>
		<form method='post' action='/users/p_profile' class="signupBody">
			<input type='text' name='firstName' placeholder="Your first name"  value="<?=$profile['firstName']?>" class="stField">
			<input type='text' name='lastName' placeholder="Your last name" value="<?=$profile['lastName']?>" class="stField">
			<input type='text' name='email' placeholder="Your email address" value="<?=$profile['email']?>" class="stField">
			<input type='text' name='userCity' placeholder="The city where you live" value="<?=$profile['userCity']?>" class="stField">
			<input type='text' name='userState' placeholder="The state in which you live" value="<?=$profile['userState']?>" class="stField">
			<textarea name="userBio" id="userBio" placeholder="Tell us about yourself" class="signupBody"><?=$profile['userBio']?></textarea>
			<input type="submit" value="Edit Profile" class="stButton"> &nbsp;&nbsp;&nbsp; <input type="submit" value="Cancel" class="stButton">
		</form>
		<div class="userBio">
			<strong>Name</strong>: <?=$profile['firstName']?> <?=$profile['lastName']?><br>
			<strong>Email</strong>: <?=$profile['email']?><br>
			<strong>City/State</strong>: <?=$profile['userCity']?>/<?=$profile['userState']?>
			<hr>
			<?=$profile['userBio']?>
		</div>
	<?php endforeach; ?>
</div>