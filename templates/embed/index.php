<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button">&times;</a>

<?php if ($isLoggedIn) { ?>
<div id="report-frame">
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

		<div class="form-actions">
			<button>Submit</button>
		</div>
	</form>
</div>

<script type="text/html" id="report-screenshot-item">
<div id="{{id}}" class="report-screenshot">
	<img src="{{img}}" />
	<div class="report-screenshot-upload"><i class="icon-clock"></i></div>
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
