<?php
    include 'connect_db.php';
    
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "select count(*) from invitation_tokens where associated_email is not null;";
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