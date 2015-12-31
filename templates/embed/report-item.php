<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<li class="item <?php if (!empty($report->assignee_id) && $report->assignee_id == $user->id) { ?>is-assignee<?php } ?>" data-id="<?php echo $report->id; ?>" data-state="<?php echo $report->state; ?>">
	<div class="item-flexrow item-header">
		<div class="item-user">
			<div class="item-user-image"><img src="<?php echo $report->picture; ?>" /></div>
		</div>
		<div class="item-details">
			<a href="javascript:void(0);" class="item-url icon-feather-link"><?php echo $report->url; ?></a>
			<div class="item-date icon-calendar"><?php echo $report->date; ?></div>
		</div>
		<div class="item-state">
			<a href="javascript:void(0);" class="item-state-option item-state-pending <?php if ($report->state == STATE_PENDING) { ?>item-state-selected<?php } ?>" data-value="0"><i class="icon-feather-clock"></i></a>
			<a href="javascript:void(0);" class="item-state-option item-state-completed <?php if ($report->state == STATE_COMPLETED) { ?>item-state-selected<?php } ?>" data-value="1"><i class="icon-feather-check"></i></a>
			<a href="javascript:void(0);" class="item-state-option item-state-rejected <?php if ($report->state == STATE_REJECTED) { ?>item-state-selected<?php } ?>" data-value="2"><i class="icon-feather-cross"></i></a>
		</div>
	</div>
	<div class="item-flexrow item-content">
		<p class="item-text"><?php echo $report->content; ?></p>

		<?php if (!empty($report->screenshots)) { ?>
		<div class="item-screenshots">
			<div class="item-screenshots-title"><i class="icon-feather-paper-clip"></i></div>
			<?php foreach ($report->screenshots as $screenshot) { ?>
			<a href="javascript:void(0);" class="item-screenshot"><img src="screenshots/<?php echo $screenshot; ?>" /></a>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<div class="item-available-assignees">
		<div class="item-available-assignees-content">
			<?php foreach ($assignees as $assignee) { ?>
				<a href="javascript:void(0);" class="item-available-assignee <?php if (!empty($report->assignee_id) && $report->assignee_id == $assignee->id) { ?>active<?php } ?> <?php if ($assignee->id == $user->id) { ?>is-self<?php } ?>" data-value="<?php echo $assignee->id; ?>">
					<span class="item-available-assignee-image"><img src="<?php echo $assignee->picture; ?>" /></span>
				</a>
			<?php } ?>
		</div>
	</div>
	<div class="item-flexrow item-meta">
		<div class="item-comments-toggle">
			<a href="javascript:void(0);" class="item-comments-link icon-feather-speech-bubble">Comments <span class="item-comments-counter"><?php echo $report->totalcomments; ?></span> <i class="icon-right-dir"></i></a>
		</div>
		<div class="item-assignees">
			<?php if (!empty($report->assignee_id)) { ?>
				<?php if ($user->role != USER_ROLE_FIXER && $user->role != USER_ROLE_ADMIN) { ?>
				<div class="item-assignee-icon"><i class="icon-wrench"></i></div>
				<?php } ?>
				<a href="javascript:void(0);" class="item-assignee <?php if ($user->role == USER_ROLE_FIXER || $user->role == USER_ROLE_ADMIN) { ?>item-assignee-deletable<?php } ?>" data-value="<?php echo $report->assignee_id ?>">
					<span class="item-assignee-image"><img src="<?php echo $assignees[$report->assignee_id]->picture; ?>" /><?php if ($user->role == USER_ROLE_FIXER || $user->role == USER_ROLE_ADMIN) { ?><i class="icon-feather-cross"></i><?php } ?></span>
				</a>
			<?php } ?>
			<?php if ($user->role == USER_ROLE_FIXER || $user->role == USER_ROLE_ADMIN) { ?>
				<div class="item-assignee-add item-assignee-icon">
					<a href="javascript:void(0);" class="item-assignee-add-button"><i class="icon-wrench"></i></a>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="item-comments">
		<div class="item-comments-content">
			<ul class="comment-item-list">
				<li class="comment-loading">
					<div class="icon-loader">
						<span class="icon-loader-clock"></span>
						<span class="icon-loader-hour"></span>
						<span class="icon-loader-minute"></span>
					</div>
				</li>
			</ul>
			<form class="comment-reply">
				<input type="text" class="comment-reply-input" placeholder="Your comment..." />
				<button class="comment-reply-button icon-feather-reply">Reply</button>
			</form>
		</div>
	</div>
</li>
