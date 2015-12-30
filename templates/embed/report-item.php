<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<li class="item" data-id="<?php echo $report->id; ?>" data-state="<?php echo $report->state; ?>">
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
				<a href="javascript:void(0);" class="item-available-assignee <?php if (!empty($report->assignee_id) && $report->assignee_id == $assignee->id) { ?>active<?php } ?>" data-value="<?php echo $assignee->id; ?>">
					<span class="item-available-assignee-image"><img src="<?php echo $assignee->picture; ?>" /></span>
				</a>
			<?php } ?>
		</div>
	</div>
	<div class="item-flexrow item-meta">
		<div class="item-comments-toggle">
			<a href="javascript:void(0);" class="item-comments-link icon-feather-speech-bubble">Comments <span class="item-comments-counter">0</span> <i class="icon-right-dir"></i></a>
		</div>
		<div class="item-assignees">
			<?php if (!empty($report->assignee_id)) { ?>
			<a href="javascript:void(0);" class="item-assignee" data-value="<?php echo $report->assignee_id ?>">
				<span class="item-assignee-image"><img src="<?php echo $assignees[$report->assignee_id]->picture; ?>" /><i class="icon-feather-cross"></i></span>
			</a>
			<?php } ?>
			<div class="item-assignee-add">
				<a href="javascript:void(0);" class="item-assignee-add-button"><i class="icon-wrench"></i></a>
			</div>
		</div>
	</div>
	<div class="item-comments">
		<div class="item-comments-content">
			<ul class="comment-item-list">
				<li class="comment-item">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Hello world</p></div>
				</li>
				<li class="comment-item comment-owner">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Hello world to you too!</p></div>
				</li>
				<li class="comment-item">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
				</li>
				<li class="comment-item">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Hello world</p></div>
				</li>
				<li class="comment-item comment-owner">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Hello world to you too!</p></div>
				</li>
				<li class="comment-item">
					<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
				</li>
			</ul>
			<div class="comment-reply">
				<input type="text" class="comment-reply-input" placeholder="Your comment..." />
				<a href="javascript:void(0);" class="comment-reply-button icon-feather-reply">Reply</a>
			</div>
		</div>
	</div>
</li>
