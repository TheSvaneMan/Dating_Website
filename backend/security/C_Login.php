<?php
class LoginUser
{
    public function LoginUser($setUsername, $setPassword, $mySQL)
    {
        // Check database if username exiss / If not, throw error
        // Verify Password : TRUE || FALSE
        // $hashkey = $passEncrypt : is the password saved in the database
        $username = $setUsername;
        $password = $setPassword;

        $loginUser = "SELECT userName FROM userlogin WHERE userName = '$username'";

        if ($mySQL->query($loginUser)) {
            $passwordCall = "SELECT userPassword FROM userlogin WHERE userName = '$username'";
            $encryptedPass = $mySQL->query($passwordCall);
            $hashkey = $encryptedPass->fetch_object();
            if ($hashkey !== null) {
                $passVerify = password_verify($password, $hashkey->userPassword);
                // Get User ID
                $loginData = "SELECT * FROM userlogin WHERE userName = '$username'";
                $userData = $mySQL->query($loginData);
                $loginID = $userData->fetch_object();
                var_dump($loginID);

                if ($passVerify) {
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
                    // Login and track that the user is logged in
                    $loggedIn = "UPDATE userlogin SET isLoggedIn = 1 WHERE userName = '$username'";
                    $mySQL->query($loggedIn);

                    echo "Password Verified";
                    // Redirect user to home page
                    header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/home");
                    exit();
                } else {
                    echo "Sorry, an error occured with the authentication process";
                    // Redirect user to sign up page
                    header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/");
                    exit();
                }
            } else {
                echo "Sorry, incorrect password, username or user is not registered.";
                // Redirect user to sign up page
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/");
                exit();
            }
        } else {
            echo "User name doesn't exist";
            // Redirect user to sign up page
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "#/");
            exit();
        }
    }
}
