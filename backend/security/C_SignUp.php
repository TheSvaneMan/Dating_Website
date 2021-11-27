<?php 
class SignUp{
      public function SignUp($username, $password, $mySQL){
        $passEncrypt = password_hash($password, PASSWORD_DEFAULT);
        $userData = "CALL registerNewUser('$username', '$passEncrypt')";
        $mySQL->query($userData);
        // "Username is " . $username . " and password is encrypted into " . $passEncrypt; 
        echo "You have successfully signed up, please log in to continue";
        // Redirect user to login page
        // Save Login ID to session to give it to user for next process
        $loginIDCall = "SELECT PK_id FROM userlogin WHERE userName = '$username'";
        $userID = $mySQL->query($loginIDCall);
        $loginID = $userID->fetch_object();
        if (isset($_SESSION['userInfo'])) {
            $_SESSION['userInfo']['PK_id'] = $loginID->PK_id;
        } else {
           $_SESSION['userInfo']['PK_id'] = $loginID->PK_id;
        }
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/signUp");
        exit(); 
    }
}

?>