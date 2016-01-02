<?php
!defined('SERVER_EXEC') && die('No access.');

class ProjectModel extends Model
{
	public $tablename = 'project';

	public function getProjects($options = array())
	{
		/*
		$options = array(
			'state' => ''
		);
		*/

		$query = 'SELECT * FROM ' . $this->db->qn($this->tablename);

		$conditions = array();

		if (isset($options['state']) && $options['state'] !== 'all') {
			$conditions[] = $this->db->qn('state') . ' = ' . $this->db->q($options['state']);
		}

		$query .= $this->buildWhere($conditions);

		return $this->getResult($query);
	}
}
