<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bindEmail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <style>
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
            border: none;
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
    <form action="final_registration.php" method="POST">
        <img src="img/3_1_-removebg-preview.png" alt="Logo" class="logo">
        <h1>Email binding</h1>

        <label for="first_name">First Name: </label>
        <input type="text" name="first_name" id="first_name" required><br>

        <label for="last_name">Last Name: </label>
        <input type="text" name="last_name" id="last_name" required><br>

        <label for="username">Username: </label>
        <input type="text" name="username" id="username" required><br>

        <label for="email">School Email: </label>
        <input type="text" name="email" id="email" required><br>

        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
