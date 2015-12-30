<?php
!defined('SERVER_EXEC') && die('No access.');

class Report_state_historyTable extends Table
{
	public $report_id;
	public $user_id;
	public $state;
	public $date;
}
