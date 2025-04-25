<?php declare(strict_types=1);
namespace Sbw\Leaderboard;

/**
 * Persistant DB object for table – board_request
 */
final class BoardRequest
	extends \Kingsoft\Persist\Base
	implements \Kingsoft\Persist\IPersist
{
	use \Kingsoft\Persist\Db\DBPersistTrait;

	protected ?int       $id;
	protected ?string    $board_name;
	protected ?string    $email;
	protected ?\DateTime $notified;

	// Persist functions
	public static function getPrimaryKey():string { return 'id'; }
	public static function isPrimaryKeyAutoIncrement():bool { return true; }
	public static function getTableName():string { return '`board_request`'; }
	public static function getFields():array {
		return [
			'id'                 => ['int', 11 ], 		//	int(11)
			'board_name'         => ['string', 50 ], 		//	varchar(50)
			'email'              => ['string', 80 ], 		//	varchar(80)
			'notified'           => ['Date', 0 ], 		//	date
		];
	}
}