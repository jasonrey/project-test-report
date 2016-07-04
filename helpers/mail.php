<?php
!defined('SERVER_EXEC') && die('No access.');

require_once 'PHPMailer/PHPMailerAutoload.php';

class MailHelper extends Helper
{
	public function send($mailitem)
	{
		$mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = Config::$googleMailHost;
		$mail->Port = Config::$googleMailPort;
		$mail->Username = Config::$googleMailUsername;
		$mail->Password = Config::$googleMailPassword;

		$fromEmail = !empty($mailitem->fromEmail) ? $mailitem->fromEmail : Config::$googleMailUsername;
		$fromName = !empty($mailitem->fromName) ? $mailitem->fromName : Config::$googleMailName;

		$mail->SetFrom($fromEmail, $fromName);

		$mail->Subject = $mailitem->subject;

		$mail->isHTML(true);

		$mail->Body = $mailitem->body;

		$address = $mailitem->recipientEmail;
		$mail->AddAddress($mailitem->recipientEmail, $mailitem->recipientName);

		$mail->Send();
	}

	public function newMessage()
	{
		$item = new MailItem($this);

		return $item;
	}
}

class MailItem
{
	private $helper;

	public $body;
	public $recipientEmail;
	public $recipientName;
	public $subject;

	public function __construct($helper)
	{
		$this->helper = $helper;
	}

	public function send()
	{
		$this->helper->send($this);
	}
}
