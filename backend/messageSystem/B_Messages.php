<?php 
session_start();
// Gain access to the MySQL Class
require "../mysql.php";
require "C_Inbox.php";
$Inbox = new Inbox($mySQL);

if(isset($_GET['action'])){
    if($_GET['action'] == 'sendMessage'){
        // Do not encode, leave it object to access properties
        $messageData = json_decode(file_get_contents("php://input"));
        // $messageData = json_encode($newMessage);
        $sender = $_SESSION['userInfo']['userID'];
        $message = $messageData->message;
        $receiver = $messageData->receiver;
        $Inbox->sendMessage($message, $sender, $receiver);
    }
}
?>