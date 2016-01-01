CREATE TABLE `slackuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slack_id` varchar(255) NOT NULL DEFAULT '',
  `team_id` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
