<?php
class MySQL
{
    public $error = null;

    private $server = "";
    private $username = "";
    private $password = "";
    private $database = "";

    private $mySQL = null;

    public function SetDatabase($setDatabase)
    {
        $this->database = $setDatabase;
    }

    public function SetServer($setServer, $setUsername, $setPassword)
    {
        $this->server = $setServer;
        $this->username = $setUsername;
        $this->password = $setPassword;
    }
    public function Connect()
    {
        // Fill in connection function
        $this->mySQL = new mysqli($this->server, $this->username, $this->password, $this->database);
        // Check connection
        if ($this->mySQL->connect_errno) {
            echo "Failed to connect to the host server " . $mysqli->$connect_errno;
            exit();
        }
        // If error occurs with connection issues
        if (!$this->mySQL) {
            die("Could not connect to the database entry point, reason: " . mysqli_connect_error());
        }
    }
    public function Disconnect()
    {

    }
    public function Query($query, $returnAsJSON = false)
    {
        // Make the query call to the database
        $result = $this->mySQL->query($query);

        if ($returnAsJSON) {
            // Create an array for the JSON response, and set the 'status' and 'errorCode'
            $json = [];
            $json["status"] = $result ? "success" : "failed";
            $json["errorcode"] = $result ? "" : "Wrong query";

            // If the query was a success, then convert all the results to a data array
            if ($result) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                $json['data'] = $data;
            }

            // Encode the result as JSON and return it
            return json_encode($json);
        } // else the return should be an object
        else {
            if ($result) {
                return $result;
            } else {
                $this->error = "Wrong query";
                return false;
            }
        }
    }
} 

// Create a new instance of the MySQL class and establish a connection
$mySQL = new MySQL();
// Set the database
$mySQL->SetDatabase("dating_website");
$mySQL->SetServer("localhost", "root", "Pendakanime1996");
$mySQL->Connect();

?>
