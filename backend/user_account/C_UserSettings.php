<?php
class UserSettings
{
    public $imgURL = null;
    private $userId = "";
    public $userName = "";
    public $mySQL = null;
    public $error = "";

    public function SetMySQL($mySQL)
    {
        $this->mySQL = $mySQL;
    }
    public function GetMySQL()
    {
        return $this->mySQL;
    }
    public function SetCurrentUser($name){
        $this->userName = $name;
    }
    public function GetCurrentUser(){
        return $this->userName;
        var_dump($this->userName);
    }
    // Get Specifically Profile Picture
    public function GetImage($id)
    {
        $this->userId = $id;
        $getImage = "SELECT profilePictureURL FROM userSettings WHERE userID = '$this->userId'";
        $imageObject = $this->mySQL->query($getImage);
        $imageFetch = $imageObject->fetch_object();
        if ($imageFetch) {
            $this->imgURL = $imageFetch->profilePictureURL;
            echo $this->imgURL;
        } else {
            echo "No profile picture set";
            $this->error = "No profile picture set";
        }
    }
    // Error handling
    public function GetError(){
        echo $this->error;
    }
}
?>