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
				'server' => '',
				'username' => '',
				'password' => '',
				'database' => ''
			)
		)
	);

	public static $baseurl = array(
		'localhost' => 'development'
	);

	public static $base = array(
		'development' => 'git/project-test-report'
	);

	public static $pagetitle = 'Project Reporting';

	// Unique key to identify admin session
	// This key will be hashed to use as cookie key
	// Reset key to force admin log out
	public static $adminkey = 'adminkey';

	// Unique key to identify user session
	// This key will be hashed to use as cookie key
	public static $userkey = 'project-test-report';

	public static $googleClientId = '';
	public static $googleAllowedDomain = '';

	public static $iframepath = 'embed';

	public static $screenshotFolder = 'screenshots';
	public static $attachmentFolder = 'uploads';

	public static $slackApiToken = '';
	public static $slackHookToken = '';

	public static $googleMailName = '';
	public static $googleMailUsername = '';
	public static $googleMailPassword = '';
	public static $googleMailHost = 'smtp.gmail.com';
	public static $googleMailPort = '465';

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
