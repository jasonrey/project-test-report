<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<div id="report-item-filter">
	<div class="report-item-filter-header">
		<div class="filter-title">
			<i class="icon-filter"></i>
		</div>
		<div class="filter-item filter-item-state" data-state="ok">
			<div class="filter-item-selected filter-item-icon">
				<i class="icon-clock"></i>
				<i class="icon-ok"></i>
				<i class="icon-cancel"></i>
			</div>
			<div class="filter-item-text">State</div>

			<div class="filter-item-options">
				<div class="filter-item-option" data-value="clock">
					<div class="filter-item-icon">
						<i class="icon-clock"></i>
					</div>
					<div class="filter-item-text">Pending</div>
				</div>
				<div class="filter-item-option" data-value="ok">
					<div class="filter-item-icon">
						<i class="icon-ok"></i>
					</div>
					<div class="filter-item-text">Completed</div>
				</div><div class="filter-item-option" data-value="cancel">
					<div class="filter-item-icon">
						<i class="icon-cancel"></i>
					</div>
					<div class="filter-item-text">Rejected</div>
				</div>
			</div>
		</div>
		<div class="filter-item filter-item-assignee">
			<div class="filter-item-icon">
				<div class="filter-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
			</div>
			<div class="filter-item-text">Fixer</div>
		</div>
		<div class="filter-item filter-item-sort">
			<div class="filter-item-icon">
				<i class="icon-sort-up"></i>
			</div>
			<div class="filter-item-text">Sort Date</div>
		</div>
	</div>

</div>
<ul id="report-item-list">
	<?php echo $this->loadTemplate('report-item'); ?>
	<?php echo $this->loadTemplate('report-item'); ?>
	<?php echo $this->loadTemplate('report-item'); ?>
</ul>
