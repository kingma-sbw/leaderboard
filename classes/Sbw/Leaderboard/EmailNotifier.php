<?php declare(strict_types=1);
namespace Sbw\Leaderboard;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Kingsoft\Db\Database as Database;

class EmailNotifier
{
    private PHPMailer $mail;
    private int       $success = 0;
    private int       $failed  = 0;

    public function __construct()
    {
        try {
            $this->mail = new PHPMailer( true );

            $this->mail->isSMTP();
            $this->mail->Host       = SETTINGS['mail']['host'];
            $this->mail->Port       = SETTINGS['mail']['port'];
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = SETTINGS['mail']['username'];
            $this->mail->Password   = SETTINGS['mail']['password'];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->CharSet    = "UTF-8";
            $this->mail->setFrom( SETTINGS['mail']['fromEmail'], SETTINGS['mail']['fromName'] );
        } catch ( Exception $e ) {
            LOG->alert( "Mail setup error: " . $e->getMessage() );
        }
    }

    public function sendNotifications(): void
    {
        try {
            $stmt = Database::getConnection()->query(
                "select `board_request`.`id`, `board_request`.`board_name`, `board_request`.`email`, `board_request`.`notified` from `board_request` where notified is null", );
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach( $rows as $request ) {
                $board             = new \Sbw\Leaderboard\Board();
                $board->board_name = $request["board_name"];
                $board->freeze();

                $request = new \Sbw\Leaderboard\BoardRequest( $request["id"] );
                $request->notified = new \DateTime();
                $request->freeze();
                $this->sendNotification( $request, $board );
            }

        } catch ( \Exception $e ) {
            LOG->alert( "Database error: " . $e->getMessage() );
        }
    }
    private function sendNotification( \Sbw\Leaderboard\BoardRequest &$request, \Sbw\Leaderboard\Board &$board ): void
    {
        $body = <<<EOT
        <h1Hallo {$request->board_name}</h1>,
        <p>Wir haben Deine Anfrage für die Board-Reservierung erhalten.</p>
        <p>Board Id ist: {$board->board_id}</p>
        <p>Bitte verwenden Sie diese ID, um auf das Board zuzugreifen.</p>
        EOT;

        $this->mail->Subject = "Leaderboard ID Anfrage";
        $this->sendEmail( $request, $body );
    }

    private function sendEmail( \Sbw\Leaderboard\BoardRequest &$request, string &$body ): void
    {
        $this->mail->clearAddresses();
        $this->mail->addAddress( $request->email, $request->board_name );
        $this->mail->Body = $body;

        $this->mail->send();
    }
}
