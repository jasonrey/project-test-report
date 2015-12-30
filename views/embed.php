<?php
!defined('SERVER_EXEC') && die('No access.');

class EmbedView extends View
{
	public $googlefont = 'Roboto:300,400,500,600';
	public $css = 'embed';
	public $js = array('https://apis.google.com/js/platform.js', 'embed');
	public $meta = array();

	public function main()
	{
		$project = Req::get('project', 'project-name');

		$this->meta[] = array('name' => 'google-signin-client_id', 'content' => Config::$googleClientId . '.apps.googleusercontent.com');

		$cookie = Lib::cookie();

		$identifier = $cookie->get(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		$this->set('user', $user);
		$this->set('project', $project);
		$this->set('isLoggedIn', $isLoggedIn);

		if ($isLoggedIn) {
			array_shift($this->js);

			$filterState = $cookie->get('filter-state', 'pending');
			$filterFixer = $cookie->get('filter-fixer', $user->id);
			$filterDate = $cookie->get('filter-date', 'asc');

			$model = Lib::model('report');

			$reports = $model->getItems(array(
				'state' => constant('STATE_' . strtoupper($filterState)),
				'direction' => $filterDate,
				'assignee_id' => $filterFixer
			));

			$this->set('reports', $reports);
			$this->set('filterState', $filterState);
			$this->set('filterFixer', $filterFixer);
			$this->set('filterDate', $filterDate);
		}
	}
}
