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

		$query = 'SELECT `a`.*, `b`.picture, `b`.`nick`, `b`.`initial`, `c`.`filename`, `c`.`name` FROM ' . $this->db->qn($this->tablename) . ' AS `a`';
		$query .= ' LEFT JOIN `user` AS `b`';
		$query .= ' ON `a`.`user_id` = `b`.`id`';
		$query .= ' LEFT JOIN `comment_attachment` AS `c`';
		$query .= ' ON `c`.`comment_id` = `a`.`id`';

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

		$result = $this->getResult($query);

		$comments = array();

		foreach ($result as $row) {
			if (!isset($comments[$row->id])) {
				$comments[$row->id] = $row;

				$comments[$row->id]->attachments = [];
			}

			if (!empty($row->filename)) {
				$comments[$row->id]->attachments[] = (object) array(
					'filename' => $row->filename,
					'name' => $row->name
				);
			}
		}

		return $comments;
	}

	public function getUsersByReportId($reportid)
	{
		$query = 'SELECT DISTINCT `user_id` FROM ' . $this->db->qn($this->tablename);
		$query .= ' WHERE `report_id` = ' . $this->db->q($reportid);

		return $this->getColumn($query);
	}
}
