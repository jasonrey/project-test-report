<?php
!defined('SERVER_EXEC') && die('No access.');

class UserApi extends Api
{
	public function authenticate()
	{
		$keys = array('gid', 'token');

		if (!Req::haspost($keys)) {
			return $this->fail('Insufficient data.');
		}

		$gid = Req::post('gid');
		$token = Req::post('token');

		$curl = curl_init('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $token);

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPGET => true
		));

		$result = curl_exec($curl);

		curl_close($curl);

		$data = json_decode($result);

		// Check aud
		$audSegments = explode('.', $data->aud);
		if (array_shift($audSegments) !== Config::$googleClientId) {
			return $this->fail('Hmmm. Trying to hack?');
		}

		// Check gid
		if ($gid !== $data->sub) {
			return $this->fail('You are not who you say you are!');
		}

		// Check exp
		if (date_create()->format('U') > $data->exp) {
			return $this->fail('Your session has expired. Try again.');
		}

		// Check allowed domain
		if (!empty(Config::$googleAllowedDomain) && (empty($data->hd) || Config::$googleAllowedDomain !== $data->hd)) {
			return $this->fail('Please sign in with your Compass email.');
		}

		$user = Lib::table('user');

		$user->load(array('gid' => $data->sub));

		$user->gid = $data->sub;
		$user->picture = !empty($data->picture) ? $data->picture : '';
		$user->name = $data->name;
		$user->email = $data->email;
		$user->identifier = Lib::generateHash();
		$user->nick = explode('@', $data->email)[0];

		$user->store();

		Lib::cookie(Lib::hash(Config::$userkey), $user->identifier);

		return $this->success();
	}

	public function loadSettings()
	{
		if (!Req::haspost('project')) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn) {
			return $this->fail('You are not authorized.');
		}

		$project = Req::post('project');

		$projectTable = Lib::table('project');

		if ($project !== 'all' && $project !== '-1' && !$projectTable->load(array('name' => $project))) {
			return $this->fail('No such project.');
		}

		Lib::cookie('filter-settings-project', $project);

		$userSettings = Lib::table('user_settings');

		if ($project === '-1') {
			$projectTable->id = '-1';
		}

		if (!$userSettings->load(array('user_id' => $user->id, 'project_id' => $project === 'all' ? 0 : $projectTable->id)) && $project !== 'all') {
			$userSettings->load(array('user_id' => $user->id, 'project_id' => 0));
		}

		return $this->success($userSettings->getData());
	}

	public function saveSettings()
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
			$userSettings = Lib::table('user_settings');

			if ($project === '-1') {
				$projectTable->id = '-1';
			}

			if (!$userSettings->load(array('user_id' => $user->id, 'project_id' => $projectTable->id))) {
				$userSettings->load(array('user_id' => $user->id, 'project_id' => 0));

				$userSettings->isNew = true;
				$userSettings->id = 0;
				$userSettings->project_id = $projectTable->id;
			}

			$data = $userSettings->getData();

			$data[$setting->name] = $setting->value;

			$userSettings->data = $data;

			$userSettings->store();
		} else {
			$settings = Lib::model('user_settings')->getSettings(array('user_id' => $user->id));

			if (empty($settings)) {
				$userSettings = Lib::table('user_settings');
				$userSettings->load(array('user_id' => $user->id, 'project_id' => 0));
				$data = $userSettings->getData();

				$data[$setting->name] = $setting->value;

				$userSettings->data = $data;

				$userSettings->store();
			}

			foreach ($settings as $row) {
				$data = $row->getData();

				$data[$setting->name] = $setting->value;

				$row->data = $data;

				$row->store();
			}
		}

		return $this->success();
	}
}
