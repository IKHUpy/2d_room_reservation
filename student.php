<?php
    session_start();
    if (isset($_COOKIE['session_id'])) {
        $userId = $_COOKIE['session_id'];
    }
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hello, Student</title>
    </head>
    <body>
        <?php 
            include 'functions.php';
            $status = getStatus();
            echo '<br><b>Status: '.$status.'<br>';
            if ($status === 'Offline') {
                echo "<h4>School Year hasn't been started yet.</h4>";
            } else {
                echo `
                <h1> Your Schedule: </h1>
                `;
            }
        ?>
    </body>
</html>