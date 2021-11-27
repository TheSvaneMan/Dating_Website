<?php 
class LogOut{
    public function LogOut($mySQL){
        // Login and track that the user has logged out
        $uniqueID = $_SESSION['uniqueID'];
        $loggedOut = "UPDATE userlogin SET isLoggedIn = 0 WHERE PK_id = '$uniqueID'";
        $mySQL->query($loggedOut);
        session_destroy();
        // Redirects users once the session has ended, prevents loops
        // Redirect user to Sign In page
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/");
        exit();
    }
}

?>