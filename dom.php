<?php
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Content-Type: application/json; charset=UTF-8");

class testObject
{
    public $status;
    public $value;
}

$testObj = new testObject;
$testObj->status = "fine";
$testObj->value = "great";
$sendJSON = json_encode($testObj);

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('www-Authenticate: Basic realm=\"Private Area\"');
    header('HTTP/1.0 401 Unauthorized');
    print "Sorry, you need proper credentials";
    exit;
} else {
    // The request is using the POST method
    if (isset($_POST)) {
        // Tis is very IMPORTANT!!
        $request_body = file_get_contents('php://input');
        echo $request_body;
        echo $sendJSON;
    }
}
