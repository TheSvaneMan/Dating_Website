<?php
require("../mysql.php");
// Image Upload
class UploadImage{
    public function uploadImage($mySQL){
        $file = $_FILES["fileToUpload"];
        $targetFolder = "../../original/";
        $fileName = basename($file["name"]);
        move_uploaded_file($file["tmp_name"], $targetFolder . $fileName);
        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        // var_dump($file);
        // Image Size
        $fileSize = $file["size"];
        //$fileDir = $targetFolder . $fileName;
        $uniqueID = $_SESSION['uniqueID'];
        //echo $fileDir;
        // Send image url to userSettings db
        $userData = "CALL uploadImage($uniqueID, '$fileName')";
        $mySQL->query($userData);
        header("Location:/home.php");
    }
}
if (ISSET($_FILES["fileToUpload"]) && ISSET($_POST["uploadPhoto"])) {
    $uploadImage = new uploadImage();
    $uploadImage->uploadImage($mySQL);
}else {
    echo ("An error has occured");
}
?>