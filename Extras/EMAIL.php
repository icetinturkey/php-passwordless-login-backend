<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

class EMAIL
{
  private $alici;
  private $konu;
  private $mesaj;
  private $eklenti;

  public function __construct($rD2,$rD3,$rD4){
    $this->alici = $rD2;
	$this->konu = $rD3;
	$this->mesaj = $rD4;
  }

  function send() {
	$result = array("Status"=>"ERROR", "Message"=>"Unknown Error !");
	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->Host='provider.yourdomain.com';
		$mail->SMTPAuth=true;
		$mail->Username='support@yourdomain.com';
		$mail->Password='';
		$mail->SMTPSecure=PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port=465;
		$mail->setFrom('support@yourdomain.com', 'Support');
		$mail->addAddress($this->alici);
		$mail->addReplyTo('support@yourdomain.com', 'Support');
		$mail->isHTML(true);
		$mail->Subject=$this->konu;
		$mail->Body=$this->mesaj;
		$mail->AltBody=strip_tags($this->mesaj);
		$mail->CharSet=PHPMailer::CHARSET_UTF8;
		$mail->send();
		$result = array("Status"=>"SUCCESS", "Message"=>"Message sended.");
	} catch (Exception $e) {
		$result = array("Status"=>"ERROR", "Message"=>$mail->ErrorInfo);
	}
    return $result;
  }
}
?>