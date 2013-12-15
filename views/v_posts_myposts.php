<div class="repeatedBodyContent">
	<h2>My Barks!</h2>
	<form id="newPostForm" method='post' action='/posts/p_add'>
    <input type="text" name='content' id='content' placeholder="Start barking!" size="65"> <input type='submit' id="newPost" value='New post'>
	</form>
	<?php foreach($myposts as $post): ?>
		<div class="followedPosts">
			<article>
				<h3><a href="delete/<?=$post['post_id']?>" class="editButtons">X</a><strong><?=$post['first_name']?> <?=$post['last_name']?></strong> <?=$post['email']?></h3>
				<p class="postContent"><?=$post['content']?></p>
				<p class="dateTime">
					<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
							<?=Time::display($post['created'])?>
					</time>
				</p>
			</article>
		</div>
	<?php endforeach; ?>
</div>