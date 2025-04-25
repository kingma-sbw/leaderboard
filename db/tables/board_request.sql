DROP TABLE IF EXISTS `board_request`;

CREATE TABLE `board_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_name` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `notified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
)
/*  ENGINE=InnoDB  */
AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
