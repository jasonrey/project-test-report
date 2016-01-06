<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<div class="new-project">
	<form class="new-project-content" method="post" action="<?php echo Lib::url('controller', array('controller' => 'project', 'action' => 'saveProjectTitle')); ?>">
		<h1>Hi there.</h1>
		<p>Let's name this project:</p>

		<div class="form-group">
			<input type="text" class="form-input" name="project-title" placeholder="Project Name" />
		</div>

		<div class="form-actions">
			<button class="icon-feather-check">OK</button>
		</div>

		<input type="hidden" name="project-name" value="<?php echo $name; ?>" />
	</form>
</div>
