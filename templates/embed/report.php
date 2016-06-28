<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<form id="report-form">
	<div class="form-group">
		<label for="report-screenshots" class="icon-feather-image">Screenshots</label>
		<div id="report-screenshots" name="report-screenshots" class="report-screenshots">
			<div id="drop-file-mask">
				<div class="drop-file-message icon-feather-cloud-upload">Upload this image</div>
			</div>
			<button type="button" id="report-screenshot-add" class="report-screenshot"><i class="icon-feather-plus"></i></button>
		</div>
		<input type="file" name="report-screenshot-file" id="report-screenshot-file" />
	</div>

	<div class="form-group">
		<label for="report-category" class="icon-feather-folder">Category</label>
		<select name="report-category" id="report-category">
			<?php foreach ($categories as $category) { ?>
			<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="form-group">
		<label for="report-text" class="icon-feather-clipboard">Report</label>
		<textarea name="report-text"></textarea>
	</div>

	<input type="hidden" name="project" value="<?php echo $filterProject; ?>" />

	<button class="form-submit">Submit</button>

	<div id="report-submitting">
		<div class="report-submitting-message report-submitting-message-loading">
			<div class="icon-loader">
				<span class="icon-loader-clock"></span>
				<span class="icon-loader-hour"></span>
				<span class="icon-loader-minute"></span>
			</div>
		</div>
		<div class="report-submitting-message report-submitting-message-completed"><i class="icon-feather-check"></i></div>
	</div>
</form>
<script type="text/html" id="report-screenshot-item">
<div id="{{id}}" class="report-screenshot report-screenshot-item">
	<img src="{{img}}" />
	<button type="button" class="report-screenshot-delete"><i class="icon-feather-cross"></i></button>
</div>
</script>
