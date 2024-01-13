<?php
include 'connect_db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT email, username, is_fulltime, token FROM teachers";
    $stmt = $connect->query($query);
    if ($stmt) {
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $email = $row['email'];
            $token = $row['token'];
            $query2 = "SELECT day_of_week, start_time, end_time, is_restricted FROM teacher_preferred_schedule WHERE token = ?";
            $stmt2 = $connect->prepare($query2);
            $stmt2->execute([$token]);
            $scheduleData = array();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $scheduleData[] = array(
                    'day_of_week' => $row2['day_of_week'],
                    'start_time' => $row2['start_time'],
                    'end_time' => $row2['end_time'],
                    'is_restricted' => $row2['is_restricted']
                );
            }
            $data[] = array(
                'email' => $email,
                'username' => $row['username'],
                'is_fulltime' => $row['is_fulltime'],
                'schedule' => $scheduleData
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
