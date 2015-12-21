<?php
!defined('SERVER_EXEC') && die('No access.');

class UserTable extends Table
{
	public $identifier;
	public $gid;
	public $name;
	public $email;
	public $picture;
	public $date;

	public function store()
	{
		if (empty($this->date)) {
			$this->date = date('Y-m-d H:i:s');
		}

		return parent::store();
	}
}
