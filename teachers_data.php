<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT full_name, email, is_fulltime FROM teachers;";
    $stmt = $connect->query($query);

    if ($stmt !== false) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo "Error in query execution.";
    }
} else {
    echo "Invalid request method.";
}
?>
