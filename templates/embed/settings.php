<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<form id="settings-form" class="<?php if ($filterSettingsProject === 'all') { ?>show-warning<?php } ?>">
	<input type="hidden" name="project" value="<?php echo $filterSettingsProject; ?>" />

	<?php if (!empty($showProjectsFilter)) { ?>
	<div class="settings-project-bar">
		<div class="settings-project-title">Project</div>
		<div class="settings-project form-select icon-down-dir" data-value="<?php echo $filterSettingsProject; ?>">
			<div class="settings-project-selected form-select-selected"><?php echo $filterSettingsProject === 'all' ? 'All' : $filterSettingsProject; ?></div>

			<ul class="settings-project-list form-select-list">
				<li class="<?php if ($filterSettingsProject === 'all') { ?>active<?php } ?>">All</li>
				<?php foreach ($projects as $project) { ?>
				<li class="<?php if ($project->name === $filterSettingsProject) { ?>active<?php } ?>"><?php echo $project->name; ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="filter-project-all-warning">Any settings modification will be applied to all projects.</div>
	<?php } ?>

	<div class="form-group notification-settings">
		<label class="icon-feather-notifications">Notification</label>

		<div class="form-field" data-name="assign">
			<div class="form-checkbox <?php if ($userSettings['assign']) { ?>active<?php } ?>"></div><div class="form-title">When I've been assigned a report ticket.</div>
		</div>

		<div class="form-field" data-name="completed">
			<div class="form-checkbox <?php if ($userSettings['completed']) { ?>active<?php } ?>"></div><div class="form-title">When my ticket has been mark completed.</div>
		</div>

		<div class="form-field" data-name="rejected">
			<div class="form-checkbox <?php if ($userSettings['rejected']) { ?>active<?php } ?>"></div><div class="form-title">When my ticket has been mark rejected.</div>
		</div>

		<div class="form-field" data-name="comment-owner">
			<div class="form-checkbox <?php if ($userSettings['comment-owner']) { ?>active<?php } ?>"></div><div class="form-title">When there is a new comment in my report.</div>
		</div>

		<div class="form-field" data-name="comment-participant">
			<div class="form-checkbox <?php if ($userSettings['comment-participant']) { ?>active<?php } ?>"></div><div class="form-title">When there is a new comment in a report I've participated.</div>
		</div>
	</div>

	<div class="form-group theme-settings">
		<label class="icon-feather-color_lens">Themes</label>

		<div class="form-field" data-name="color">
			<div class="w-25">
				<div class="form-title">Color Scheme</div>
			</div>
			<div class="w-75">
				<div class="form-select icon-down-dir" data-value="<?php echo $userSettings['color']; ?>">
					<div class="form-select-selected">
						<?php if ($userSettings['color'] === 'custom') { ?>
						<i class="icon-feather-cog"></i> Custom
						<?php } else { ?>
						<?php echo ucfirst($userSettings['color']); ?>
						<?php } ?>
					</div>

					<ul class="form-select-list">
						<li class="theme-blue <?php if ($userSettings['color'] == 'blue') { ?>active<?php } ?>">Blue</li>
						<li class="theme-bluegrey <?php if ($userSettings['color'] == 'bluegrey') { ?>active<?php } ?>">Blue Grey</li>
						<li class="theme-brown <?php if ($userSettings['color'] == 'brown') { ?>active<?php } ?>">Brown</li>
						<li class="theme-cyan <?php if ($userSettings['color'] == 'cyan') { ?>active<?php } ?>">Cyan</li>
						<li class="theme-deeporange <?php if ($userSettings['color'] == 'deeporange') { ?>active<?php } ?>">Deep Orange</li>
						<li class="theme-deeppurple <?php if ($userSettings['color'] == 'deeppurple') { ?>active<?php } ?>">Deep Purple</li>
						<li class="theme-green <?php if ($userSettings['color'] == 'green') { ?>active<?php } ?>">Green</li>
						<li class="theme-grey <?php if ($userSettings['color'] == 'grey') { ?>active<?php } ?>">Grey</li>
						<li class="theme-indigo <?php if ($userSettings['color'] == 'indigo') { ?>active<?php } ?>">Indigo</li>
						<li class="theme-lightblue <?php if ($userSettings['color'] == 'lightblue') { ?>active<?php } ?>">Light Blue</li>
						<li class="theme-lightgreen <?php if ($userSettings['color'] == 'lightgreen') { ?>active<?php } ?>">Light Green</li>
						<li class="theme-pink <?php if ($userSettings['color'] == 'pink') { ?>active<?php } ?>">Pink</li>
						<li class="theme-purple <?php if ($userSettings['color'] == 'purple') { ?>active<?php } ?>">Purple</li>
						<li class="theme-red <?php if ($userSettings['color'] == 'red') { ?>active<?php } ?>">Red</li>
						<li class="theme-teal <?php if ($userSettings['color'] == 'teal') { ?>active<?php } ?>">Teal</li>
						<li data-value="Custom" class="theme-custom <?php if ($userSettings['color'] == 'custom') { ?>active<?php } ?>"><i class="icon-feather-cog"></i> Custom</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="custom-theme-settings <?php if ($userSettings['color'] == 'custom') { ?>active<?php } ?>">
			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 50</div>
					<p class="form-subtext">Light hover color</p>
					<p class="form-subtext subtext-indent">Filter menu hover, dropdown hover, dropdown showing, checkbox hover</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color50" placeholder="#color50" value="<?php echo $userSettings['color50']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 100</div>
					<p class="form-subtext">Medium hover color</p>
					<p class="form-subtext subtext-indent">Report item elements hover</p>
					<p class="form-subtext">Light border color</p>
					<p class="form-subtext subtext-indent">Filter menu border, dropdown border</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color100" placeholder="#color100" value="<?php echo $userSettings['color100']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 200</div>
					<p class="form-subtext">Hard hover color</p>
					<p class="form-subtext subtext-indent">Item elements menu activated</p>
					<p class="form-subtext">Medium border color</p>
					<p class="form-subtext subtext-indent">Item elements border</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color200" placeholder="#color200" value="<?php echo $userSettings['color200']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 300</div>
					<p class="form-subtext">Hard border color</p>
					<p class="form-subtext subtext-indent">Report form hover border</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color300" placeholder="#color300" value="<?php echo $userSettings['color300']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 400</div>
					<p class="form-subtext">Light text color</p>
					<p class="form-subtext subtext-indent">Subtext, info text, subinfo text</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color400" placeholder="#color400" value="<?php echo $userSettings['color400']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 500</div>
					<p class="form-subtext">Text color</p>
					<p class="form-subtext subtext-indent">General paragraph text, section title</p>
					<p class="form-subtext">Extra hard border color</p>
					<p class="form-subtext subtext-indent">User avatar border, focused form input border, selected tab border</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color500" placeholder="#color500" value="<?php echo $userSettings['color500']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 600</div>
					<p class="form-subtext">Inactive extra hard border color</p>
					<p class="form-subtext subtext-indent">Non-selected tab hover border</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color600" placeholder="#color600" value="<?php echo $userSettings['color600']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 700</div>
					<p class="form-subtext">Medium text color</p>
					<p class="form-subtext subtext-indent">Focused form input text</p>
					<p class="form-subtext">Element background color</p>
					<p class="form-subtext subtext-indent">Button background</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color700" placeholder="#color700" value="<?php echo $userSettings['color700']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 800</div>
					<p class="form-subtext">Button background color</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color800" placeholder="#color800" value="<?php echo $userSettings['color800']; ?>" />
				</div>
			</div>

			<div class="form-field">
				<div class="w-75">
					<div class="form-subtitle">Color 900</div>
					<p class="form-subtext">Heavy text color</p>
					<p class="form-subtext subtext-indent">Main content text, emphasized text</p>
				</div>
				<div class="w-25">
					<input type="text" maxlength="6" class="form-input" name="color900" placeholder="#color900" value="<?php echo $userSettings['color900']; ?>" />
				</div>
			</div>
		</div>
	</div>
</form>
