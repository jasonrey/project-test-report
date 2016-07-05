<?php
!defined('SERVER_EXEC') && die('No access.');

class CategoryModel extends Model
{
	public $tablename = 'category';

	public function getCategories($options = [])
	{
		$query = 'SELECT * FROM `category`';

		$conditions = [];

		if (!empty($options['projectid'])) {
			$conditions[] = $this->db->qn('project_id') . ' = ' . $this->db->q($options['projectid']);
		}

		$query .= $this->buildWhere($conditions);

		return $this->getResult($query);
	}
}
