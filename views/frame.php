<?php
!defined('SERVER_EXEC') && die('No access.');

class FrameView extends View
{
	public $css = 'frame';

	public function main()
	{
		$this->js = Config::getHTMLBase() . 'js/reporting?name=testing';
	}
}
