<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Binding</title>
</head>
<body>
    <h1>Email binding</h1>
    <form action="final_registration.php" method="POST">
        <label for="">First Name: </label>
        <input type="text" name="first_name" required><br>

        <label for="">Last Name: </label>
        <input type="text" name="last_name" required><br>

        <label for="">Username: </label>
        <input type="text" name="username" required><br>

        <label for="">School Email: </label>
        <input type="text" name="email" required><br>

        <label for="">Password: </label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>