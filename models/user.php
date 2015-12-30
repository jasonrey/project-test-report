<?php
!defined('SERVER_EXEC') && die('No access.');

class UserModel extends Model
{
	public $tablename = 'user';

	public function getProjectAssignees($projectid)
	{
		$query = 'SELECT `b`.* FROM `project_assignee` AS `a`';
		$query .= ' LEFT JOIN `user` AS `b`';
		$query .= ' ON `a`.`user_id` = `b`.`id`';
		$query .= ' WHERE `a`.`project_id` = ' . $this->db->q($projectid);

		$result = $this->getResult($query);

		$assignees = array();

		foreach ($result as $row) {
			$assignees[$row->id] = $row;
		}

		return $assignees;
	}
}
