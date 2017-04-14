<php?

class SMTPService {

private $to = "rciampa@csumb.edu";
private $subject;
private $message;
private $wrap = 80;


void ____construct($message, $subject){
    $this->$message = $message;
    $this->$subject = $subject;
}


public function sendMail(){
    $message = wordwrap($message, $wrap, "\r\n");
    if(mail($to, $subject, $message)){
        dblogSentMail();
    }
}

private function dblogSentMail(){



}



}





?>