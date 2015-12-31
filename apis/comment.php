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

		return $this->success($commentTable->id);
	}
}
