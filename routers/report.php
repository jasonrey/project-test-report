<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportRouter extends Router
{
	public $allowedBuild = 'report';
	public $allowedRoute = 'report';

	public $segments = array('view', 'id');
}
