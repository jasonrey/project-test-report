<?php
!defined('SERVER_EXEC') && die('No access.');

class ReportModel extends Model
{
	public $tablename = 'report';

	public function getItems($options = array())
	{
		/*
		$options = array(
			'project' => '',
			'project_id' => '',
			'user_id' => '', // or array()
			'assignee_id' => '', // or array()
			'state' => 0,
			'order' => 'date',
			'direction' => 'asc'
		);
		*/

		$query = 'SELECT `a`.*, `c`.`filename`, `d`.`picture`, `d`.`nick`, COUNT(`e`.`id`) AS `totalcomments` FROM ' . $this->db->qn($this->tablename) . ' AS `a`';

		if (!empty($options['project'])) {
			$query = ' LEFT JOIN `project` AS `b` ON `a`.`project_id` = `b`.`id`';
		}

		$query .= ' LEFT JOIN `screenshot` AS `c` ON `a`.`id` = `c`.`report_id`';

		$query .= ' LEFT JOIN `user` AS `d` ON `a`.`user_id` = `d`.`id`';

		$query .= ' LEFT JOIN `comment` AS `e` ON `a`.`id` = `e`.`report_id`';

		$conditions = array();

		if (!empty($options['project']) && $options['project'] !== 'all') {
			$conditions[] = '`b`.`name` = ' . $this->db->q($options['project']);
		}

		if (!empty($options['project_id']) && $options['project_id'] !== 'all') {
			$conditions[] = '`a`.`project_id` = ' . $this->db->q($options['project_id']);
		}

		if (!empty($options['user_id']) && $options['user_id'] !== 'all') {
			if (is_array($options['user_id'])) {
				$conditions[] = '`a`.`user_id` IN (' . implode(',', $this->db->q($options['user_id'])) . ')';
			} else {
				$conditions[] = '`a`.`user_id` = ' . $this->db->q($options['user_id']);
			}
		}

		if (!empty($options['assignee_id']) && $options['assignee_id'] !== 'all') {
			if ($options['assignee_id'] === 'unassigned') {
				$options['assignee_id'] = 0;
			}

			if (is_array($options['assignee_id'])) {
				$conditions[] = '`a`.`assignee_id` IN (' . implode(',', $this->db->q($options['assignee_id'])) . ')';
			} else {
				$conditions[] = '`a`.`assignee_id` = ' . $this->db->q($options['assignee_id']);
			}
		}

		if (isset($options['state']) && $options['state'] !== 'all') {
			$conditions[] = '`a`.`state` = ' . $this->db->q($options['state']);
		}

		$query .= $this->buildWhere($conditions);

		$query .= ' GROUP BY `c`.`id`';

		$query .= $this->buildOrder($options, 'date', 'asc');

		$result = $this->getResult($query, false);

		$reports = array();

		foreach ($result as $row) {
			if (!isset($reports[$row->id])) {
				$reports[$row->id] = Lib::table('report');

				$reports[$row->id]->bind($row, true);

				$reports[$row->id]->screenshots = array();
				$reports[$row->id]->picture = $row->picture;
				$reports[$row->id]->nick = $row->nick;
				$reports[$row->id]->totalcomments = $row->totalcomments;
			}

			if (!empty($row->filename)) {
				$reports[$row->id]->screenshots[] = $row->filename;
			}
		}

		return $reports;
	}
}
