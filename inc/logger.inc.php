<?php declare(strict_types=1);

define( 'LOGROOT', ROOT . SETTINGS['log']['location'] . '/' );

/* @var \Monolog\Logger $log */
$log = new Monolog\Logger( SETTINGS['log']['name'] );
$log->pushHandler(
	new \Kingsoft\MonologHandler\CronRotatingFileHandler(
		LOGROOT . SETTINGS['log']['name'] . '.log',
		Monolog\Level::fromName( SETTINGS['log']['level'] ),
		SETTINGS['logrotate']
	)
);
$log->pushHandler(
	new Monolog\Handler\StreamHandler(
		LOGROOT . SETTINGS['log']['name'] . '_error.log',
		Monolog\Logger::ERROR
	)
);

$log->pushProcessor( function ($record) {
	$record['extra']['user']      = $_SESSION['username'] ?? '';
	$record['extra']['ip']        = $_SERVER['REMOTE_ADDR'];
	$record['extra']['sessionId'] = substr( session_id(), 0, 8 );
	return $record;
} );
/**
 * @var Monolog\Logger LOG - the logger
 */
define( 'LOG', $log );

// not needed anymore
//unset( $log );

\Monolog\ErrorHandler::register( LOG );

set_error_handler( function ($errno, $errstr, $errfile, $errline) {
	// error was suppressed with the @-operator
	if( 0 === error_reporting() ) {
		return false;
	}
	switch($errno) {
		default:
			LOG->error( "Unknown error type: [$errno] $errstr", [ 'file' => "$errfile#$errline" ] );
			break;
		case E_USER_ERROR: // fall through
		case E_ERROR: // fall through
		case E_WARNING: // PHP Warnings are errors
			LOG->error( $errstr, [ 'file' => "$errfile#$errline" ] );
			exit(1);  // as we don't call the internal handler we have to terminate here
		case E_USER_DEPRECATED:
		case E_DEPRECATED:
			LOG->notice( "DEPRECATED $errstr", [ 'file' => "$errfile#$errline" ] );
			break;
		case E_USER_WARNING: // fall through
		case E_NOTICE: // PHP Notices are warnings
			LOG->warning( $errstr, [ 'file' => "$errfile#$errline" ] );
			break;
		case E_USER_NOTICE:
			LOG->notice( $errstr, [ 'file' => "$errfile#$errline" ] );
			break;
	}
	/* Don't execute PHP internal error handler */
	return true;
} );
