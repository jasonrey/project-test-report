<?php
!defined('SERVER_EXEC') && die('No access.');

class IndexView extends View
{
	public $googlefont = 'Roboto:300,400,500,600';
	public $css = 'index';
	public $js = array('https://apis.google.com/js/platform.js', 'library', 'index');
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

		$this->js[] = $isLoggedIn ? 'report-list' : 'login';

		if ($isLoggedIn) {
			array_shift($this->js);

			$userModel = Lib::model('user');
			$assignees = $userModel->getProjectAssignees();

			$filterState = $cookie->get('filter-state', 'pending');
			$filterAssignee = $cookie->get('filter-assignee', empty($assignees[$user->id]) ? 'all' : $user->id);
			$filterSort = $cookie->get('filter-sort', 'asc');
			$filterProject = $cookie->get('filter-project', 'all');

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

			$this->set('projects', $projects);
			$this->set('filterState', $filterState);
			$this->set('filterAssignee', $filterAssignee);
			$this->set('filterSort', $filterSort);
			$this->set('filterProject', $filterProject);
			$this->set('reports', $reports);
			$this->set('assignees', $assignees);
		}
	}
}
