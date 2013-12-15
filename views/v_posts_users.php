<div class="repeatedBodyContent">
	<h2>All Barkers</h2>
	<?php foreach($users as $user): ?>
		<div class="followedPosts">
			<!-- Print this user's name -->
			<strong><?=$user['first_name']?> <?=$user['last_name']?></strong>
			<!-- If there exists a connection with this user, show a unfollow link -->
			<?php if(isset($connections[$user['user_id']])): ?>
					<a href='/posts/unfollow/<?=$user['user_id']?>' class="editButtons">Unfollow</a>
			<!-- Otherwise, show the follow link -->
			<?php else: ?>
					<a href='/posts/follow/<?=$user['user_id']?>' class="editButtons">Follow</a>
			<?php endif; ?>
			 <strong>From</strong>: <?=$user['userCity']?>, <?=$user['userState']?><br>
			<strong>Bio</strong>: <?=$user['userBio']?>
		</div>
	<?php endforeach; ?>
</div>