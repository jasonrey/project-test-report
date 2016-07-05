<?php
!defined('SERVER_EXEC') && die('No access.');

class CategoryApi extends Api
{
	public function save()
	{
		if (!Req::haspost(['name', 'project'])) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(['identifier' => $identifier]);

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			return $this->fail('You are not authorized.');
		}

		$name = Req::post('name');
		$projectName = Req::post('project');

		$project = Lib::table('project');
		if (!$project->load(['name' => $projectName])) {
			return $this->fail('No such project.');
		}

		$category = Lib::table('category');

		$category->name = $name;
		$category->date = date('Y-m-d H:i:s');

		$category->link($project);

		$category->store();

		return $this->success($category->id);
	}

	public function delete()
	{
		if (!Req::haspost('id')) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(['identifier' => $identifier]);

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			return $this->fail('You are not authorized.');
		}

		$id = Req::post('id');

		$category = Lib::table('category');

		if (!$category->load($id)) {
			return $this->fail('Invalid data.');
		}

		$category->delete();

		return $this->success();
	}

	public function update()
	{
		if (!Req::haspost(['id', 'name'])) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(['identifier' => $identifier]);

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			return $this->fail('You are not authorized.');
		}

		$id = Req::post('id');
		$name = Req::post('name');

		$table = Lib::table('category');

		if (!$table->load($id)) {
			return $this->false('Invalid data.');
		}

		$table->name = $name;

		$table->store();

		return $this->success();
	}
}
