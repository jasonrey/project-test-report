<?php
!defined('SERVER_EXEC') && die('No access.');

class EmbedView extends View
{
	public $googlefont = 'Roboto:300,400,600';
	public $css = 'embed';
	public $js = array('embed', 'https://apis.google.com/js/platform.js');
	public $meta = array();

	public function main()
	{
		$this->meta[] = array('name' => 'google-signin-client_id', 'content' => Config::$googleClientId . '.apps.googleusercontent.com');
	}
}
