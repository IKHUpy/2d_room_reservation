<?php 
include ("connect_db.php");
$jsonData = file_get_contents('php://input');
$requestData = json_decode($jsonData, true);
if (isset($requestData["token"]) ) {
    $tokenValue = $requestData["token"];
    $query = "DELETE FROM invitation_tokens WHERE token = ?;";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(1, $tokenValue);
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo 0;
    }
} else {
 echo 0;   
}
?>