<!DOCTYPE html>
<html>
	<head>
		<title><?php if(isset($title)) echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<!-- Controller Specific JS/CSS -->
		<?php if(isset($client_files_head)) echo $client_files_head; ?>
		<link href="/css/master.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.minesweeper.js" type="text/javascript"></script>
	</head>
	
	<body>
		<div class="appWrapper">
			<div class="headerBar">
				<h1>Minesweeper</h1>
			</div>
			<?php if($user): ?>
				<div class="welcomeBar">
					Welcome back <?php echo $user->firstName; ?>!
				</div>
				<div class="topNav">
					<a href="/users/profile/<?php echo $user->userID ?>" class="profileEdit">Profile</a> 
					<a href="/scores/" class="profileEdit">Scores</a>
				</div>
			<?php endif; ?>
			<div class="bodyWrapper">
				<div id="gameLayer">
					<?php if(isset($content)) echo $content; ?>
						
					<?php if(isset($client_files_body)) echo $client_files_body; ?>
				</div>
			</div>
			<div class="footerBar">
				<div class="footerLinks">
					<!-- Menu for users who are logged in -->
					<?php if($user): ?>
						<a href='/posts'>Home</a>
						<a href='/users/logout'>Logout</a>
						<!-- Menu options for users who are not logged in -->
					<?php else: ?>
						<a href='/posts'>Home</a> <br>
						Not a member? <a href='/users/signup'>Sign up</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>