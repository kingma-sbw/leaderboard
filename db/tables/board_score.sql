DROP TABLE IF EXISTS `board_score`;

CREATE TABLE `board_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board_id` char(36) NOT NULL,
  `leader_name` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `date_board_id` (`date`,`board_id`),
  KEY `board_id` (`board_id`) USING BTREE,
  CONSTRAINT `board_score_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `board` (`board_id`) ON DELETE CASCADE
)
/*  ENGINE=InnoDB  */
AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
