<?php
!defined('SERVER_EXEC') && die('No access.');

class IndexView extends View
{
	public $googlefont = 'Roboto:300,400,500,600';
	public $css = array('index');
	public $js = array('https://apis.google.com/js/platform.js', 'library', 'common', 'index');
	public $meta = array();

	public function main()
	{
		$this->meta[] = array('name' => 'google-signin-client_id', 'content' => Config::$googleClientId . '.apps.googleusercontent.com');

		$cookie = Lib::cookie();

		$identifier = $cookie->get(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		$this->set('user', $user);
		$this->set('isLoggedIn', $isLoggedIn);

		if (!$isLoggedIn) {
			$this->js[] = 'login';
		}

		if ($isLoggedIn) {
			$this->js[] = 'inbox';
			$this->js[] = 'settings';

			array_shift($this->js);

			$userModel = Lib::model('user');
			$assignees = $userModel->getProjectAssignees();

			$filterState = $cookie->get('filter-state', 'pending');
			$filterAssignee = $cookie->get('filter-assignee', empty($assignees[$user->id]) ? 'all' : $user->id);
			$filterSort = $cookie->get('filter-sort', 'asc');
			$filterProject = $cookie->get('filter-project', 'all');

			$filterSettingsProject = $cookie->get('filter-settings-project', 'all');

			$projectTable = Lib::table('project');
			$settingsProjectTable = Lib::table('project');

			if ($filterProject !== 'all') {
				$projectTable->load(array('name' => $filterProject));
			}

			if ($filterSettingsProject !== 'all' && $filterSettingsProject !== '-1') {
				$settingsProjectTable->load(array('name' => $filterSettingsProject));
			}

			if ($filterSettingsProject === '-1') {
				$settingsProjectTable->id = '-1';
			}

			$projectModel = Lib::model('project');

			$projects = $projectModel->getProjects(array('state' => PROJECT_STATE_ACTIVE));

			$reportModel = Lib::model('report');

			$reports = $reportModel->getItems(array(
				'state' => constant('STATE_' . strtoupper($filterState)),
				'assignee_id' => $filterAssignee,
				'order' => 'date',
				'direction' => $filterSort,
				'project_id' => $projectTable->id
			));

			$userSettingsTable = Lib::table('user_settings');

			if (!$userSettingsTable->load(array(
				'user_id' => $user->id,
				'project_id' => $filterSettingsProject == 'all' ? 0 : $settingsProjectTable->id
			)) && $filterSettingsProject !== 'all') {
				$userSettingsTable->load(array('user_id' => $user->id, 'project_id' => 0));
			}

			$userSettings = $userSettingsTable->getData();

			$interfaceSettingsTable = Lib::table('user_settings');

			if (!$interfaceSettingsTable->load(array('user_id' => $user->id, 'project_id' => '-1'))) {
				$interfaceSettingsTable->load(array('user_id' => $user->id, 'project_id' => 0));
			}

			$interfaceSettings = $interfaceSettingsTable->getData();

			if ($interfaceSettings['color'] !== 'cyan' && $interfaceSettings['color'] !== 'custom') {
				$this->css[] = 'theme-' . str_replace(' ', '', $interfaceSettings['color']);
			}

			if ($interfaceSettings['color'] === 'custom') {
				$this->css[] = Config::getHtmlBase() . 'css/theme-custom/-1';
			}

			$this->set('projects', $projects);
			$this->set('filterState', $filterState);
			$this->set('filterAssignee', $filterAssignee);
			$this->set('filterSort', $filterSort);
			$this->set('filterProject', $filterProject);
			$this->set('filterSettingsProject', $filterSettingsProject);
			$this->set('reports', $reports);
			$this->set('assignees', $assignees);
			$this->set('userSettings', $userSettings);
		}
	}
}
