<?php 
class userLoginData{
    // This function is primarily used to find the logged in user 
    // to help with Session management and data persistence
    public function findLoginData($userID, $mySQL){
        $findUser = "SELECT userName FROM userlogin WHERE PK_id = '$userID'";
        $LoggedInUser = $mySQL->query($findUser);
        $user = $LoggedInUser->fetch_object();
        echo json_encode($user);
    }
}
?>