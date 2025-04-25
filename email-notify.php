<?php declare(strict_types=1);
require 'global.php';

$notifier = new Sbw\Leaderboard\EmailNotifier();
$notifier->sendNotifications();