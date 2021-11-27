<?php 
include("C_ResponseObject.php");
class NewAccount{
    public $mySQL;
    public function __construct($mySQL){
        $this->mySQL = $mySQL;
    }
    public function AddUserToDB($firstname, $birthday, $hobbies, $country, $postalCode, $gender, $age, $interestedIn ){
        $uniqueValue = $_SESSION['userInfo']['PK_id'];
        // Random Value helps with unique account creation
        $addUser = "CALL AddNewUser('$firstname', NOW(), '$hobbies', '$country', '$postalCode', '$gender', '$age', '$interestedIn', '$uniqueValue')";
        // Requires additional security to prevent random upload 
        $this->mySQL->query($addUser);
        //sleep for 2 seconds, gives server time to conduct previous query
        // sleep(2);
        // Save Login ID to session to give it to user for next process
        $newAccIDCall = "SELECT PK_id FROM humans WHERE uniqueID = '$uniqueValue'";
        $userID = $this->mySQL->query($newAccIDCall);
        $newAccID = $userID->fetch_object();
        // Add this PK_id to login
        $addToLoginDB = "UPDATE userlogin SET userID = '$newAccID->PK_id' WHERE PK_id = '$uniqueValue'";
        $this->mySQL->query($addToLoginDB);
        // Search DB
        // Get User ID
        $PK_id = $_SESSION['userInfo']['PK_id'];
        $loginData = "SELECT * FROM userlogin WHERE PK_id = '$PK_id'";
        $userData = $this->mySQL->query($loginData);
        $loginID = $userData->fetch_object();

        // Parent array of all user info
        if (!isset($_SESSION['userInfo'])) {
            
            $_SESSION['userInfo'] = array();
            $_SESSION['userInfo']['PK_id'] = $loginID->PK_id;
            $_SESSION['userInfo']['userID'] = $loginID->userID;

        } else {
            if (isset($_SESSION['userInfo'])) {
                $_SESSION['userInfo']['PK_id'] = $loginID->PK_id;
                $_SESSION['userInfo']['userID'] = $loginID->userID;
            } else {
                $_SESSION['userInfo']['PK_id'] = $loginID->PK_id;
                $_SESSION['userInfo']['userID'] = $loginID->userID;
            }
        }


        $responseObject = new responseObject();
        $responseObject->status = 200;
        $responseObject->message = "Account Creation Successful!";
        $sendObject = json_encode($responseObject);
        echo $sendObject;

    }
}

?>