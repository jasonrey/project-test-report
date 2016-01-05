<?php
!defined('SERVER_EXEC') && die('No access.');

class UserModel extends Model
{
	public $tablename = 'user';

	public function getProjectAssignees($projectid = null)
	{
		$query = 'SELECT `b`.*, `a`.`project_id` FROM `project_assignee` AS `a`';
		$query .= ' LEFT JOIN `user` AS `b`';
		$query .= ' ON `a`.`user_id` = `b`.`id`';

		if (!empty($projectid)) {
			$query .= ' WHERE `a`.`project_id` = ' . $this->db->q($projectid);
		}

		$result = $this->getResult($query);

		if (!empty($projectid)) {
			return $this->assignByKey($result);
		}

		$assignees = array();

		foreach ($result as $row) {
			if (!isset($assignees[$row->id])) {
				$row->project_ids = array();
				$assignees[$row->id] = $row;
			}

			$assignees[$row->id]->project_ids[] = $row->project_id;
		}

		return $assignees;
	}

	public function getUsers()
	{
		$query = 'SELECT * FROM ' . $this->db->qn($this->tablename);

		$result = $this->assignbyKey($this->getResult($query));

		return $result;
	}
}
