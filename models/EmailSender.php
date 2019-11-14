<?php
class EmailSender
{
    public static function send($recipient, $subject, $message)
    {
        $header = "From: ashley.lepan@gmail.com";
		$header .= "\nMIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"\n";
		if (!mb_send_mail($recipient, $subject, $message, $header))
			throw new UserException('Unable to send the email.');
    }
}

?>