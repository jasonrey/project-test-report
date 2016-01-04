<?php
!defined('SERVER_EXEC') && die('No access.');

class User_settingsModel extends Model
{
	public $tablename = 'user_settings';

	public function getSettings($options = array())
	{
		/*
		$options = array(
			'project_id' => '',
			'user_id' => ''
		);
		*/

		$query = 'SELECT * FROM ' . $this->db->qn($this->tablename);

		$conditions = array();

		if (isset($options['project_id']) && $options['project_id'] !== 'all') {
			$conditions[] = $this->db->qn('project_id') . ' = ' . $this->db->q($options['project_id']);
		}

		if (isset($options['user_id']) && $options['user_id'] !== 'all') {
			if (is_array($options['user_id'])) {
				$conditions[] = $this->db->qn('user_id') . ' IN (' . implode(',', $this->db->q($this->db->q($options['user_id']))) . ')';
			} else {
				$conditions[] = $this->db->qn('user_id') . ' = ' . $this->db->q($options['user_id']);
			}
		}

		$query .= $this->buildWhere($conditions);

		return $this->getResult($query);
	}
}
