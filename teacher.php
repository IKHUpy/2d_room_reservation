<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Teacher</title>
</head>
    <body>
        <a href="register.php">New here?</a>
        <form action="signIn_teacher.php" method="post">
            <p>
                <label for="">Enter mail:</label>
                <input type="text" name="email">
                <label for="">Enter password:</label>
                <input type="password" name="password">
                <input type="submit" value="Submit">

            </p>
        </form>
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