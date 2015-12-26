<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportApi extends Api
{
	public function save()
	{
		$keys = array('project', 'content', 'url');

		if (!Req::haspost($keys)) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn) {
			return $this->fail('You are not authorized.');
		}

		$post = Req::post($keys);

		extract($post);

		$projectTable = Lib::table('project');

		if (!$projectTable->load(array('name' => $project))) {
			$projectTable->store();
		}

		$reportTable = Lib::table('report');
		$reportTable->link($projectTable);
		$reportTable->link($user);
		$reportTable->content = $content;
		$reportTable->url = $url;

		$reportTable->store();

		/*
		'screenshot-63cg2rb5v47snhfr' =>
		    array (size=5)
		      'name' => string '2013-09-01 17.14.14.jpg' (length=23)
		      'type' => string 'image/jpeg' (length=10)
		      'tmp_name' => string '/private/var/tmp/phpZmeqEX' (length=26)
		      'error' => int 0
		      'size' => int 134583
		*/

		$files = Req::file();

		if (!empty($files)) {
			foreach ($files as $key => $file) {
				$fileObject = Lib::file($file['tmp_name'], $file['name']);
				$copiedFile = $fileObject->copy(Config::getBasePath() . '/' . Config::$screenshotFolder, $fileObject->generateTemporaryFilename($key . '-'));

				$screenshotTable = Lib::table('screenshot');
				$screenshotTable->link($reportTable);
				$screenshotTable->filename = $copiedFile->filename;
				$screenshotTable->store();
			}
		}

		return $this->success();
	}
}