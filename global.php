<?php declare(strict_types=1);
define( 'ROOT', __DIR__. '/' );
define( 'SETTINGS', parse_ini_file(ROOT . 'config/settings.ini', true) );

require ROOT . 'vendor/autoload.php';
require ROOT . 'inc/logger.inc.php';

