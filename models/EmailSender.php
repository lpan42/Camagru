<?php
class EmailSender
{
    // Sends an HTML email. You can use basic HTML tags. You have to insert
    // new lines using <br /> or paragraphs. Uses the UTF-8 encoding.
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