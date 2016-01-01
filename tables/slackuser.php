<?php
!defined('SERVER_EXEC') && die('No access.');

class SlackuserTable extends Table
{
	public $slack_id;
	public $team_id;
	public $name;
	public $email;
	public $date;
}
