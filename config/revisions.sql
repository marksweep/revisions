-- -----------------------------------------------------
-- Table `mydb`.`revisions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `revisions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `body` text,
  `excerpt` text,
  `md5` varchar(64) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
