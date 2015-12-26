<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button">&times;</a>

<?php if ($isLoggedIn) { ?>
<div id="report-frame" data-tab="<?php echo $user->role == USER_ROLE_ADMIN ? 'inbox' : 'report'; ?>">
	<div id="report-tab-navs">
		<a href="javascript:void(0);" class="report-tab-nav" data-name="report"><i class="icon-feather-paper"></i><p>Report</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="inbox"><i class="icon-feather-archive"></i><p>Inbox</p></a>
	</div>

	<div id="report-tab-contents">
		<div class="report-tab-content" data-name="report">
			<?php echo $this->includeTemplate('report'); ?>
		</div>
		<div class="report-tab-content" data-name="inbox">
			<?php echo $this->includeTemplate('inbox'); ?>
		</div>
	</div>
</div>
<?php } else { ?>
<?php echo $this->loadTemplate('before-login'); ?>
<?php } ?>
