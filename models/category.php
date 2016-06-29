<?php
!defined('SERVER_EXEC') && die('No access.');

class CategoryModel extends Model
{
	public $tablename = 'category';

	public function getCategories()
	{
		$query = 'SELECT * FROM `category`';

		return $this->getResult($query);
	}
}
