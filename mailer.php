<?php declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

//require_once "./vendor/autoload.php";

require 'global.php';

$phpmailer = new PHPMailer( true );
$sender    = 'info@sbw.media';
$server    = $_SERVER[ 'HTTP_HOST' ] ?? 'localhost';	
$phpmailer->isSMTP();

$phpmailer->Host     = SETTINGS[ 'mail' ][ 'host' ];
$phpmailer->Port     = SETTINGS[ 'mail' ][ 'port' ];
$phpmailer->SMTPAuth = true;

$phpmailer->Username   = SETTINGS[ 'mail' ][ 'username' ];
$phpmailer->Password   = SETTINGS[ 'mail' ][ 'password' ];
$phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

$phpmailer->setFrom( $sender, SETTINGS[ 'mail' ][ 'fromName' ] );
$phpmailer->addReplyTo( $sender, SETTINGS[ 'mail' ][ 'fromName' ] );
$phpmailer->Sender    = $sender;
$phpmailer->MessageID = '<' . uniqid() . '@sbw.media>';

$phpmailer->XMailer = ' ';

$phpmailer->addAddress( 'kingma@sbw-media.ch', 'Johannes Kingma' );

$phpmailer->Subject = "Neuer Service jetzt verfügbar – Wir informieren Sie";
$phpmailer->isHTML( true );
$phpmailer->CharSet = "UTF-8";
$a                  = SETTINGS[ 'mail' ][ 'fromEmail' ];
$phpmailer->Body    = <<<"BODY"
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 15 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Aptos;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:0cm;
	line-height:115%;
	font-size:12.0pt;
	font-family:"Aptos",sans-serif;}
.MsoPapDefault
	{margin-bottom:8.0pt;
	line-height:115%;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:70.85pt 70.85pt 2.0cm 70.85pt;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=DE-CH style='word-wrap:break-word'>

<div class=WordSection1>

<p class=MsoNormal>Sehr geehrte Damen und Herren,</p>

<p class=MsoNormal>wir freuen uns, Sie dar&uuml;ber zu informieren, dass unser neuer
Service erfolgreich aufgeschaltet wurde und ab sofort f&uuml;r Sie zur Verf&uuml;gung
steht.</p>

<p class=MsoNormal>Mit diesem neuen Angebot profitieren Sie von "Leaderboard"-API.
Eine genau Beschreibung finden Sie auf der Website.</p>

<p class=MsoNormal>Was bedeutet das f&uuml;r Sie? Sie k&uuml;nnen den neuen Service ab
sofort nutzen. Eine Anleitung zur Verwendung finden Sie unter: $sender
Falls Sie Fragen haben oder Unterst&uuml;tzung ben&uuml;tigen, steht Ihnen unser
Support-Team gerne zur Verf&uuml;gung. </p>

<p class=MsoNormal>Kontakt: $sender</p>

<p class=MsoNormal>&nbsp;</p>

</div>

</body>

</html>

BODY;

$result = $phpmailer->send();

echo $result ? "Mail sent" : "Mail not sent";

echo "<br>";
/*
    'host'      => 'tesla.sui-inter.net',
    'port' => '465',
    'username' => 'mv@plc.sbw.media',
    'password' => 'I.3L:)c$y.=if]HC2),&o&.0)D^*j4$D:(B2T&}A_D/KgvMg29Iz!,;0be',
    'fromEmail' => 'info@sbw-media.ch',
    'fromName' => 'SBW Neue Medien'
*/
