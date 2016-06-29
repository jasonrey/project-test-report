<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportApi extends Api
{
	public function save()
	{
		$keys = array('project', 'content', 'url', 'category');

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
			return $this->fail('No such project.');
		}

		$reportTable = Lib::table('report');
		$reportTable->link($projectTable);
		$reportTable->link($user);
		$reportTable->content = $content;
		$reportTable->category_id = $category;
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

	public function filter()
	{
		$keys = array('state', 'assignee', 'sort', 'project');

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

		$projectTable = Lib::table('project');

		if ($post['project'] !== 'all' && !$projectTable->load(array('name' => $post['project']))) {
			return $this->fail('No such project.');
		}

		$cookie = Lib::cookie();

		foreach ($keys as $key) {
			$cookie->set('filter-' . $key, $post[$key]);
		}

		$reportModel = Lib::model('report');

		$reports = $reportModel->getItems(array(
			'state' => constant('STATE_' . strtoupper($post['state'])),
			'assignee_id' => $post['assignee'],
			'order' => 'date',
			'direction' => $post['sort'],
			'project_id' => $projectTable->id
		));

		$userModel = Lib::model('user');

		$assignees = $userModel->getProjectAssignees($projectTable->id);

		$html = '';

		$view = Lib::view('embed');

		foreach ($reports as $report) {
			$html .= $view->loadTemplate('report-item', array('report' => $report, 'assignees' => $assignees, 'user' => $user));
		}

		return $this->success($html);
	}

	public function mark()
	{
		$keys = array('id', 'state');

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

		$reportTable = Lib::table('report');

		if (!$reportTable->load($post['id'])) {
			return $this->fail('No such report.');
		}

		$reportTable->state = $post['state'];
		$reportTable->store();

		$reportStateHistoryTable = Lib::table('report_state_history');

		$reportStateHistoryTable->link($reportTable);
		$reportStateHistoryTable->link($user);
		$reportStateHistoryTable->state = $post['state'];

		$reportStateHistoryTable->store();

		if ($user->id != $reportTable->user_id) {
			$projectTable = Lib::table('project');
			$projectTable->load($report->project_id);

			$targetUser = Lib::table('user');
			$targetUser->load($reportTable->user_id);

			$targetUserSettings = $targetUser->getSettings($projectTable)->getData();

			if (($reportTable->state == STATE_COMPLETED && $targetUserSettings['completed']) ||
				($reportTable->state == STATE_REJECTED && $targetUserSettings['rejected'])
			) {
				$slackMessage = Lib::helper('slack')->newMessage();

				$slackMessage->to($reportTable->user_id);
				$slackMessage->message($user->nick . ' marked your report as *' . constant('STATE_NAME_' . $reportTable->state) . '*.');
				$slackMessage->username = 'Project Report Status - ' . ($reportTable->state == 1 ? 'Completed' : ($reportTable->state == 2 ? 'Rejected' : 'Pending'));
				$slackMessage->icon_emoji = $reportTable->state == 1 ? ':thumbsup:' : ($reportTable->state == 2 ? ':x:' : ':clock1:');

				$attachment = $slackMessage->newAttachment();

				$attachment->fallback = '<' . $reportTable->getLink() . '|Report ticket ID ' . $reportTable->id . '>.';
				$attachment->color = $reportTable->state == 1 ? 'good' : ($reportTable->state == 2 ? 'danger' : 'warning');
				$attachment->title = $projectTable->name;
				$attachment->title_link = $reportTable->getLink();
				$attachment->text = $reportTable->content;

				$slackMessage->send();
			}
		}

		return $this->success();
	}

	public function assign()
	{
		$keys = array('id', 'assigneeid');

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

		$reportTable = Lib::table('report');

		if (!$reportTable->load($post['id'])) {
			return $this->fail('No such report.');
		}

		$reportTable->assignee_id = $post['assigneeid'];
		$reportTable->store();

		if (!empty($post['assigneeid']) && $post['assigneeid'] != $user->id) {
			$projectTable = Lib::table('project');
			$projectTable->load($reportTable->project_id);

			$targetUser = Lib::table('user');
			$targetUser->load($post['assigneeid']);
			$targetUserSettings = $targetUser->getSettings($projectTable)->getData();

			if ($targetUserSettings['assign']) {
				$slackMessage = Lib::helper('slack')->newMessage();

				$slackMessage->to($post['assigneeid']);
				$slackMessage->message($user->nick . ' assigned you a report ticket.');
				$slackMessage->username = 'Project Report Assignment';
				$slackMessage->icon_emoji = ':gift:';

				$attachment = $slackMessage->newAttachment();

				$attachment->fallback = '<' . $reportTable->getLink() . '|Report ticket ID ' . $reportTable->id . '>.';
				$attachment->color = '#00bcd4';
				$attachment->title = $projectTable->name;
				$attachment->title_link = $reportTable->getLink();
				$attachment->text = $reportTable->content;

				$slackMessage->send();
			}
		}

		return $this->success();
	}
}
