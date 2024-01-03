<?php
include 'connect_db.php';
session_start();
$reset_stmt = $connect->prepare('DELETE FROM teacher_preferred_schedule WHERE token = ?;');
$nsrt_stmt = $connect->prepare('INSERT INTO teacher_preferred_schedule(token, day_of_week, start_time, end_time, is_restricted) VALUES (?, ?, ?, ?, ?);');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $token = $_SESSION['token'];
        $reset_stmt->execute([$token]);
        foreach ($_POST as $name => $value) {
            if ($value and $value != '3') {
                $scheduleArray = explode('_—_', $name);
                $end_time = date('H:i:s', strtotime(trim($scheduleArray[1])));
                $start_time = date('H:i:s', strtotime(trim(substr($scheduleArray[0], strrpos($scheduleArray[0], '_') + 1))));
                $day_of_week = trim(substr($scheduleArray[0], 0, strrpos($scheduleArray[0], '_-_')));
                if ($value == '2') {
                    $value = true;
                } else {
                    $value = false;
                }
                if ($nsrt_stmt->execute([$token, $day_of_week, $start_time, $end_time, $value])) {
                } 
            }
            
        }
        header('Location: teacherDashboard.php');
        exit();
    }
    header('Location: teacherDashboard.php');
    exit();
    
} else {
    header('Location: teacherDashboard.php');
    exit();
}
header('Location: teacherDashboard.php');
exit();
?>
