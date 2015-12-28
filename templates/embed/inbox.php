<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<div id="report-item-filter">
	<form name="filter-form" id="filter-form">
		<input type="hidden" name="state" value="pending" />
		<input type="hidden" name="assignee" value="0" />
		<input type="hidden" name="sort" value="asc" />

		<div class="filter-title">
			<i class="icon-feather-cog"></i>
		</div>
		<div class="filter-item" data-name="state">
			<div class="filter-item-selected">
				<div class="filter-item-icon">
					<div class="filter-item-state-all">
						<i class="icon-feather-clock"></i>
						<i class="icon-feather-check"></i>
						<i class="icon-feather-cross"></i>
					</div>
				</div>
				<div class="filter-item-text">State</div>
			</div>

			<div class="filter-item-options">
				<div class="filter-item-option active" data-value="all">
					<div class="filter-item-icon">
						<div class="filter-item-state-all">
							<i class="icon-feather-clock"></i>
							<i class="icon-feather-check"></i>
							<i class="icon-feather-cross"></i>
						</div>
					</div>
					<div class="filter-item-text">All</div>
				</div>
				<div class="filter-item-option" data-value="pending">
					<div class="filter-item-icon">
						<i class="icon-feather-clock"></i>
					</div>
					<div class="filter-item-text">Pending</div>
				</div>
				<div class="filter-item-option" data-value="completed">
					<div class="filter-item-icon">
						<i class="icon-feather-check"></i>
					</div>
					<div class="filter-item-text">Completed</div>
				</div>
				<div class="filter-item-option" data-value="rejected">
					<div class="filter-item-icon">
						<i class="icon-feather-cross"></i>
					</div>
					<div class="filter-item-text">Rejected</div>
				</div>
			</div>
		</div>
		<div class="filter-item" data-name="assignee">
			<div class="filter-item-selected">
				<div class="filter-item-icon">
					<div class="filter-item-assignee-image-all">
						<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
						<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
						<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
					</div>
				</div>
				<div class="filter-item-text">Fixer</div>
			</div>
			<div class="filter-item-options">
				<div class="filter-item-option active" data-value="*">
					<div class="filter-item-icon">
						<div class="filter-item-assignee-image-all">
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
							<div class="filter-item-assignee-image"><i class="icon-feather-head"></i></div>
						</div>
					</div>
					<div class="filter-item-text">All</div>
				</div>
				<div class="filter-item-option" data-value="0">
					<div class="filter-item-icon">
						<div class="filter-item-assignee-image filter-item-assignee-image-unassigned"><i class="icon-">?</i></div>
					</div>
					<div class="filter-item-text">Unassigned</div>
				</div>
				<div class="filter-item-option" data-value="1">
					<div class="filter-item-icon">
						<div class="filter-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					</div>
					<div class="filter-item-text">Jason</div>
				</div>
				<div class="filter-item-option" data-value="2">
					<div class="filter-item-icon">
						<div class="filter-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
					</div>
					<div class="filter-item-text">Jason</div>
				</div>
			</div>
		</div>
		<div class="filter-item" data-name="sort">
			<div class="filter-item-selected">
				<div class="filter-item-icon">
					<i class="icon-feather-arrow-up"></i>
				</div>
				<div class="filter-item-text">Sort Date</div>
			</div>

			<div class="filter-item-options">
				<div class="filter-item-option active" data-value="asc">
					<div class="filter-item-icon">
						<i class="icon-feather-arrow-up"></i>
					</div>
					<div class="filter-item-text">Asc</div>
				</div>
				<div class="filter-item-option" data-value="desc">
					<div class="filter-item-icon">
						<i class="icon-feather-arrow-down"></i>
					</div>
					<div class="filter-item-text">Desc</div>
				</div>
			</div>
		</div>
	</form>
</div>
<ul id="report-item-list">
	<?php echo $this->loadTemplate('report-item'); ?>
	<?php echo $this->loadTemplate('report-item'); ?>
	<?php echo $this->loadTemplate('report-item'); ?>
</ul>
