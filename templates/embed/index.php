<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button"><i class="icon-feather-cross"></i></a>

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
<div id="screenshot-preview">
	<a href="javascript:void(0);" id="screenshot-preview-close-button"><i class="icon-feather-cross"></i></a>
	<div class="screenshot-preview-image">
		<img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" />
	</div>
</div>
<?php } else { ?>
<?php echo $this->loadTemplate('before-login'); ?>
<?php } ?>
