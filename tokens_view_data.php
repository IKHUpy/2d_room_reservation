<?php
include 'connect_db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $recordsPerPage = 15;
    $offset = ($page - 1) * $recordsPerPage;
    $query = "SELECT id, token, associated_email FROM invitation_tokens 
    ORDER BY associated_email 
    IS NOT NULL DESC, associated_email 
    LIMIT ? OFFSET ?;";
    $getData_stmt = $connect->prepare($query);
    $getData_stmt->bindParam(1, $recordsPerPage, PDO::PARAM_INT);
    $getData_stmt->bindParam(2, $offset, PDO::PARAM_INT);
    if ($getData_stmt->execute()) {
        $results = $getData_stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Invalid request method.";
}
?>