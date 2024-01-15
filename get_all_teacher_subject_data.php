<?php
include 'connect_db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT subject_code FROM teacher_subjects WHERE teacher_token = ?";
    $query1 = "SELECT email, token FROM teachers";
    $stmt1 = $connect->query($query1);
    
    if ($stmt1) {
        $data = array();
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $email = $row1['email'];  
            $token = $row1['token'];
            $stmt = $connect->prepare($query);
            $stmt->execute([$token]);
            $teacher_subject_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $data[] = array(
                'email' => $email,
                'schedule' => $teacher_subject_data
            );
        }
        echo json_encode($data);
    } else {
        echo "Error in query execution.";
    }
} else {
    echo "Invalid request method.";
}
?>
