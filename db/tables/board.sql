DROP TABLE IF EXISTS `board`;

DELIMITER #
CREATE TABLE `board` (
  `board_id` char(36) NOT NULL DEFAULT 'UUID()',
  `board_name` varchar(255) NOT NULL,
  PRIMARY KEY (`board_id`)
)
/*  ENGINE=InnoDB  */
DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci#
# DELIMITER ;
