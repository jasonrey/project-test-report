<?php
!defined('SERVER_EXEC') && die('No access.');

class UserModel extends Model
{
	public $tablename = 'user';

	public function getProjectAssignees($projectid = null)
	{
		$query = 'SELECT DISTINCT `b`.* FROM `project_assignee` AS `a`';
		$query .= ' LEFT JOIN `user` AS `b`';
		$query .= ' ON `a`.`user_id` = `b`.`id`';

		if (!empty($projectid)) {
			$query .= ' WHERE `a`.`project_id` = ' . $this->db->q($projectid);
		}

		$result = $this->getResult($query);

		$assignees = $this->assignByKey($result);

		return $assignees;
	}
}
