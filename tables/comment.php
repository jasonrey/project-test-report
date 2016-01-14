<?php
!defined('SERVER_EXEC') && die('No access.');

class CommentTable extends Table
{
	public $report_id;
	public $user_id;
	public $content;
	public $date;

	public function attach($key, $file)
	{
		$fileObject = Lib::file($file['tmp_name'], $file['name']);
		$copiedFile = $fileObject->copy(Config::getBasePath() . '/' . Config::$attachmentFolder, $key . '-' . $file['name']);

		$attachmentTable = Lib::table('comment_attachment');
		$attachmentTable->link($this);
		$attachmentTable->filename = $copiedFile->filename;
		$attachmentTable->name = $file['name'];
		$attachmentTable->store();
	}
}
