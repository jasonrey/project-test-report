<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<div id="report-item-filter">
	<form name="filter-form" id="filter-form">
		<input type="hidden" name="state" value="<?php echo $filterState; ?>" />
		<input type="hidden" name="assignee" value="<?php echo $filterAssignee; ?>" />
		<input type="hidden" name="sort" value="<?php echo $filterSort; ?>" />
		<input type="hidden" name="project" value="<?php echo $filterProject; ?>" />

		<?php if (!empty($showProjectsFilter)) { ?>
		<div class="filter-project-bar">
			<div class="filter-title">Project</div>
			<div class="filter-project form-select icon-down-dir" data-value="<?php echo $filterProject; ?>">
				<div class="form-select-highlight"></div>
				<div class="filter-project-selected form-select-selected"><?php echo $filterProject === 'all' ? 'All' : $filterProject; ?></div>

				<ul class="filter-project-list form-select-list">
					<li class="<?php if ($filterProject === 'all') { ?>active<?php } ?>">All</li>
					<?php foreach ($projects as $project) { ?>
					<li class="<?php if ($project->name === $filterProject) { ?>active<?php } ?>"><?php echo $project->name; ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php } ?>

		<div class="filter-bar">
			<div class="filter-title">Filter</div>
			<div class="filter-item" data-name="state">
				<div class="filter-item-highlight"></div>
				<div class="filter-item-selected">
					<div class="filter-item-icon">
						<?php if ($filterState === 'all') { ?>
						<div class="filter-item-state-all">
							<i class="icon-feather-clock"></i>
							<i class="icon-feather-check"></i>
							<i class="icon-feather-cross"></i>
						</div>
						<?php } elseif ($filterState === 'pending') { ?>
						<i class="icon-feather-clock"></i>
						<?php } elseif ($filterState === 'completed') { ?>
						<i class="icon-feather-check"></i>
						<?php } elseif ($filterState === 'rejected') { ?>
						<i class="icon-feather-cross"></i>
						<?php } ?>
					</div>
					<div class="filter-item-text">State</div>
				</div>

				<div class="filter-item-options">
					<div class="filter-item-option <?php if ($filterState === 'all') { ?>active<?php } ?>" data-value="all">
						<div class="filter-item-icon">
							<div class="filter-item-state-all">
								<i class="icon-feather-clock"></i>
								<i class="icon-feather-check"></i>
								<i class="icon-feather-cross"></i>
							</div>
						</div>
						<div class="filter-item-text">All</div>
					</div>
					<div class="filter-item-option <?php if ($filterState === 'pending') { ?>active<?php } ?>" data-value="pending">
						<div class="filter-item-icon">
							<i class="icon-feather-clock"></i>
						</div>
						<div class="filter-item-text">Pending</div>
					</div>
					<div class="filter-item-option <?php if ($filterState === 'completed') { ?>active<?php } ?>" data-value="completed">
						<div class="filter-item-icon">
							<i class="icon-feather-check"></i>
						</div>
						<div class="filter-item-text">Completed</div>
					</div>
					<div class="filter-item-option <?php if ($filterState === 'rejected') { ?>active<?php } ?>" data-value="rejected">
						<div class="filter-item-icon">
							<i class="icon-feather-cross"></i>
						</div>
						<div class="filter-item-text">Rejected</div>
					</div>
				</div>
			</div>
			<div class="filter-item" data-name="assignee">
				<div class="filter-item-highlight"></div>
				<div class="filter-item-selected">
					<div class="filter-item-icon">
						<?php if ($filterAssignee === 'all' || empty($assignees[$filterAssignee])) { ?>
						<div class="filter-item-assignee-image-all">
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
						</div>
						<?php } elseif ($filterAssignee === 'unassigned') { ?>
						<div class="filter-item-assignee-image filter-item-assignee-image-unassigned"><i class="icon-">?</i></div>
						<?php } else { ?>
						<div class="filter-item-assignee-image user-avatar">
							<?php if (!empty($assignees[$filterAssignee]->picture)) { ?>
							<img src="<?php echo $assignees[$filterAssignee]->picture; ?>" />
							<?php } else { ?>
							<span class="user-avatar-initial"><?php echo $assignees[$filterAssignee]->initial; ?></span>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="filter-item-text">Fixer</div>
				</div>
				<div class="filter-item-options">
					<div class="filter-item-option <?php if ($filterAssignee === 'all') { ?>active<?php } ?>" data-value="all">
						<div class="filter-item-icon">
							<div class="filter-item-assignee-image-all">
								<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
								<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
								<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
							</div>
						</div>
						<div class="filter-item-text">All</div>
					</div>
					<div class="filter-item-option <?php if ($filterAssignee === 'unassigned') { ?>active<?php } ?>" data-value="unassigned">
						<div class="filter-item-icon">
							<div class="filter-item-assignee-image filter-item-assignee-image-unassigned"><i class="icon-">?</i></div>
						</div>
						<div class="filter-item-text">Unassigned</div>
					</div>
					<?php if (!empty($assignees)) { ?>
					<?php foreach ($assignees as $assignee) { ?>
					<div class="filter-item-option <?php if ($filterAssignee == $assignee->id) { ?>active<?php } ?>" data-value="<?php echo $assignee->id; ?>">
						<div class="filter-item-icon">
							<div class="filter-item-assignee-image user-avatar">
								<?php if (!empty($assignee->picture)) { ?>
								<img src="<?php echo $assignee->picture; ?>" />
								<?php } else { ?>
								<span class="user-avatar-initial"><?php echo $assignee->initial; ?></span>
								<?php } ?>
							</div>
						</div>
						<div class="filter-item-text"><?php echo $assignee->nick; ?></div>
					</div>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
			<div class="filter-item" data-name="sort">
				<div class="filter-item-highlight"></div>
				<div class="filter-item-selected">
					<div class="filter-item-icon">
						<?php if (empty($filterSort) || $filterSort === 'asc') { ?>
						<i class="icon-feather-arrow-up"></i>
						<?php } else { ?>
						<i class="icon-feather-arrow-down"></i>
						<?php } ?>
					</div>
					<div class="filter-item-text">Sort Date</div>
				</div>

				<div class="filter-item-options">
					<div class="filter-item-option <?php if (empty($filterSort) || $filterSort === 'asc') { ?>active<?php } ?>" data-value="asc">
						<div class="filter-item-icon">
							<i class="icon-feather-arrow-up"></i>
						</div>
						<div class="filter-item-text">Asc</div>
					</div>
					<div class="filter-item-option <?php if (!empty($filterSort) && $filterSort === 'desc') { ?>active<?php } ?>" data-value="desc">
						<div class="filter-item-icon">
							<i class="icon-feather-arrow-down"></i>
						</div>
						<div class="filter-item-text">Desc</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<ul id="report-item-list">
	<?php if (!empty($reports)) { ?>
		<?php foreach ($reports as $report) { ?>
			<?php echo $this->loadTemplate('report-item', array('report' => $report, 'assignees' => $assignees, 'user'=> $user)); ?>
		<?php } ?>
	<?php } else { ?>
	<li class="item-empty">
		<p>No report found.</p>
		<a href="javascript: void(0);" class="refresh-list-button icon-sync">Refresh</a>
	</li>
	<?php } ?>
</ul>

<script type="text/html" id="report-no-result">
<li class="item-empty">
	<p>No report found.</p>
	<a href="javascript: void(0);" class="refresh-list-button icon-sync">Refresh</a>
</li>
</script>

<script type="text/html" id="report-item-assignee">
<a href="javascript:void(0);" class="item-assignee <?php if ($user->role == USER_ROLE_ADMIN) { ?>item-assignee-deletable<?php } ?>" data-value="{{id}}">
	<span class="item-assignee-image user-avatar">
		<img src="{{image}}" />
		<?php if ($user->role == USER_ROLE_ADMIN) { ?><i class="icon-feather-cross"></i><?php } ?>
	</span>
</a>
</script>
<script type="text/html" id="report-item-assignee-initial">
<a href="javascript:void(0);" class="item-assignee <?php if ($user->role == USER_ROLE_ADMIN) { ?>item-assignee-deletable<?php } ?>" data-value="{{id}}">
	<span class="item-assignee-image user-avatar">
		<span class="user-avatar-initial">{{initial}}</span>
		<?php if ($user->role == USER_ROLE_ADMIN) { ?><i class="icon-feather-cross"></i><?php } ?>
	</span>
</a>
</script>

<script type="text/html" id="comment-item-self">
<li class="comment-item comment-owner" data-id="{{id}}" title="<?php echo $user->nick; ?>">
	<div class="comment-user-image user-avatar">
		<?php if (!empty($user->picture)) { ?>
		<img src="<?php echo $user->picture; ?>" />
		<?php } else { ?>
		<span class="user-avatar-initial"><?php echo $user->initial; ?>
		<?php } ?>
	</div>
	<div class="comment-user-text">
		<p>{{content}}</p>
		<div class="comment-attachments">{{attachments}}</div>
	</div>
</li>
</script>

<script type="text/html" id="comment-form-attachment-file">
<div id="{{id}}" class="attachment-item">
	<div class="attachment-filename icon-feather-paper">{{name}}</div>
	<button type="button" class="attachment-item-delete"><i class="icon-feather-cross"></i></button>
</div>
</script>

<script type="text/html" id="comment-item-attachment-file">
<a href="javascript:void(0);" data-key="{{key}}" data-href="uploads/{{filename}}" data-name="{{name}}" target="_blank" class="comment-attachment comment-attachment-uploading icon-feather-paper-clip {{imageClass}}">Uploading...</a>
</script>
