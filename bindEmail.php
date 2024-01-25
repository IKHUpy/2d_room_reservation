<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <style>
        form img {
            height: 20px;
        }
        body {
            font-family: 'Lato', sans-serif;
            background-color: #C0E0DE;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            min-height: 100vh; /* Ensure full height of the viewport */
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            position: relative;
            max-width: 400px;
            width: 100%; /* Full width */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
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

        .logo {
            position: absolute;
            top: 3%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 150px;
        }

    </style>
</head>
<body>
    <form action="verify_token.php" method="POST">
        <img src="img/stilogo.png" alt="Logo" class="logo">
        <h1>Registration</h1>

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required>

        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
