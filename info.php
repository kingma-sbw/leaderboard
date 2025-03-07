<?php
$db = new \PDO("mysql:host=db;dbname=sbw_bf_leaderboard;charset=utf8","sbw","sbw");
$result = $db->query("SHOW TABLES");
$result->execute();
var_dump($result->fetchAll( ));
phpinfo(8);
