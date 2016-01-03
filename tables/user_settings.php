<?php
!defined('SERVER_EXEC') && die('No access.');

class User_settingsTable extends Table
{
	public $user_id;
	public $project_id;
	public $data;
	public $date;

	public function getData()
	{
		$settings = unserialize(USER_SETTINGS);

		if (!empty($this->data)) {
			$settings = array_merge($settings, (array) json_decode($this->data));
		}

		return $settings;
	}

	public function store()
	{
		if (is_string($this->data)) {
			$data = unserialize(USER_SETTINGS);

			if (empty($this->data)) {
				$this->data = $data;
			} else {
				$this->data = array_merge($data, json_decode($this->data));
			}
		}

		if (is_array($this->data) || is_object($this->data)) {
			$this->data = json_encode($this->data);
		}

		return parent::store();
	}
}
