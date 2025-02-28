<?php declare(strict_types=1);
namespace Sbw\Leaderboard;

/**
 * Persistant DB object for table – last_scores
 */
final class LastScores
	extends \Kingsoft\Persist\Base
	implements \Kingsoft\Persist\IPersist
{
	use \Kingsoft\Persist\Db\DBPersistTrait;

	protected ?int       $id;
	protected ?string    $board_id;
	protected ?string    $leader_name;
	protected ?int       $score;
	protected ?\DateTime $date;

	// Persist functions
	static public function getPrimaryKey():string { return 'id'; }
	static public function isPrimaryKeyAutoIncrement():bool { return false; }
	static public function getTableName():string { return '`last_scores`'; }
	static public function getFields():array {
		return [
			'id'                 => ['int', 10 ], 		//	int(10) unsigned
			'board_id'           => ['string', 36 ], 		//	char(36)
			'leader_name'        => ['string', 255 ], 		//	varchar(255)
			'score'              => ['int', 11 ], 		//	int(11)
			'date'               => ['\DateTime', 0 ], 		//	datetime
		];
	}
}