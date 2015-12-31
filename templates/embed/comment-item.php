<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<li class="comment-item <?php if ($comment->user_id == $user->id) { ?>comment-owner<?php } ?>" data-id="<?php echo $comment->id; ?>" title="<?php echo $comment->nick; ?>">
	<div class="comment-user-image"><img src="<?php echo $comment->picture; ?>" /></div>
	<div class="comment-user-text"><p><?php echo $comment->content; ?></p></div>
</li>
