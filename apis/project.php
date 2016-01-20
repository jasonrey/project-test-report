<?php
!defined('SERVER_EXEC') && die('No access.');

class ProjectApi extends Api
{
	public function saveAssignees()
	{
		$keys = array('project', 'setting');

		if (!Req::haspost($keys)) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn) {
			return $this->fail('You are not authorized.');
		}

		$project = Req::post('project');
		$setting = json_decode(Req::post('setting'));

		$projectTable = Lib::table('project');

		if ($project !== 'all' && $project !== '-1' && !$projectTable->load(array('name' => $project))) {
			return $this->fail('No such project.');
		}

		if ($project !== 'all') {
			$projectAssignee = Lib::table('project_assignee');

			$projectAssignee->load(array('user_id' => $setting->id, 'project_id' => $projectTable->id));

			if ($setting->value) {
				$projectAssignee->store();
			} else {
				$projectAssignee->delete();
			}
		}

		return $this->success();
	}
}
