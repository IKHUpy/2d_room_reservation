<?php
include '../functions.php';
session_start(); 
updateData($_SESSION['token'], $_SESSION['email']);
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


