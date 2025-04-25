<?php declare(strict_types=1);
require 'global.php';

if(!\Kingsoft\Utils\Html::checkParams(['board_name', 'email'], $_REQUEST, true, false)) {
    http_response_code(403);
    trigger_error("Request incomplete", E_USER_ERROR);
}
// store the board request in the database;

$request = new Sbw\Leaderboard\BoardRequest();
$request->email = $_REQUEST["email"];
$request->board_name = $_REQUEST["board_name"];
$request->notified = null;
if( $request->freeze() ) {
    LOG->info("Board request for board success", [ 'board_name' => $request->board_name, 'email' => $request->email] );
    header("Location: /request-success.html");
} else {
    LOG->warning("Board request for board failure", [ 'board_name' => $request->board_name, 'email' => $request->email] );
    header("Location: /request-failure.html");
    trigger_error("Request failed", E_USER_ERROR);
}