<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
	private $sender_account = "ylhe@grandstream.cn";
	private $server_url 	= "hwsmtp.qiye.163.com";
	private $password		= "zgra201921HYL";
	function sendMail() {
        // Load Composer's autoloader
        require 'vendor/autoload.php';
		// include_once("PHPMailer/src/smtp.php");		    // php email class
        // include_once("PHPMailer/src/phpmailer.php");
		$mail = new PHPMailer(true);
		try {
			$mail->SMTPDebug = 0;							// Enable verbose debug output
			$mail->CharSet = "utf-8";						// coding
			$mail->IsSMTP();
			$mail->SMTPAuth   = true;						// must be ture for SMTP
			$mail->Host       = $this->server_url;		// can not / invaild
			$mail->Port       = 25;							// port
			$mail->Username   = $this->sender_account;			// choose 163 server
			$mail->Password   = $this->password;				// password token
			// $mail->SMTPSecure = 'ssl';
			$mail->setFrom($this->sender_account, "Auto_send");
			$mail->FromName   = "ATE_Robot";                // nickname
			$mail->Subject    = "test";                  	// title
	
			$mail->AddAddress("eli.he999@hotmail.com");
			$mail->IsHTML(true); 							// HTML
			$mail->Body    	  = 'This is the HTML message body <b>in bold!</b>';
			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	
	}
}