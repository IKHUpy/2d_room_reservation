<?php
include 'connect_db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_SESSION['token']
    $query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room";
    $query3 = "SELECT email FROM teachers WHERE token = ?";
    $stmt1 = $connect->query($query3);
    $stmt = $connect->query($query);
    if ($stmt && $stmt1) {
        $data = array();
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) && ($row3 = $stmt1->fetch(PDO::FETCH_ASSOC))) {
            $code = $row['code'];
            $email = $row3['email'];
            $query2 = "SELECT day_of_week, start_time, end_time, is_restricted, token, subject_id FROM preprocessed_room_schedule WHERE room_code = ?";
            $stmt2 = $connect->prepare($query2);
            $stmt2->execute([$code]);
            $roomScheduleData = array();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $roomScheduleData[] = array(
                    'day_of_week' => $row2['day_of_week'],
                    'start_time' => $row2['start_time'],
                    'end_time' => $row2['end_time'],
                    'token' => $row2['token'],
                    'subject_id' => $row2['subject_id'],
                    'is_restricted' => $row2['is_restricted']
                );
            };
            $data[] = array(
                'room_code' => $code,
                'floor_level' => $row['floor_level'],
                'has_projector' => $row['has_projector'],
                'seat_count' => $row['seat_count'],
                'roomSchedule' => $roomScheduleData
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
