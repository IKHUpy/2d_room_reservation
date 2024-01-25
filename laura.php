<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Laura</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-image: url('img/bglogin.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
        }

        header img {
            width: 80px;
            height: auto;
            margin-right: 10px; 
        }

        header h1 {
            margin: 0;
        }

        form {
            background-color: #ffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            }

           @media (min-width: 768px) {

       form {
            margin-left: auto;
            margin-right: 250px;
        }
    }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #0271b9;
            color: #fff;
            padding: 10px;
            border: #0271b9;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #C0E0DE;
        }
    </style>
</head>
<body>
    <header>
        <img src="img/stilogo.png" alt="Your Logo">
        <h1>Laura Help Desk</h1>
    </header>
    <form action='lauraLogin.php' method="post">
        <h1>Welcome, Admin</h1>
        <label for="password">Enter Password:</label>
        <input type="password" name="password" required>
        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>
