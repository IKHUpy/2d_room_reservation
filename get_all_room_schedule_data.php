<?php
include 'connect_db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_SESSION['token'];
    $query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room;";
    $stmt = $connect->query($query);
    if ($stmt) {
        $data = array();
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
            $code = $row['code'];
            $query2 = "SELECT date_of_week, start_time, end_time, token, subject_code FROM preprocessed_room_schedule WHERE room_code = ?;";
            $stmt2 = $connect->prepare($query2);
            $stmt2->execute([$code]);
            $roomScheduleData = array();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $roomScheduleData[] = array(
                    'day_of_week' => $row2['day_of_week'],
                    'start_time' => $row2['start_time'],
                    'end_time' => $row2['end_time'],
                    'token' => $row2['token'],
                    'subject_code' => $row2['subject_id']
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
