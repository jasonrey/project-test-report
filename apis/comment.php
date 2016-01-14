<?php
!defined('SERVER_EXEC') && die('No access.');

class CommentApi extends Api
{
	public function load()
	{
		if (!Req::haspost('reportid')) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn) {
			return $this->fail('You are not authorized.');
		}

		$reportid = Req::post('reportid');

		$model = Lib::model('comment');

		$comments = $model->getComments(array(
			'report_id' => $reportid
		));

		$html = '';

		$view = Lib::view('embed');

		foreach ($comments as $comment) {
			$html .= $view->loadTemplate('comment-item', array('comment' => $comment, 'user' => $user));
		}

		return $this->success($html);
	}

	public function submit()
	{
		$keys = array('id', 'content');

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

		$commentTable = Lib::table('comment');
		$commentTable->link($user);
		$commentTable->report_id = $post['id'];
		$commentTable->content = $post['content'];
		$commentTable->store();

		$files = Req::file();

		if (!empty($files)) {
			foreach ($files as $key => $file) {
				$commentTable->attach($key, $file);
			}
		}

		$commentModel = Lib::model('comment');
		$recipients = $commentModel->getUsersByReportId($post['id']);

		$reportTable = Lib::table('report');
		$reportTable->load($post['id']);

		$projectTable = Lib::table('project');
		$projectTable->load($reportTable->project_id);

		if (!in_array($reportTable->user_id, $recipients)) {
			$recipients[] = $reportTable->user_id;
		}

		$userSettingsModel = Lib::model('user_settings');
		$userProjectsSettings = $userSettingsModel->getSettings(array('project_id' => $projectTable->id, 'user_id' => $recipients));
		$userProjectsSettings = $userSettingsModel->assignByKey($userProjectsSettings, 'user_id');

		$userAllSettings = $userSettingsModel->getSettings(array('project_id' => 0, 'user_id' => array_diff($recipients, array_keys($userProjectsSettings))));
		$userAllSettings = $userSettingsModel->assignByKey($userAllSettings, 'user_id');

		$defaultSettings = unserialize(USER_SETTINGS);

		$ownerSettings = isset($userProjectsSettings[$reportTable->user_id]) ? $userProjectSettings : (isset($userAllSettings[$reportTable->user_id]) ? $userAllSettings : $defaultSettings);

		if (!$ownerSettings['comment-owner']) {
			$recipients = array_diff($recipients, array($reportTable->user_id));
		}

		foreach ($recipients as $userid) {
			if ($userid == $user->id) {
				continue;
			}

			$settings = isset($userProjectsSettings[$userid]) ? $userProjectSettings : (isset($userAllSettings[$userid]) ? $userAllSettings : $defaultSettings);

			// If is owner, the fact that we reach here means the owner wants notification
			// Or if not owner, then check for settings
			if ($reportTable->user_id == $userid || $settings['comment-participant']) {
				$slackMessage = Lib::helper('slack')->newMessage();
				$slackMessage->to($userid);
				$slackMessage->message($user->nick . ' posted a new comment.');
				$slackMessage->username = 'Project Report Comment';
				$slackMessage->icon_emoji = ':speech_balloon:';

				$attachment = $slackMessage->newAttachment();

				$attachment->fallback = 'New comment in <' . $reportTable->getLink() . '|Report ticket ID ' . $reportTable->id . '>.';
				$attachment->color = '#FFEB3B';
				$attachment->title = $projectTable->name;
				$attachment->title_link = $reportTable->getLink();
				$attachment->text = $reportTable->content;

				$attachment->newField('Comment', $post['content']);

				if (!empty($files)) {
					foreach ($files as $key => $file) {
						$attachment->newField($file['name'], Config::getHTMLBase() . Config::$attachmentFolder . '/' . $key . '-' . $file['name']);
					}
				}

				$slackMessage->send();
			}
		}

		return $this->success($commentTable->id);
	}

	public function sync()
	{
		if (!Req::haspost('reports', 'ids')) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn) {
			return $this->fail('You are not authorized.');
		}

		$reports = json_decode(Req::post('reports'));
		$ids = Req::post('ids');

		$updated = array();

		$commentModel = Lib::model('comment');

		$comments = $commentModel->getComments(array(
			'report_id' => $ids
		));

		$commentsByReportId = array();

		foreach ($comments as $comment) {
			$commentsByReportId[$comment->report_id][$comment->id] = $comment;
		}

		foreach ($reports as $id => $report) {
			$newTotalComments = empty($commentsByReportId[$id]) ? 0 : count($commentsByReportId[$id]);

			if ($report->totalComments == $newTotalComments) {
				continue;
			}

			$updated[$id] = array(
				'totalComments' => $newTotalComments,
				'comments' => array()
			);

			if (!$report->commentsLoaded) {
				continue;
			}

			$view = Lib::view('embed');

			foreach ($commentsByReportId[$id] as $commentid => $newComment) {
				if (in_array($commentid, $report->comments)) {
					$updated[$id]['comments'][$commentid] = false;
					continue;
				}

				$updated[$id]['comments'][$commentid] = $view->loadTemplate('comment-item', array('comment' => $comment, 'user' => $user));
			}
		}

		return $this->success($updated);
	}
}
