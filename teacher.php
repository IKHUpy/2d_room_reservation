<?php
    session_start();
    if (isset($_COOKIE['session_id'])) {
        $userId = $_COOKIE['session_id'];
        echo "User ID from cookie: $userId";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Teacher</title>
</head>
    <body>
        <?php 
            include 'functions.php';
            $status = getStatus();
            echo '<br><b>Status: '.$status.'<br>';
            if ($status === 'Offline') {
                echo "<h1>Teacher's Dashboard</h1>";
            } else {
                echo `
                <h1> Your Schedule: </h1>
                `;
            }
        ?>
    </body>
</html>