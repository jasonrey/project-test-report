<?php
!defined('SERVER_EXEC') && die('No access.');

class ProjectController extends Controller
{
	public function saveProjectTitle()
	{
		$keys = array('project-title', 'project-name');

		$post = Req::post($keys);

		if (empty($post['project-name'])) {
			Lib::redirect('page', array('view' => 'embed'));
		}

		if (empty($post['project-title'])) {
			Lib::redirect('page', array('view' => 'embed', 'project' => $post['project-name']));
		}

		$projectTable = Lib::table('project');
		$projectTable->load(array('name' => $post['project-name']));
		$projectTable->title = $post['project-title'];

		$projectTable->store();

		Lib::redirect('page', array('view' => 'embed', 'project' => $post['project-name']));
	}
}
