<?php 
    session_start();
    if (isset($_COOKIE['session_id'])) {
        $userId = $_COOKIE['session_id'];
    } else {
        $sessionId = uniqid();
        $_SESSION['session_id'] = $sessionId;
        setcookie('session_id', $sessionId, time() + 360000, '/');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP Redirect Button</title>
    </head>
    <body>
        <h1>
            Sign in 
        </h1>
        <?php
            if (isset($_POST['user_name']) && isset($_POST['privilege_type'])) {
                $_SESSION['user_name'] = $_POST['user_name'];
                $redirectPage = $_POST['privilege_type'] . '.php';
                header("Location: $redirectPage");
                exit();
            }
        ?>
        <a href="student.php">As Student</a>
        <a href="teacher.php">As Teacher</a>
        <a href="laura.php">As Laura</a>
    </body>
</html>