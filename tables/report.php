<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportTable extends Table
{
	public $project_id;
	public $user_id;
	public $assignee_id;
	public $url;
	public $content;
	public $state;
	public $date;
}
