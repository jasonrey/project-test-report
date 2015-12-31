<?php
!defined('SERVER_EXEC') && die('No access.');

class CommentModel extends Model
{
	public $tablename = 'comment';

	public function getComments($options = array())
	{
		/*
		$options = array(
			'report_id' => '', // or array()
			'user_id' => ''
		);
		*/

		$query = 'SELECT `a`.*, `b`.picture, `b`.`nick` FROM ' . $this->db->qn($this->tablename) . ' AS `a`';
		$query .= ' LEFT JOIN `user` AS `b`';
		$query .= ' ON `a`.`user_id` = `b`.`id`';

		$conditions = array();

		if (!empty($options['report_id']) && $options['report_id'] !== 'all') {
			if (is_array($options['report_id'])) {
				$conditions[] = $this->db->qn('report_id') . ' IN (' . implode(',', $this->db->q($options['report_id'])) . ')';
			} else {
				$conditions[] = $this->db->qn('report_id') . ' = ' . $this->db->q($options['report_id']);
			}
		}

		if (!empty($options['user_id']) && $options['user_id'] !== 'all') {
			$conditions[] = $this->db->qn('user_id') . ' = ' . $this->db->q($options['user_id']);
		}

		$query .= $this->buildWhere($conditions);
		$query .= ' ORDER BY `date` ASC';

		return $this->getResult($query);
	}
}
