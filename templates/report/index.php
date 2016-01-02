<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<?php if ($isLoggedIn) { ?>
<div id="report-frame">
	<ul id="report-item-list">
		<?php echo Lib::output('embed/report-item', array('report' => $report, 'user' => $user, 'assignees' => $assignees, 'commentsLoaded' => true)); ?>
	</ul>
</div>
<?php echo Lib::output('embed/screenshot-preview'); ?>
<?php } else { ?>
<?php echo Lib::output('embed/before-login'); ?>
<?php } ?>

<script type="text/html" id="comment-item">
<li class="comment-item" data-id="{{id}}">
	<div class="comment-user-image"><img src="{{image}}" /></div>
	<div class="comment-user-text"><p>{{content}}</p></div>
</li>
</script>
<script type="text/html" id="comment-item-self">
<li class="comment-item comment-owner" data-id="{{id}}" title="<?php echo $user->nick; ?>">
	<div class="comment-user-image"><img src="<?php echo $user->picture; ?>" /></div>
	<div class="comment-user-text"><p>{{content}}</p></div>
</li>
</script>
