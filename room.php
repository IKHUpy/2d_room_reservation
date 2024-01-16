<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room viewing</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="./styles3.css">
</head>
<body>
    <div>
        <header>
            <h1>Room viewing</h1>
            <h3><?php session_start(); echo $_SESSION['email']?></h3>
        </header>
        <nav>
            <a href="#">Settings</a>
        </nav>
    </div>
    <div class="room-body">
<?php
    include 'connect_db.php';
    $token = $_SESSION['token'];
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    $query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room;";
    $stmt = $connect->query($query);
    if ($stmt) {
        $data = array();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $roomCount = count($rows);

        if ($roomCounter < 0) {
            $roomCounter = 0;
        } elseif ($roomCounter >= $roomCount) {
            $roomCounter = $roomCount - 1;
        }
        $code = $rows[$roomCounter]['code'];
        $floorLevel = $rows[$roomCounter]['floor_level'];
        $hasProjector = $rows[$roomCounter]['has_projector'];
        $seatCount = $rows[$roomCounter]['seat_count'];
    
        echo "
        <button onclick='prevRoom()'>prev</button>
        <div class='row-data'>
            <p>Room code: <b>$code</b></p>
            <p>Floor level: <b>$floorLevel</b></p>
            <p>Has projector: <b>$hasProjector</b></p>
            <p>Seat count: <b>$seatCount</b></p>
        </div>
        <button onclick='nextRoom()'>next</button>
        <script>
            function prevRoom() {
                window.location.href = '?roomCounter=" . ($roomCounter - 1) . "';
            }
    
            function nextRoom() {
                window.location.href = '?roomCounter=" . ($roomCounter + 1) . "';
            }
        </script>
        ";
    }
?>
    </div>
</body>
</html>


