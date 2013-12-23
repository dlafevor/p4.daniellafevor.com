<h2>MineSweep! Top 10</h2>
<article class="formInstructions">
	<h3 class="stats">Easy</h3>
	<ul class="topTen">
		<?php foreach($topTenEasy as $topTenList): ?>
			<li>
				<?=$topTenList['gameTime']?> sec &ndash; <?=Time::display($topTenList['created'],'m-d-y G:i')?><br>
				<span class="playerName"><?=$topTenList['firstName']?> <?=$topTenList['lastName']?></span>
			</li>
		<?php endforeach ?>
	</ul>
</article>
<article class="formInstructions">
	<h3 class="stats">Medium</h3>
	<ul class="topTen">
		<?php foreach($topTenMed as $topTenListMed): ?>
			<li>
				<?=$topTenListMed['gameTime']?> sec &ndash; <?=Time::display($topTenListMed['created'],'m-d-y G:i')?><br>
				<span class="playerName"><?=$topTenListMed['firstName']?> <?=$topTenListMed['lastName']?></span>
			</li>
		<?php endforeach ?>
	</ul>
</article>
<article class="formInstructions">
	<h3 class="stats">Difficult</h3>
	<ul class="topTen">
		<?php foreach($topTenDif as $topTenDif): ?>
			<li>
				<?=$topTenDif['gameTime']?> sec &ndash; <?=Time::display($topTenDif['created'],'m-d-y G:i')?><br>
				<span class="playerName"><?=$topTenDif['firstName']?> <?=$topTenDif['lastName']?></span>
			</li>
		<?php endforeach ?>
	</ul>
</article>