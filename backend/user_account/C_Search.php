<?php
class UserSearch
{
    public function searchUser($mySQL, $sql)
    {
        // Check if SQL call was a success
        $result = $mySQL->query($sql);  
            // If the query was a success, then convert all the results to a data array
            if ($result) {
                $data = [];
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                $data["data"] = $data;
                echo json_encode($data['data']);
            }
    }
}
