<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<?php if ($isLoggedIn) { ?>
<div id="report-frame" data-tab="inbox">
	<div id="report-tab-navs">
		<a href="javascript:void(0);" class="report-tab-nav" data-name="inbox"><i class="icon-feather-archive"></i><p>Inbox</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="settings"><i class="icon-feather-cog"></i><p>Settings</p></a>
	</div>

	<div id="report-tab-contents">
		<div class="report-tab-content" data-name="inbox">
			<?php echo Lib::output('embed/inbox', array(
				'projects' => $projects,
				'filterState' => $filterState,
				'filterAssignee' => $filterAssignee,
				'filterSort' => $filterSort,
				'filterProject' => $filterProject,
				'reports' => $reports,
				'assignees' => $assignees,
				'showProjectsFilter' => true,
				'user' => $user
			)); ?>
		</div>
		<div class="report-tab-content" data-name="settings">
			<?php echo Lib::output('embed/settings', array(
				'projects' => $projects,
				'filterSettingsProject' => $filterSettingsProject,
				'userSettings' => $userSettings,
				'showProjectsFilter' => true,
				'user' => $user,
				'assignees' => $assignees,
				'users' => $users,
				'categories' => $categories
			)); ?>
		</div>
	</div>
</div>
<?php echo Lib::output('embed/screenshot-preview'); ?>
<?php } else { ?>
<?php echo Lib::output('embed/before-login'); ?>
<?php } ?>
