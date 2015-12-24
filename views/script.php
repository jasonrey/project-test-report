<?php
!defined('SERVER_EXEC') && die('No access.');

class ScriptView extends View
{
	public function display()
	{
		$script = Req::get('script');

		$this->$script();

		echo $this->output($script);
	}

	public function reporting()
	{
		$project = Req::get('project', 'sample-project');
		$iframepath = Config::$iframepath . '?project=' . $project;

		$this->set('iframepath', $iframepath);
	}
}
