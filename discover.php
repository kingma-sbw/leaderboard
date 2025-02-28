<?php declare(strict_types=1);

require_once 'global.php';
require 'vendor/autoload.php';

use \Kingsoft\Persist\Db\Bootstrap;
$bootstrap = new Bootstrap( SETTINGS['api']['namespace'] );
$bootstrap->discover();