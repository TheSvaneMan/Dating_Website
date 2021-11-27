<?php
class LoadHumans
{
    public $mySQL;
    public function __construct($mySQL)
    {
        $this->mySQL = $mySQL;
    }
    public function GetJSONData()
    {
        // Get local storage json
        $jsonFile = file_get_contents("load_data/all-users-all-data.json");
        return $jsonFile;
    }
    public function GetJSONDataDecoded()
    {
        // Get local storage json
        $jsonFile = file_get_contents("load_data/all-users-all-data.json");
        $users = json_decode($jsonFile);
        return $users;
    }
    public function GetOnlineData()
    {
        // MySQL Request for all Users
        $selectAllUsers = "SELECT * FROM humans";
        $allUsers = $this->mySQL->query($selectAllUsers);
        // Create an array for the JSON response, and set the 'status' and 'errorCode'
        $json = [];
        // If the query was a success, then convert all the results to a data array
        if ($allUsers) {
            $data = [];
            while ($row = $allUsers->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // Encode the result as JSON and return it
        return json_encode($data);
    }

    public function GetMatches($id)
    {
        // SQL query to get all matches and fitler it to get only matches of current user
        $sql = "SELECT * FROM matchesmade WHERE userOne = '$id' OR userTwo = '$id'";
        $matches = $this->mySQL->query($sql);
        // Create an array for the JSON response, and set the 'status' and 'errorCode'
        $json = [];
        // If the query was a success, then convert all the results to a data array
        if ($matches) {
            $data = [];
            while ($row = $matches->fetch_assoc()) {
                $data[] = $row;
            }
            // Encode the result as JSON and return it
            return json_encode($data);

        }

    }
} ?>
