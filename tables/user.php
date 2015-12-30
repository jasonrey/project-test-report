<?php
!defined('SERVER_EXEC') && die('No access.');

class UserTable extends Table
{
	public $identifier;
	public $gid;
	public $name;
	public $nick;
	public $email;
	public $picture;
	public $role;
	public $date;
}
