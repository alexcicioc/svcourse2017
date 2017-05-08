CREATE TABLE `team_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hunt_id` int(11) DEFAULT NULL,
  `status` enum('N','R') NOT NULL DEFAULT 'N'
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;