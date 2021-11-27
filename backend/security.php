<?php
session_start();
header("Access-Control-Allow-Credentials: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Content-Type: x-www-form-urlencoded; charset=UTF-8");

// Gain access to the MySQL Class
require "mysql.php";
// Login functions -> Refactor to contain a login file with all scripts
require "security/C_Login.php";
// Sign up function ->
require "security/C_SignUp.php";
// Log Out Function
require "security/C_Logout.php";
// Set User Settings
require "user_account/C_UserSettings.php";
// Set Filter
require "user_account/C_Search.php";
// Security Class
require "security/C_security.php";
// Load Users (That created account and login)
require "security/B_LoadUsers.php";
// New Account
require "security/C_NewAccount.php";

// -------------------------- instantiate class and functions ------------------------------------ //
// I made nested security features to increase possible security modularity in the future.
$security = new Security($mySQL);

if (isset($_POST['login'])) {
    if (isset($_REQUEST['passwordLogin']) && isset($_REQUEST['usernameLogin']) && ($_POST['login']) == 'login') {
        // Login
        $username = $_REQUEST['usernameLogin'];
        $password = $_REQUEST['passwordLogin'];
        $security->Login($username, $password);
    }
} else if (isset($_POST['signUp'])) {
    if (isset($_REQUEST['usernameSignUp']) && isset($_REQUEST['passwordSignUp']) && ($_POST['signUp']) == "signUp") {
        // SignUp
        $username = $_REQUEST['usernameSignUp'];
        $password = $_REQUEST['passwordSignUp'];
        $security->SignUp($username, $password);
    }
} else if (isset($_POST['logOut'])) {
    if ($_POST['logOut'] == 'logOut') {
        // Logout function
        $security->LogOut();
    }
} else if (isset($_GET['action'])) {
    if ($_GET['action'] == 'activeUser') {
        // Returns the current active user ID found in online DB userLogin
        // Refactor needed to have login/signup Process create new user on main DB but keep seperate db for
        // Authentication purposes
        $id = $_SESSION['uniqueID'];
        // Find user name of this id
        $loginUserData = new userLoginData();
        $loginUserData->findLoginData($id, $mySQL);
    } else if ($_GET['action'] == 'createUser') {
        $newUser = json_decode(file_get_contents("php://input"));
        $userData = json_encode($newUser);
        $signUpUserData = new NewAccount($mySQL);
        $signUpUserData->AddUserToDB($newUser->Firstname, $newUser->Birthday, $newUser->Hobbies, $newUser->Country, $newUser->PostalCode, $newUser->Gender, $newUser->Age, $newUser->InterestedIn);
    } else if ($_GET['action'] == 'userStatus') {
        if (isset($_SESSION['uniqueID'])) {
            // Check and update User Log Status (Check if User is logged in)
            $PK_id = $_SESSION['uniqueID'];
            $checkStatus = "SELECT isLoggedIn FROM userlogin WHERE PK_id = '$PK_id'";
            $logStatusObject = $mySQL->query($checkStatus);
            $logStatus = $logStatusObject->fetch_object();
            if ($logStatus->isLoggedIn != null) {
                if ($logStatus->isLoggedIn == 1) {
                    $responseObject = new responseObject();
                    $responseObject->status = 200;
                    $responseObject->message = "User is Logged in!";
                    $sendObject = json_encode($responseObject);
                    echo $sendObject;

                } else {
                    $responseObject = new responseObject();
                    $responseObject->status = 400;
                    $responseObject->message = "User is not logged in.";
                    $sendObject = json_encode($responseObject);
                    echo $sendObject;
                }
            } else {
                $responseObject = new responseObject();
                $responseObject->status = 400;
                $responseObject->message = "User is not logged in.";
                $sendObject = json_encode($responseObject);
                echo $sendObject;
            }
        } else {
            $responseObject = new responseObject();
            $responseObject->status = 400;
            $responseObject->message = "User is not logged in.";
            $sendObject = json_encode($responseObject);
            echo $sendObject;
        }
    }
} else {
    echo "None of the above runs";
}
