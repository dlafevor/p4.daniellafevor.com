<div class="signupBody">
	<article class="formInstructions">
	Below is your profile. Please fill out any additional information you would like to share with other players.
	</article>
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
		
		<article class="formInstructions">
			<h2>Your Stats</h2>
			<h3 class="stats">Easy</h3>
			<strong>Win - Loss</strong>: <?php foreach($gamesWon as $scoreWon): ?><?=$scoreWon['gamesWon']?><?php endforeach; ?>  &ndash; <?php foreach($gamesLost as $scoreLost): ?><?=$scoreLost['gamesLost']?><?php endforeach; ?><br>
			<strong>Total Games Played</strong>: <?= $scoreLost['gamesLost'] + $scoreWon['gamesWon'] ?><br>
			<strong>Win Rate</strong>: 
			<?php
				if ($scoreWon['gamesWon'] > 0) {
					echo(round((($scoreWon['gamesWon'])/($scoreLost['gamesLost'] + $scoreWon['gamesWon'])) * 100));
				} else {
					echo '0';
				}
			?>%<br>
			<p>
				<strong>Top Ten Games</strong>:<br>
				<?php foreach($topTen as $topTenList): ?>
					<?=$topTenList['gameTime']?> sec &ndash; <?=Time::display($topTenList['created'],'m-d-y G:i')?><br>
				<?php endforeach ?>
			</p>
			<h3 class="stats">Medium</h3>
			<strong>Win - Loss</strong>: <?php foreach($gamesWonMed as $scoreWonMed): ?><?=$scoreWonMed['gamesWon']?><?php endforeach; ?>  &ndash; <?php foreach($gamesLostMed as $scoreLostMed): ?><?=$scoreLostMed['gamesLost']?><?php endforeach; ?><br>
			<strong>Total Games Played</strong>: <?= $scoreLostMed['gamesLost'] + $scoreWonMed['gamesWon'] ?><br>
			<strong>Win Rate</strong>: 
			<?php 
				if ($scoreWonMed['gamesWon'] > 0) {
					echo(round((($scoreWonMed['gamesWon'])/($scoreLostMed['gamesLost'] + $scoreWonMed['gamesWon'])) * 100));
				}  else {
					echo '0';
				}
			?>%<br>
			<p>
				<strong>Top Ten Games</strong>:<br>
				<?php foreach($topTenMed as $topTenListMed): ?>
					<?=$topTenListMed['gameTime']?> sec &ndash; <?=Time::display($topTenListMed['created'],'m-d-y G:i')?><br>
				<?php endforeach ?>
			</p>
			<h3 class="stats">Difficult</h3>
			<strong>Win - Loss</strong>: <?php foreach($gamesWonDif as $scoreWonDif): ?><?=$scoreWonDif['gamesWon']?><?php endforeach; ?>  &ndash; <?php foreach($gamesLostDif as $scoreLostDif): ?><?=$scoreLostDif['gamesLost']?><?php endforeach; ?><br>
			<strong>Total Games Played</strong>: <?= $scoreLostDif['gamesLost'] + $scoreWonDif['gamesWon'] ?><br>
			<strong>Win Rate</strong>: 
			<?php 
				if ($scoreWonDif['gamesWon'] > 0) {
					echo(round((($scoreWonDif['gamesWon'])/($scoreLostDif['gamesLost'] + $scoreWonDif['gamesWon'])) * 100));
				} else {
					echo '0';
				}
				 
			?>%<br>
			<p>
				<strong>Top Ten Games</strong>:<br>
				<?php foreach($topTenDif as $topTenListDif): ?>
					<?=$topTenListDif['gameTime']?> sec &ndash; <?=Time::display($topTenListDif['created'],'m-d-y G:i')?><br>
				<?php endforeach ?>
			</p>
		</article>
	<?php endforeach; ?>
</div>