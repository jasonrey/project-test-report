<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<?php if ($isLoggedIn) { ?>
<div id="report-frame">
	<a class="report-item-back icon-feather-rewind" href="<?php echo Lib::url('index'); ?>">Back</a>
	<div class="report-project">
		<div class="project-name-title">Project</div>
		<div class="project-name"><?php echo $project->name; ?></div>
	</div>
	<ul id="report-item-list">
		<?php echo Lib::output('embed/report-item', array('report' => $report, 'user' => $user, 'assignees' => $assignees, 'commentsLoaded' => true)); ?>
	</ul>
</div>
<?php echo Lib::output('embed/screenshot-preview'); ?>
<?php } else { ?>
<?php echo Lib::output('embed/before-login'); ?>
<?php } ?>

<script type="text/html" id="report-item-assignee">
<a href="javascript:void(0);" class="item-assignee <?php if ($user->role == USER_ROLE_ADMIN) { ?>item-assignee-deletable<?php } ?>" data-value="{{id}}">
	<span class="item-assignee-image"><img src="{{image}}" /><?php if ($user->role == USER_ROLE_ADMIN) { ?><i class="icon-feather-cross"></i><?php } ?></span>
</a>
</script>
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
