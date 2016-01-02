<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportView extends View
{
	public $googlefont = 'Roboto:300,400,500,600';
	public $css = 'report';
	public $js = array('https://apis.google.com/js/platform.js', 'library', 'report');
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

			$id = Req::get('id');

			if (empty($id)) {
				Lib::redirect('index');
			}

			$report = Lib::table('report');

			if (!$report->load($id)) {
				$this->template = 'no-report';
				return;
			}

			$report->init();

			$assignees = array();

			if (!empty($report->assignee_id)) {
				$assignees[$report->assignee_id] = $report->assignee;
			}

			$this->set('report', $report);
			$this->set('assignees', $assignees);
		}
	}
}
