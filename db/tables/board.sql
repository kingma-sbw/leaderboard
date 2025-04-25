DROP TABLE IF EXISTS `board`;

CREATE TABLE `board` (
  `board_id` char(36) NOT NULL DEFAULT hex(random_bytes(13)),
  `board_name` varchar(255) NOT NULL,
  PRIMARY KEY (`board_id`)
)
/*  ENGINE=InnoDB  */
DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
