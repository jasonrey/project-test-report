<?php
!defined('SERVER_EXEC') && die('No access.');

class EmbedView extends View
{
	public $googlefont = 'Roboto:300,400,500,600';
	public $css = 'embed';
	public $js = array('https://apis.google.com/js/platform.js', 'library', 'embed');
	public $meta = array();

	public function main()
	{
		$filterProject = Req::get('project');

		if (empty($filterProject)) {
			$this->template = 'empty-project';
			return;
		}

		$projectTable = Lib::table('project');

		if (!$projectTable->load(array('name' => $filterProject))) {
			$this->template = 'empty-project';
			return;
		}

		$this->meta[] = array('name' => 'google-signin-client_id', 'content' => Config::$googleClientId . '.apps.googleusercontent.com');

		$cookie = Lib::cookie();

		$identifier = $cookie->get(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		$this->set('user', $user);
		$this->set('filterProject', $filterProject);
		$this->set('isLoggedIn', $isLoggedIn);

		if ($isLoggedIn) {
			array_shift($this->js);

			$userModel = Lib::model('user');

			$assignees = $userModel->getProjectAssignees($projectTable->id);

			$filterState = $cookie->get('filter-state', 'pending');
			$filterAssignee = $cookie->get('filter-assignee', empty($assignees[$user->id]) ? 'all' : $user->id);
			$filterSort = $cookie->get('filter-sort', 'asc');

			$reportModel = Lib::model('report');

			$reports = $reportModel->getItems(array(
				'state' => constant('STATE_' . strtoupper($filterState)),
				'assignee_id' => $filterAssignee,
				'order' => 'date',
				'direction' => $filterSort,
				'project_id' => $projectTable->id
			));

			$this->set('filterState', $filterState);
			$this->set('filterAssignee', $filterAssignee);
			$this->set('filterSort', $filterSort);
			$this->set('reports', $reports);
			$this->set('assignees', $assignees);
		}
	}
}
