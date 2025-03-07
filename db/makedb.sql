CREATE TABLE `board` (
  `board_id` char(36) NOT NULL DEFAULT 'UUID()',
  `board_name` varchar(255) NOT NULL,
  PRIMARY KEY (`board_id`)
);

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
);

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_scores` AS select
        `board_score`.`id` AS `id`,
        `board_score`.`board_id` AS `board_id`,
        `board_score`.`leader_name` AS `leader_name`,
        `board_score`.`score` AS `score`,
        `board_score`.`date` AS `date`
from
        `board_score`
order by
        `board_score`.`date` desc
limit
        10;