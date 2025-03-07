<?php declare(strict_types=1);
require '../global.php';
// instead of using user-check.php, we will use the following code to check if the user is logged in or not
// require '../inc/user-check.php';

// make sure requests are not cached
header( 'Cache-Control: no-cache, no-store, must-revalidate' );
// and requests are secure (https)
// max-age is in seconds, 63072000 = 2 years
header( 'Strict-Transport-Security: max-age=63072000; includeSubDomains; preload' );

use Kingsoft\Http\{StatusCode, Response};
use Kingsoft\PersistRest\{PersistRest, PersistRequest};
use Kingsoft\Db\{Database, DatabaseException};
use Psr\Log\LoggerInterface as Logger;

readonly class IdPersistRest extends PersistRest
{
  public function __construct( PersistRequest $request, Logger $logger )
  {
    parent::__construct( $request, $logger );
  }

  public function handleRequest(): void
  {
    // extract UUID from request
    if( null === $path = parse_url( str_replace( '\\\\', '\\', $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) ) {
      $this->logger->alert( "URL parse error", [ 'url' => $_SERVER['REQUEST_URI'] ] );
      Response::sendStatusCode( StatusCode::BadRequest );
      Response::sendMessage(
        StatusCode::toString( StatusCode::BadRequest ),
        StatusCode::BadRequest->value,
        "Could not parse '" . $_SERVER['REQUEST_URI'] . "'"
      );
      return;
    }

    // first element is always empty
    // second element should be the board UUID
    $uri = explode( '/', $path );

    $boardUuid = $uri[1] ?? null;
    if( !$boardUuid ) {
      $this->logger->alert( "Board UUID not found", [ 'url' => $_SERVER['REQUEST_URI'] ] );
      Response::sendStatusCode( StatusCode::BadRequest );
      Response::sendMessage(
        StatusCode::toString( StatusCode::BadRequest ),
        StatusCode::BadRequest->value,
        "Board UUID not found"
      );
      if( !$this->findBoard( $boardUuid ) ) {
        $this->logger->alert( "Board not found", [ 'url' => $_SERVER['REQUEST_URI'] ] );
        Response::sendStatusCode( StatusCode::NotFound );
        Response::sendMessage(
          StatusCode::toString( StatusCode::NotFound ),
          StatusCode::NotFound->value,
          "Board not found"
        );
        return;
      }
    }
    unset( $uri[1] );

    $_SERVER['REQUEST_URI'] = implode( '/', $uri ) . '?board_id=' . $boardUuid;

    parent::handleRequest();
  }
  private function findBoard( string $boardUuid ): bool
  {
    try {

      $sql  = "SELECT * FROM boards WHERE uuid = :uuid";
      $stmt = Database::getConnection()->prepare( $sql );
      $stmt->bindParam( ':uuid', $boardUuid );
      $stmt->execute();
      return $stmt->fetch() ? true : false;
    } catch ( DatabaseException $e ) {
      $this->logger->error( "Database error", [ 'error' => $e->getMessage() ] );
      Response::sendError( $e->getMessage(), StatusCode::InternalServerError->value );
      return false;
    }
  }
}

try {
  $request = new PersistRequest(
    SETTINGS['api']['allowedendpoints'],
    SETTINGS['api']['allowedmethods'],
    SETTINGS['api']['allowedorigin'],
  );
  $request->setLogger( LOG );
  ( new IdPersistRest( $request, LOG ) )
    ->handleRequest();
} catch ( Exception $e ) {
  Response::sendError( $e->getMessage(), StatusCode::InternalServerError->value );
}
