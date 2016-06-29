<?php
!defined('SERVER_EXEC') && die('No access.');

class CategoryApi extends Api
{
	public function save()
	{
		if (!Req::haspost('name')) {
			return $this->fail('Insufficient data.');
		}

		$identifier = Lib::cookie(Lib::hash(Config::$userkey));

		$user = Lib::table('user');

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			return $this->fail('You are not authorized.');
		}

		$name = Req::post('name');

		$category = Lib::table('category');

		$category->name = $name;
		$category->date = date('Y-m-d H:i:s');

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

		$isLoggedIn = !empty($identifier) && $user->load(array('identifier' => $identifier));

		if (!$isLoggedIn || $user->role != USER_ROLE_ADMIN) {
			return $this->fail('You are not authorized.');
		}

		$id = Req::post('id');

		$category = Lib::table('category');

		if (!$category->load($id)) {
			return $this->fail('Invalid data');
		}

		$category->delete();

		return $this->success();
	}
}
