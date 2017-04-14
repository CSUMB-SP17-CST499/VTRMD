<?php

include_once 'appDataAcess.inc.php';

class SMTPService {

private $to = "rciampa@csumb.edu";
private $subject;
private $message;


function __construct($message, $subject){
    $this->$message = $message;
    $this->$subject = $subject;
}

private function dblogSentMail($to, $subject, $message){
    logEmailMessage($to, $subject, $message);
}

public function sendMail($lineLength = 80){
    
    //Call the class variables
    global $to, $subject, $message;
    
    $message = wordwrap($message, $lineLength, "\r\n");
    if(mail($to, $subject, $message)){
        $this->dblogSentMail($to, $subject, $message);
    }
}



}

?>