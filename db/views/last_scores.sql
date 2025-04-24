DROP VIEW IF EXISTS `last_scores`;
CREATE ALGORITHM = UNDEFINED
/*  DEFINER=`leader_user`@`%` */
SQL SECURITY DEFINER VIEW `last_scores` AS
select `board_score`.`id` AS `id`,
    `board_score`.`board_id` AS `board_id`,
    `board_score`.`leader_name` AS `leader_name`,
    `board_score`.`score` AS `score`,
    `board_score`.`date` AS `date`
from `board_score`
order by `board_score`.`date` desc
limit 10;