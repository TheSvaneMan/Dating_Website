<?php
// Creates Person class
class Person
{
    private $PK_id;
    private $firstname;
    private $birthday;
    private $hobbies;
    private $PostalCode;
    private $gender;
    private $age;
    private $homeTown;
    private $countryName;
    private $nationality;

    // Getters & Setters
    public function GetId()
    {
        return $this->PK_id;
    }
    public function SetId($value)
    {
        $this->pkId = $value;
    }
    public function GetAge()
    {
        return $this->age;
    }
    public function SetAge($value)
    {
        $this->age = $value;
    }
    public function GetGender()
    {
        return $this->gender;
    }
    public function SetGender($value)
    {
        $this->gender = $value;
    }
    public function GetName()
    {
        return $this->firstname;
    }
    public function SetName($value)
    {
        $this->firstname = $value;
    }
    public function GetBirthday()
    {
        return $this->birthday;
    }
    public function SetBirthday($value)
    {
        $this->birthday = $value;
    }
    public function GetHobbies()
    {
        return $this->hobbies;
    }
    public function SetHobbies($value)
    {
        $this->hobbies = $value;
    }
    public function GetPostalCode()
    {
        return $this->PostalCode;
    }
    public function SetPostalCode($value)
    {
        $this->PostalCode = $value;
    }
    public function GetHomeTown()
    {
        return $this->homeTown;
    }
    public function SetHomeTown($value)
    {
        $this->homeTown = $value;
    }
    public function GetCountry()
    {
        return $this->countryName;
    }
    public function SetCountry($value)
    {
        $this->countryName = $value;
    }
    public function GetNationality()
    {
        return $this->nationality;
    }
    public function SetNationality($value)
    {
        $this->nationality = $value;
    }
    public function DisplayPersonInfo(){?>
        <p>ID: <?php echo ($this->PK_id); ?></p>
        <p>Name: <?php echo ($this->firstname); ?></p>
        <p>Birthday: <?php echo ($this->birthday); ?></p>
        <p>Hobbies: <?php echo ($this->hobbies); ?></p>
        <p>PostalCode: <?php echo ($this->PostalCode); ?></p>
        <p>Gender: <?php echo ($this->gender); ?></p>
        <p>Age: <?php echo ($this->age); ?></p>
        <p>Home Town: <?php echo ($this->homeTown); ?></p>
        <p>Country Name: <?php echo ($this->countryName); ?></p>
        <p>Nationality: <?php echo ($this->nationality); ?></p>
    <?php }
}
