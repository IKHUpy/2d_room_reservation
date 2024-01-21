<?php
include '../connect_db.php';
session_start(); 
$token = $_SESSION['token'];
$email = $_SESSION['email'];
$query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room;";
$query2 = "SELECT start, end, reserver, is_fixed, day_of_week, subject_code, room_code, teacher_first_name, teacher_last_name FROM room_schedules WHERE reserver = ?";
$query3 = "SELECT start, end, reserver, is_fixed, day_of_week, subject_code, room_code, teacher_first_name, teacher_last_name FROM room_schedules";
$stmt2 = $connect->prepare($query2);
$stmt3 = $connect->query($query3);
$stmt = $connect->query($query);
if ($stmt && $stmt2->execute([$email]) && $stmt3) {
    $_SESSION['room'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['allRoomSchedule'] = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['myRoom'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="../styles3.css">
</head>
<body>
    <div>
        <header>
            <h1>Teacher Dashboard</h1>
            <h3><a href="./user/setting.php"><?php echo $_SESSION['email']?></a></h3>
        </header>
        <nav>
            <a href="../teacher/room.php">View Schedule</a>
            <a href="../room.php">View Rooms</a>
            <a href="#">Settings</a>
        </nav>
    </div>
    <div class="body">
        <div class="dashboard">
        </div>
    </div>
    <div>

    </div>
<?php
    
?>
<script src='../scripts/teacher_index.js'></script>
</body>
</html>


