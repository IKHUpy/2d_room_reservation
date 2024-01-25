<?php
include '../connect_db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "UPDATE room_schedules SET start = ?, end = ?, day_of_week = ?, room_code = ? WHERE (id = ?);";
    $input_data = file_get_contents('php://input');
    $data = json_decode($input_data, true);
    if ($data === null) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit;
    }
    $selectedObjects = $data['selectedObjects'];
    $trial = array();
    foreach ($selectedObjects as $selectedObject) {
        $stmt = $connect->prepare($query);
        $room_code = $selectedObject['room_code'];
        $dayweek_time = $selectedObject['dayweek_time'];
        $room_sched_id = $selectedObject['room_sched_id'];
        list($day_of_week, $dateTime) = explode(' - ', $dayweek_time);
        list($start_time, $end_time) = explode(' — ', $dateTime);
        $room_sched_id_parts = explode('-', $room_sched_id);
        $id = intval(end($room_sched_id_parts));
        $start_time_24hr = date('H:i:s', strtotime($start_time));
        $end_time_24hr = date('H:i:s', strtotime($end_time));
        $trial[] = array(
            'start_time_24hr' => $start_time_24hr,
            'end_time_24hr' => $end_time_24hr,
            'day_of_week' => $day_of_week, 
            'room_code' => $room_code, 
            'id' => $id
        );
        $stmt->execute([$start_time_24hr, $end_time_24hr, $day_of_week, $room_code, $id]);
    };
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'data' => $trial]);
}
?>
