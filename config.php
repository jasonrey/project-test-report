<?php
!defined('SERVER_EXEC') && die('No access.');

class Config
{
	public static $sef = true;

	public static $dbconfig = array(
		'default' => array(
			'development' => array(
				'server' => '127.0.0.1',
				'username' => 'root',
				'password' => 'cGFzc3dvcmQ=',
				'database' => 'project_report'
			),
			'production' => array(
				'server' => 'localhost',
				'username' => 'compass1_project',
				'password' => 'a3JsVU4zbld3VFN0',
				'database' => 'compass1_project_test'
			)
		)
	);

	public static $baseurl = array(
		'localhost' => 'development',
		'compass-interactive.com' => 'production',
		'www.compass-interactive.com' => 'production'
	);

	public static $base = array(
		'development' => 'git/project-test-report',
		'production' => 'project-test-report'
	);
	public static $pagetitle = 'Project Reporting';

	// Unique key to identify admin session
	// This key will be hashed to use as cookie key
	// Reset key to force admin log out
	public static $adminkey = 'adminkey';

	// Unique key to identify user session
	// This key will be hashed to use as cookie key
	public static $userkey = 'project-test-report';

	public static $googleClientId = '75424359881-ltlh68uuviheq4tscjqksdl98vmtnqj7';
	public static $googleAllowedDomain = 'compass-interactive.com';

	public static $iframepath = 'embed';

	public static $screenshotFolder = 'screenshots';

	public static $slackApiToken = 'xoxp-2911736605-4157764484-17596689699-1ce0969cd1';
	public static $slackHookToken = 'T02STMNHT/B0HHKPC6P/Mj4eH4rsHZ6dMlM0mydGxT5c';

	public static function getBaseUrl()
	{
		return 'http://' . $_SERVER['SERVER_NAME'];
	}

	public static function getBaseFolder()
	{
		return Config::$base[Config::env(false)];
	}

	public static function getHTMLBase()
	{
		$base = Config::getBaseUrl();
		$folder = Config::getBaseFolder();

		if (!empty($folder)) {
			$base .= '/' . $folder;
		}

		$base .= '/';

		return $base;
	}

	public static function getBasePath()
	{
		return dirname(__FILE__);
	}

	public static function getPageTitle()
	{
		return self::$pagetitle;
	}

	public static function getDBConfig($key = 'default')
	{
		return self::$dbconfig[$key][Config::env(false)];
	}

	public static function env($checkget = true)
	{
		if ($checkget && Req::hasget('environment')) {
			return Req::get('environment');
		}

		$serverName = $_SERVER['SERVER_NAME'];

		return isset(Config::$baseurl[$serverName]) ? Config::$baseurl[$serverName] : 'production';
	}

	public static function getAdminKey()
	{
		return hash('sha256', Config::$adminkey);
	}
}
