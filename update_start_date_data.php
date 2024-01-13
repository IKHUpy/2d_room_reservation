<?php
include ("connect_db.php");
$jsonData = file_get_contents('php://input');
$requestData = json_decode($jsonData, true);
if (isset($requestData["dateId"]) && isset($requestData["type"])) {
    $dateString = $requestData["dateId"];
    $month = substr($dateString, 0, 2);
    $day = substr($dateString, 3, 2);
    $year = '20' . substr($dateString, 6, 2);
    $formattedDate = date('Y-m-d', strtotime("$year-$month-$day"));
    if ($requestData["type"] == 0) {
        $query = "UPDATE program_status SET start_time = ? WHERE id = 1;";
    } else if ($requestData["type"] == 1) {
        $query = "UPDATE program_status SET end_time = ? WHERE id = 1;";
    }
    $stmt = $connect->prepare($query);
    $stmt->bindParam(1, $formattedDate);
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo 0;
    }
} else {
 echo 0;   
}
?>