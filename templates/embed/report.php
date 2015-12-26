<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<form id="report-form">
	<div class="form-group">
		<label for="report-screenshots" class="icon-picture">Screenshots</label>
		<div id="report-screenshots" name="report-screenshots" class="report-screenshots">
			<div id="drop-file-mask">
				<div class="drop-file-message icon-upload">Upload this image</div>
			</div>
			<button type="button" id="report-screenshot-add" class="report-screenshot"><i class="icon-plus"></i></button>
		</div>
		<input type="file" name="report-screenshot-file" id="report-screenshot-file" />
	</div>

	<div class="form-group">
		<label for="report-text" class="icon-pencil">Report</label>
		<textarea name="report-text"></textarea>
	</div>

	<input type="hidden" name="project" value="<?php echo $project; ?>" />

	<button class="form-submit">Submit</button>

	<div id="report-submitting">
		<div class="report-submitting-message report-submitting-message-loading"><i class="icon-loader icon-spin"></i></div>
		<div class="report-submitting-message report-submitting-message-completed"><i class="icon-ok"></i></div>
	</div>
</form>
<script type="text/html" id="report-screenshot-item">
<div id="{{id}}" class="report-screenshot report-screenshot-item">
	<img src="{{img}}" />
	<button type="button" class="report-screenshot-close"><i class="icon-cancel"></i></button>
</div>
</script>
