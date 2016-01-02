CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(64) NOT NULL DEFAULT '',
  `gid` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `initial` varchar(2) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `picture` text NOT NULL,
  `role` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
