<?php
include ("connect_db.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "SELECT start_time, end_time FROM program_status;";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($start_time, $end_time);
    $stmt->fetch();
    $stmt->close();
    echo json_encode(['start_time' => $start_time, 'end_time' => $end_time]);
} else {
    echo "Invalid request method.";
}
?>