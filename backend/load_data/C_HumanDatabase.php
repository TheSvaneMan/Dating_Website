<?php 
// ------------ Human Database Class ------ */
class HumanDatabase
{
    // Properties
    private $mySQL = null;

    // Methods
    public function __construct($mySQL)
    {
        $this->mySQL = $mySQL;
    }

    public function SearchByName($searchInput)
    {
        $sql = "SELECT * FROM humans WHERE firstname LIKE ('%" . $searchInput . "%')";
        $result = $this->mySQL->query($sql);
        return $result;
    }

    public function populateHumanArray()
    {
        include "loadJSON/B_LoadHumans.php";
        /* --------- Run through JSON file and parse data to new Human class objects --- */
        foreach ($humanJson as $jsonItem) {
            global $humanArray;
            $human = new Person();
            $human->SetId($jsonItem["PK_id"]);
            $human->SetAge($jsonItem["age"]);
            $human->SetGender($jsonItem["gender"]);
            $human->SetName($jsonItem["firstname"]);
            $human->SetBirthday($jsonItem["birthday"]);
            $human->SetHobbies($jsonItem["hobbies"]);
            $human->SetPostalCode($jsonItem["PostalCode"]);
            $human->SetHomeTown($jsonItem["homeTown"]);
            $human->SetCountry($jsonItem["countryName"]);
            $human->SetNationality($jsonItem["Nationality"]);
            $humanArray[] = $human;
        }
        echo $humanJson;
    }
}
?>
