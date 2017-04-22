<?php
/**
 * Description of smtpService.inc.php:
 *
 * @author rciampa
 */
class SMTPService {

private $to;
private $subject;
private $message;
private $lineLength;
        
function __construct($to, $subject, $message){
    $this->message = $message;
    $this->subject = $subject;
    $this->to = $to;
}

function setLineLength($length = 70){
    $this->lineLength = $length;
}

public function sendMail(){
    
    $this->message = wordwrap($this->message, $this->lineLength, "\r\n");
    
    $isSent = mail($this->to, $this->subject, $this->message);
    
    return $isSent;
}

}

?>