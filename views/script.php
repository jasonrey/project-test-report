<?php
!defined('SERVER_EXEC') && die('No access.');

class ScriptView extends View
{
	public function display()
	{
		$type = Req::get('type');

		$this->$type();
	}

	public function js()
	{
		header('Content-Type: application/javascript');

		$script = Req::get('script');

		switch ($script) {
			case 'reporting':
				$project = Req::get('name', 'sample-project');
				$iframepath = Config::getHTMLBase() . Config::$iframepath . '?project=' . $project;

				$this->set('iframepath', $iframepath);

				echo $this->output('js/' . $script);
			break;
		}
	}

	public function css()
	{
		header('Content-Type: text/css');

		$script = Req::get('script');

		switch($script) {
			case 'theme-custom':
				$identifier = Lib::cookie(Lib::hash(Config::$userkey));

				$user = Lib::table('user');

				$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

				if (!$isLoggedIn) {
					echo '';
					return;
				}

				$project = Req::get('name');

				$projectTable = Lib::table('project');

				if ($project !== 'all' && $project !== '-1' && !$projectTable->load(array('name' => $project))) {
					echo '';
					return;
				}

				$userSettingsTable = Lib::table('user_settings');

				if ($project === '-1') {
					$projectTable->id = '-1';
				}

				if (!$userSettingsTable->load(array('user_id' => $user->id, 'project_id' => $project === 'all' ? 0 : $projectTable->id)) && $project !== 'all') {
					$userSettingsTable->load(array('user_id' => $user->id, 'project_id' => 0));
				}

				$userSettings = $userSettingsTable->getData();

				$basecss = $this->output('css/theme-custom');

				$keys = array(50, 100, 200, 300, 400, 500, 600, 700, 800, 900);

				$search = array();
				$replace = array();

				foreach ($keys as $key) {
					$search[] = '"@@color' . $key. '"';
					$replace[] = '#' . $userSettings['color' . $key];
				}

				$css = str_replace($search, $replace, $basecss);

				echo $css;
			break;
		}
	}
}
