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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #FFF108;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .sign-in-box {
            font-family: 'Lato', sans-serif;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-family: 'Lato', sans-serif;
            font-weight: 900;
            color: #333;
        }

        a {
            font-family: 'Lato', sans-serif;
            font-weight: 400;
            display: block;
            margin: 10px 0;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #0271b9;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #C0E0DE;
        }
    </style>
</head>
<body>
    <div class="sign-in-box">
        <h1>Sign in</h1>

        <?php
            if (isset($_POST['privilege_type'])) {
                $redirectPage = $_POST['privilege_type'] . '.php';
                header("Location: $redirectPage");
                exit();
            }
        ?>

        <form action="" method="post">
            <label for="privilege_type">Select Privilege:</label>
            <a href="student.php">As Student</a>
            <a href="teacher.php">As Teacher</a>
            <a href="laura.php">As Laura</a>
        </form>
    </div>
</body>
</html>