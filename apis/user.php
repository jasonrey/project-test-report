<?php
!defined('SERVER_EXEC') && die('No access.');

class UserApi extends Api
{
	public function authenticate()
	{
		$keys = array('gid', 'token');

		if (!Req::haspost($keys)) {
			return $this->fail();
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
}
