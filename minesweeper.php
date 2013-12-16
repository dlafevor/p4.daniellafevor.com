<!DOCTYPE HTML>
<html>
  <head>
	<meta charset="utf-8">
    <title>Minesweeper</title>
    <link href="css/master.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.minesweeper.js"></script>
  </head>
	<body>
		<div class="appWrapper">
			<div class="headerBar">
				<h1>Minesweeper</h1>
			</div>
			<div class="bodyWrapper">
				<div id="gameLayer"></div>
			</div>
			<div class="footerBar">
				<img src="images/icon_help.png" width="29" height="29" alt="Help"> <strong>How to Play</strong>
				<ol>
					<li>Select your difficulty</li>
					<li>Click a square.</li>
					<li>If have not clicked a square containing a mine, that square and all squares a joining it will turn blue. Squares with a number in them indicate that at least one mine is touching that square (the number corresponds to the number of mines touching that square).</li>
					<li>You can mark a square as having a mine under it by alt+clicking on the square</li>
					<li>If you click a square containing a mine the game is over ... KABLOOIE!!!</li>
				</ol>
			</div>
		</div>
		<script>
			$('#gameLayer').load('gameBoard.php');
		</script>
	</body>
</html>