<?php
// Starts a new session for a user that enter the website, IMPORTANT **
session_start();
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

// ------------ Classic Imports ------  //
// MySQL
require('mysql.php');
// Person Class
require "user_account/C_Person.php";
// Data Loading Humans
require "load_data/C_LoadHumans.php";
// Search Function
require "user_account/C_Search.php";
// Response Object
require "security/C_ResponseObject.php";
// ------------ Standard User Service ------  //
$humanArray = [];
// ------------ Load User Services ------  //
$loadUsers = new LoadHumans($mySQL);
// ------------ Checks Services ------  //
// Currently works with JSON Data, needs to be converted to have 
// dual backup of JSON data and having a live online database 
// Maybe build a service that checks version states
// ------------ Checks Services ------  //

if($_GET['action'] == 'getUsers') {
    // Load Data from JSON
    // $humanArray = $loadUsers->GetJSONData();
    // Load Data from DB
    $humanArray = $loadUsers->GetOnlineData();
    //var_dump($allUsers);
    echo $humanArray;
} else if ($_GET['action'] == 'getMatches') {
    // Load Data from DB 
    $id = $_SESSION['userInfo']['userID'];
    $matchesArray = $loadUsers->GetMatches($id);
    echo $matchesArray;
}
else if ($_GET['action'] == 'MaleOnly') {
    /* --------- Filters ------- */
    /* --------- Displays filtered male list ------- */
    foreach($users as $user){
        if($user->gender == "male"){
            array_push($humanArray, $user);
        }
    }
    echo json_encode($humanArray);
} else if ($_GET['action'] == 'FemaleOnly') {
    foreach($users as $user){
        if($user->gender == "female"){
            array_push($humanArray, $user);
        }
    }
    echo json_encode($humanArray);
} else if ($_GET['action'] == 'SameAge') {
    foreach($users as $user){
        if($user->age == $this->activeUser->GetAge()){
            array_push($humanArray, $user);
        }
    }
    echo json_encode($humanArray);
} else if ($_GET['action'] == 'DifferentAge') {
    if(isset($_GET['selectedAge'])){
        $age = $_GET['value'];
        foreach($users as $user){
            echo "This is running";
            if($user->age == $this->activeUser->GetAge() + $age){
                array_push($humanArray, $user);
            }
        }
        if(count($humanArray) == 0){
            echo "No matches found";
        } else {   
            echo json_encode($humanArray);
        }
    }
} else if (isset($_POST['randomPerson'])) {
    $humanArray = array_filter($humanArray, function ($human) {
        // Return true and keep this product on the list
        //return $human->GetAge() === $activeUser->GetAge() + 2;
    });
} else if ($_GET['action'] == "search") {
    // SQL query to search for users on db, matching the user's search input (LIKE is the keyword to do searches)
    $sql = "SELECT * FROM humans WHERE firstname LIKE ('%" . $_GET['value'] . "%')";
    $search = new UserSearch();
    $search->searchUser($mySQL, $sql);
} else if ($_GET['action'] == "addMatch"){
    $selectedUser = json_decode(file_get_contents("php://input"));
    $userOne = $_SESSION['userInfo']['userID'];
    $userTwo = $selectedUser->ID;
    // SQL query to add matches
    $sql = "CALL AddMatch(" . $userOne . ", " . $userTwo . ")";
    $mySQL->query($sql);
    $responseObject = new responseObject();
    $responseObject->status = 200;
    $responseObject->message = $userTwo;
    $sendObject = json_encode($responseObject);
    echo $sendObject;
}
?>