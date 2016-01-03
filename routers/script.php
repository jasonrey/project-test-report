<?php
!defined('SERVER_EXEC') && die('No access.');

class ScriptRouter extends Router
{
	public $allowedRoute = array('js', 'css');

	public $segments = array('type', 'script', 'name');

	public function decode($segments)
	{
		Req::set('GET', 'view', 'script');

		return parent::decode($segments);
	}
}
