<?php 
    session_start();

    if (isset($_COOKIE['session_id'])) {
        $userId = $_COOKIE['session_id'];
        echo "User ID from cookie: $userId";
    } else {
        $sessionId = uniqid();
        $_SESSION['session_id'] = $sessionId;
        setcookie('session_id', $sessionId, time() + 360000, '/');
        echo 'your session id is: ' . $_SESSION['session_id'];
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
        <form method="post">
            <p>
                <label for="user_name">Enter mail:</label>
                <input type="text" id="user_name" name="user_name">
                <label for="user_name">Enter password:</label>
                <input type="text" id="user_name" name="user_name">
            </p>
            <a href="register.php">New here?</a>
            <p>
                <input type="radio" name="privilege_type" value="teacher"> As Teacher
            </p>
            <p>
                <input type="radio" name="privilege_type" value="student"> As Student
            </p>
            <p>
                <input type="radio" name="privilege_type" value="laura"> As Laura
            </p>
            <p>
                <button type="submit">Submit</button>
            </p>
        </form>
    </body>
</html>