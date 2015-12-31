<?php
!defined('SERVER_EXEC') && die('No access.');

class CommentTable extends Table
{
	public $report_id;
	public $user_id;
	public $content;
	public $date;
}
