<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button">&times;</a>

<?php if ($isLoggedIn) { ?>
<div id="report-frame" data-tab="report">
	<div id="report-tab-navs">
		<a href="javascript:void(0);" class="report-tab-nav" data-name="report"><i class="icon-feather-paper"></i><p>Report</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="inbox"><i class="icon-feather-archive"></i><p>Inbox</p></a>
	</div>

	<div id="report-tab-contents">
		<div class="report-tab-content" data-name="report">
			<form id="report-form">
				<div class="form-group">
					<label for="report-screenshots">Screenshots</label>
					<div id="report-screenshots" name="report-screenshots" class="report-screenshots">
						<div id="drop-file-mask">
							<div class="drop-file-message icon-upload">Upload this image</div>
						</div>
						<button type="button" id="report-screenshot-add" class="report-screenshot"><i class="icon-plus"></i></button>
					</div>
					<input type="file" name="report-screenshot-file" id="report-screenshot-file" />
				</div>

				<div class="form-group">
					<label for="report-text">Report</label>
					<textarea name="report-text"></textarea>
				</div>

				<input type="hidden" name="project" value="<?php echo $project; ?>" />

				<button class="form-submit">Submit</button>

				<div id="report-submitting">
					<div class="report-submitting-message report-submitting-message-loading"><i class="icon-loader icon-spin"></i></div>
					<div class="report-submitting-message report-submitting-message-completed"><i class="icon-ok"></i></div>
				</div>
			</form>
		</div>
		<div class="report-tab-content">
		</div>
	</div>
</div>

<script type="text/html" id="report-screenshot-item">
<div id="{{id}}" class="report-screenshot report-screenshot-item">
	<img src="{{img}}" />
	<button type="button" class="report-screenshot-close"><i class="icon-cancel"></i></button>
</div>
</script>
<?php } else { ?>
<div id="report-login-frame">
	<div id="report-login-error">
		<p><i class="icon-attention"></i></p>
		<p>Uh oh. There was an error.</p>
		<p id="report-login-error-text">Be sure to sign in with your Compass email.</p>
	</div>

	<div id="report-login-authenticating">
		<p class="icon-clock">Authenticating</p>
	</div>

	<button type="button" id="report-login-button" class="icon-compass">Sign in with your Compass email</button>
</div>
<?php } ?>
