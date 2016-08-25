<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportTable extends Table
{
	public $project_id;
	public $user_id;
	public $assignee_id;
	public $category_id;
	public $url;
	public $content;
	public $state;
	public $date;

	public function getLink()
	{
		return Lib::url('report', array('view' => 'report', 'id' => $this->id), true);
	}

	public function init()
	{
		$owner = Lib::table('user');
		$owner->load($this->user_id);

		$this->picture = $owner->picture;
		$this->nick = $owner->nick;
		$this->initial = $owner->initial;

		if (!empty($this->assignee_id)) {
			$assignee = Lib::table('user');
			$assignee->load($this->assignee_id);

			$this->assignee = $assignee;
		}

		$screenshots = Lib::model('report')->getScreenshotsByReportId($this->id);

		$this->screenshots = array();

		foreach ($screenshots as $screenshot) {
			$this->screenshots[] = $screenshot->filename;
		}

		$this->comments = Lib::model('comment')->getComments(array('report_id' => $this->id));

		$this->totalcomments = count($this->comments);
	}

	public function getCategory()
	{
		static $categories = [];

		if (!isset($categories[$this->category_id])) {
			$category = Lib::table('category');
			$category->load($this->category_id);

			$categories[$this->category_id] = $category;
		}

		return $categories[$this->category_id];
	}
}
