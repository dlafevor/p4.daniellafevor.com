<div class="signupBody">
	<br><br>
	<?php foreach($userProfile as $profile): ?>
		<form method='post' action='/users/p_profile' class="signupBody">
			<input type='text' name='first_name' placeholder="Your first name"  value="<?=$profile['first_name']?>" class="signupBody">
			<input type='text' name='last_name' placeholder="Your last name" value="<?=$profile['last_name']?>" class="signupBody">
			<input type='text' name='email' placeholder="Your email address" value="<?=$profile['email']?>" class="signupBody">
			<input type='text' name='userCity' placeholder="The city where you live" value="<?=$profile['userCity']?>" class="signupBody">
			<input type='text' name='userState' placeholder="The state in which you live" value="<?=$profile['userState']?>" class="signupBody">
			<textarea name="userBio" id="userBio" placeholder="Tell us about yourself" class="signupBody"><?=$profile['userBio']?></textarea>
			<input type="submit" value="Edit Profile" class="crudBTN"> &nbsp;&nbsp;&nbsp; <input type="submit" value="Cancel" class="crudBTN">
		</form>
		<div class="userBio">
			<strong>Name</strong>: <?=$profile['first_name']?> <?=$profile['last_name']?><br>
			<strong>Email</strong>: <?=$profile['email']?><br>
			<strong>City/State</strong>: <?=$profile['userCity']?>/<?=$profile['userState']?>
			<hr>
			<?=$profile['userBio']?>
		</div>
	<?php endforeach; ?>
</div>