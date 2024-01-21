
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Teacher</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: lato, sans-serif;
            background-color: #FFF108;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 100px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 16px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;

        }

        input[type="submit"] {
            background-color: #0271B9;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            margin-bottom: 16px;
            text-align: center;
            color: #007bff;
        }
    </style>
</head>
<body>
    <form action="signIn_teacher.php" method="post">
        <label for="email">Enter mail:</label>
        <input type="text" name="email" id="email">

        <label for="password">Enter password:</label>
        <input type="password" name="password" id="password">

        <a href="register.php">New here?</a>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
