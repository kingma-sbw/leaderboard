<?php declare(strict_types=1);
namespace Sbw\Leaderboard;

/**
 * Persistant DB object for table – board
 */
final class Board
	extends \Kingsoft\Persist\Base
	implements \Kingsoft\Persist\IPersist
{
	use \Kingsoft\Persist\Db\DBPersistTrait;

	protected ?string    $board_id;
	protected ?string    $board_name;

	// Persist functions
	static public function getPrimaryKey():string { return 'board_id'; }
	static public function isPrimaryKeyAutoIncrement():bool { return false; }
	static public function nextPrimaryKey():string { return "board-" . bin2hex(random_bytes(12)); }
	static public function getTableName():string { return '`board`'; }
	static public function getFields():array {
		return [
			'board_id'           => ['string', 36 ], 		//	char(36)
			'board_name'         => ['string', 255 ], 		//	varchar(255)
		];
	}
}