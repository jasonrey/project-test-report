<?php
!defined('SERVER_EXEC') && die('No access.');

class ScriptRouter extends Router
{
	public $allowedRoute = array('reporting');

	public $segments = array('script', 'project');

	public function decode($segments)
	{
		Req::set('GET', 'view', 'script');

		return parent::decode($segments);
	}
}
