<?php declare(strict_types=1);

require 'global.php';

use Kingsoft\Db\Documentor;

$dsn        = "mysql:host=" . SETTINGS['db']['hostname'] . ";dbname=" . SETTINGS['db']['database'];
$connection = new PDO(
    $dsn,
    SETTINGS['db']['username'],
    SETTINGS['db']['password'] );
$documenter = ( new Documentor( $connection, SETTINGS['db']['database'] ) )
    ->do_tables()
    ->do_procedures()
    ->do_functions()
;