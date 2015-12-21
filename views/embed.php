<?php
!defined('SERVER_EXEC') && die('No access.');

class EmbedView extends View
{
	public $googlefont = 'Roboto:300,400,600';
	public $css = 'embed';
	public $js = array('https://apis.google.com/js/platform.js', 'embed');
	public $meta = array();

	public function main()
	{
		$this->meta[] = array('name' => 'google-signin-client_id', 'content' => Config::$googleClientId . '.apps.googleusercontent.com');

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if ($isLoggedIn) {
			array_shift($this->js);
		}

		$this->set('isLoggedIn', $isLoggedIn);
	}
}
