<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<li class="comment-item <?php if ($comment->user_id == $user->id) { ?>comment-owner<?php } ?>" data-id="<?php echo $comment->id; ?>" title="<?php echo $comment->nick; ?>">
	<div class="comment-user-image user-avatar">
		<?php if (!empty($comment->picture)) { ?>
		<img src="<?php echo $comment->picture; ?>" />
		<?php } else { ?>
		<span class="user-avatar-initial"><?php echo $comment->initial; ?></span>
		<?php } ?>
	</div>
	<div class="comment-user-text">
		<p><?php echo $comment->content; ?></p>

		<?php if (!empty($comment->attachments)) { ?>
		<div class="comment-attachments">
			<?php foreach ($comment->attachments as $attachment) { ?>
			<a href="uploads/<?php echo $attachment->filename; ?>" target="_blank" class="comment-attachment icon-feather-paper-clip <?php if (in_array(substr($attachment->filename, -3), array('jpg', 'png'))) { ?>comment-attachment-image<?php } ?>"><?php echo $attachment->name; ?></a>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</li>
