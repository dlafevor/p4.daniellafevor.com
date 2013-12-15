<!DOCTYPE html>
<html>
	<head>
		<title><?php if(isset($title)) echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<!-- Controller Specific JS/CSS -->
		<?php if(isset($client_files_head)) echo $client_files_head; ?>
		<link href="/css/master.css" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<body>
		<div class="headerBar">
			<img src="/images/barker_logo.png" width="151" height="113" alt="The Backyard Barker" title="The Backyard Barker" class="headerLogo">
			<div class="headerNav">
				<a href='/posts'>Home</a>
				<!-- Menu for users who are logged in -->
				<?php if($user): ?>
					<a href='/users/logout'>Logout</a>
					<!-- Menu options for users who are not logged in -->
				<?php else: ?>
					<a href='/users/signup'>Sign up</a>
					<a href='/users/login'>Log in</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="signupBar"></div>
		<div class="interiorBody">
			<?php if($user): ?>
				<div id="profileHeader">
					<h1><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h1>
					<?php echo $user->email ?>
					<a href="/users/profile/<?php echo $user->user_id ?>" class="profileEdit">Edit Profile</a>
				</div>
			<?php endif; ?>
			<?php if(isset($content)) echo $content; ?>
				
			<?php if(isset($client_files_body)) echo $client_files_body; ?>
			<?php if($user): ?>
				<div class="leftBar">
					<div class="controlBar">
						<a href="/posts/myposts">My Barkings!</a>
						<a href="/posts">My Pack's Barks!</a>
						<a href="/posts/allposts">All Barks!</a>
						<a href="/posts/users">Following</a>
					</div>
				</div>
			<?php else: ?>
				<div class="leftBar">
					<div class="welcomeBar">
						<img src="/images/welcome_header.png" width="103" height="30" alt="Welcome!">
						Welcome to Backyard Barker. Get to know others, and keep up with what’s going on! So start barking!
					</div>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>