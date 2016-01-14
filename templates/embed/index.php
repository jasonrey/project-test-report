<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button"><i class="icon-feather-cross"></i></a>

<?php if ($isLoggedIn) { ?>
<div id="report-frame" data-tab="<?php echo $user->role == USER_ROLE_ADMIN ? 'inbox' : 'report'; ?>">
	<div class="alert alert-info icon-lightbulb">Do you know that you can change the color scheme in settings?</div>
	<div id="report-tab-navs">
		<a href="javascript:void(0);" class="report-tab-nav" data-name="report"><i class="icon-feather-paper"></i><p>Report</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="inbox"><i class="icon-feather-archive"></i><p>Inbox</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="settings"><i class="icon-feather-cog"></i><p>Settings</p></a>
	</div>

	<div id="report-tab-contents">
		<div class="report-tab-content" data-name="report">
			<?php echo $this->includeTemplate('report'); ?>
		</div>
		<div class="report-tab-content" data-name="inbox">
			<?php echo $this->includeTemplate('inbox'); ?>
		</div>
		<div class="report-tab-content" data-name="settings">
			<?php echo $this->includeTemplate('settings'); ?>
		</div>
	</div>
</div>
<?php echo $this->includeTemplate('screenshot-preview'); ?>
<?php } else { ?>
<?php echo $this->loadTemplate('before-login'); ?>
<?php }
