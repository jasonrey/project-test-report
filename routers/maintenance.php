<?php
!defined('SERVER_EXEC') && die('No access.');

class MaintenanceRouter extends Router
{
	public $allowedRoute = 'maintenance';
	public $allowedBuild = 'maintenance';

	public $segments = array('controller', 'action');
}
