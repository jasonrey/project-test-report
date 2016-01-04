<?php
!defined('SERVER_EXEC') && die('No access.');

class UserTable extends Table
{
	public $identifier;
	public $gid;
	public $name;
	public $nick;
	public $initial;
	public $email;
	public $picture;
	public $role;
	public $date;

	public function getSettings($project = null)
	{
		$projectId = 0;

		if (!empty($project) && $project !== 'all' && $project !== '-1') {
			$projectTable = Lib::table('project');
			$projectTable->load(array('name' => $project));

			$projectId = $projectTable->id;
		}

		if ($project === '-1') {
			$projectId = '-1';
		}

		$userSettingsTable = Lib::table('user_settings');

		if (empty($project) ||
			$project === 'all' ||
			!$userSettingsTable->load(array('user_id' => $this->id, 'project_id' => $projectId))) {
			$userSettingsTable->load(array('user_id' => $this->id, 'project_id' => 0));
		}

		return $userSettingsTable;
	}
}
