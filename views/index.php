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
			$users = $userModel->getUsers();

			$filterState = $cookie->get('filter-state', 'pending');
			$filterAssignee = $cookie->get('filter-assignee', empty($assignees[$user->id]) ? 'all' : $user->id);
			$filterSort = $cookie->get('filter-sort', 'asc');
			$filterProject = $cookie->get('filter-project', 'all');

			$filterSettingsProject = $cookie->get('filter-settings-project', 'all');

			$projectTable = Lib::table('project');

			if ($filterProject !== 'all') {
				$projectTable->load(array('name' => $filterProject));
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

			$userSettings = $user->getSettings($filterSettingsProject)->getData();

			$interfaceSettings = $user->getSettings('-1')->getData();

			if ($interfaceSettings['color'] !== 'cyan' && $interfaceSettings['color'] !== 'custom') {
				$this->css[] = 'theme-' . str_replace(' ', '', $interfaceSettings['color']);
			}

			if ($interfaceSettings['color'] === 'custom') {
				$this->css[] = Config::getHtmlBase() . 'css/theme-custom/-1';
			}

			$categories = Lib::model('category')->getCategories([
				'projectid' => $projectTable->id
			]);

			$this->set('projects', $projects);
			$this->set('filterState', $filterState);
			$this->set('filterAssignee', $filterAssignee);
			$this->set('filterSort', $filterSort);
			$this->set('filterProject', $filterProject);
			$this->set('filterSettingsProject', $filterSettingsProject);
			$this->set('reports', $reports);
			$this->set('assignees', $assignees);
			$this->set('userSettings', $userSettings);
			$this->set('users', $users);
			$this->set('categories', $categories);
		}
	}
}
