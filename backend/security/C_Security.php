<?php 
// ---------------- Instantiate Required Classes ------------ //
class Security
{
    public $mySQL;
    private $userLogin;
    private $userSignUp;
    private $logOut;
    public $userSettings;
    public $currentUser;
    public $searchFilter;
    public $userSearch;

    public function __construct($mySQL)
    {
        $this->mySQL = $mySQL;
        // Use connect function to establish a connection
        $this->mySQL->Connect();
        // ------------ Instantiate child Class ------------------- //
        // New login class instance, handles data verification process
        $this->userLogin = new LoginUser();
        // Sign Up intance, handles all sign up processes
        $this->userSignUp = new SignUp();
        // Log Out class
        $this->LogOut = new LogOut();
        // User Account instance
        $this->userSettings = new UserSettings();
        $this->userSettings->SetMySQL($this->mySQL);
        // Instantiate Search
        $this->userSearch = new UserSearch();
    }
    // --------------------------- Sign Up ----------------------- //
    // Sign Up Form password encryption
    public function SignUp($username, $password)
    {
        $this->currentUser = $username;
        // Handles Sign up calls and password encryption
        $this->userSignUp->SignUp($username, $password, $this->mySQL);
    }
    // ---------------------------- Login ------------------------ //
    // Login Form password verification
    public function Login($username, $password)
    {
        // LogIn User (Handles verification)
        $this->userSettings->SetCurrentUser($_POST['usernameLogin']);
        $this->userLogin->LoginUser($username, $password, $this->mySQL);
    }

    // ---------------------------- Logout ------------------------ //
    public function LogOut()
    {
        // Logout
        $this->LogOut->LogOut($this->mySQL);
    }

    // ---------------------------- Set Current User ------------------------ //
    private function SetCurrentUser($username)
    {
        $this->userSettings = $username;
    }

    // ---------------------------- Set Current User ------------------------ //
    public function SearchUser($sql)
    {
        $this->userSearch->searchUser($this->mySQL, $sql);
    }
}

?>