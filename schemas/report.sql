CREATE TABLE `report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `state` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
