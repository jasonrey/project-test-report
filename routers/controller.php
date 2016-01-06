<?php
!defined('SERVER_EXEC') && die('No access.');

class ControllerRouter extends Router
{
	public $allowedRoute = array('maintenance', 'project');
	public $allowedBuild = 'controller';

	public $segments = array('controller', 'action');
}
