<?php
!defined('SERVER_EXEC') && die('No access.');

class Comment_attachmentTable extends Table
{
	public $comment_id;
	public $filename;
	public $name;
	public $date;
}
