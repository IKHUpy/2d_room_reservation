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
            <h3><?php session_start(); echo $_SESSION['email']?></h3>
        </header>
        <nav>
            <a href="#">Settings</a>
        </nav>
    </div>
    <div class="body">
        <div class="dashboard">
            <a href="../room.php" onclick="callTeacherSchedule(); callRoomSchedule();">Check Rooms</a>
        </div>
    </div>
<?php
    
?>
<script src='../scripts/teacher_index.js'></script>
</body>
</html>


