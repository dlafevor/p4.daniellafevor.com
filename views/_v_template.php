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
					<a href="/">Home</a>
					<a href="/users/profile/<?php echo $user->userID ?>" class="profileEdit">Profile</a> 
					<a href="/posts/allposts/" class="profileEdit">Scores</a>
					<a href="/users/logout">Logout</a>
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
						<!-- Menu options for users who are not logged in -->
						<div class="helpInfo">
							<img src="images/icon_help.png" width="29" height="29" alt="Help"> <strong>How to Play</strong>
							<ol>
								<li>Select your difficulty</li>
								<li>Click a square.</li>
								<li>If have not clicked a square containing a mine, that square and all squares a joining it will turn blue. Squares with a number in them indicate that at least one mine is touching that square (the number corresponds to the number of mines touching that square).</li>
								<li>You can mark a square as having a mine under it by alt+clicking on the square</li>
								<li>If you click a square containing a mine the game is over ... KABLOOIE!!!</li>
							</ol>
						</div>
					<?php else: ?>
						<a href="/">Home</a> <br>
						Not a member? <a href="/users/signup">Sign up</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>