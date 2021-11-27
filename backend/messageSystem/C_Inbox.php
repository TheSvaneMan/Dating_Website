<?php 
class Inbox{
    private $mySQL;

    public function __construct($mySQL){
        $this->mySQL = $mySQL;
    }

    public function sendMessage($message, $sender, $receiver){
        // Calls procedure that adds new message to DB
        $sql = "CALL sendMessage('$message', '$sender', '$receiver')";
        $this->mySQL->query($sql);
        echo "Message : " . $message;
        echo "Sender: " . $sender;
        echo "Receiver: " . $receiver;
    }

}

?>