<?php
!defined('SERVER_EXEC') && die('No access.');

class PageRouter extends Router
{
	public $allowedRoute = array('embed', 'frame');
	public $allowedBuild = 'page';
	public $segments = array('view');
}
