# Create user database
# Add first user as admin, password 'abc123', and access level 10

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `verify_string` varchar(50) NOT NULL default '',
  `access_level` tinyint(4) NOT NULL default '0',
  `active` enum('y','n','b') NOT NULL default 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`username`),
  UNIQUE KEY `mail` (`email`)
);

INSERT INTO `users` VALUES (NULL, 'admin', '24f9dc05c05e04ef6097fb842a635141', 'email@example.com', 10, 'y');
