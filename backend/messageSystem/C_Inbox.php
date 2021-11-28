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

    public function getMessages($userID){
        // Call to receive all messages, sent and received
        $sql = "SELECT * FROM messageSystem WHERE sentby = '$userID' OR sentto = '$userID'";
        $messageData = $this->mySQL->query($sql);
        // If the query was a success, convert to data array
        if($messageData){
            $messages = [];
            while($row = $messageData->fetch_assoc()){
                $messages[] = $row;
            }
        }
        // Encode the result as JSON and return it
        return json_encode($messages);
    }

}

?>