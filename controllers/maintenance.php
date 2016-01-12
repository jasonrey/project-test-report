<?php
!defined('SERVER_EXEC') && die('No access.');

class MaintenanceController extends Controller
{
	public function populateSlackUsers()
	{
		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			echo 'You are not authorized';
			exit;
		}

		$helper = Lib::helper('slack');

		$users = $helper->getUsers();

		if ($users === false) {
			echo $helper->error;
			exit;
		}

		foreach ($users as $user) {
			$table = Lib::table('slackuser');
			$table->load(array('slack_id' => $user->id));

			$table->team_id = $user->team_id;
			$table->name = $user->name;
			$table->email = $user->email;

			$table->store();
		}

		echo 'Imported ' . count($users) . ' users.';
		exit;
	}

	public function initTables()
	{
		$db = Lib::db();

		foreach (glob(Config::getBasePath() . '/schemas/*.sql') as $file) {
			$sql = file_get_contents($file);

			$db->query($sql);
		}

		echo 'Completed';
		exit;
	}
}
