<?php
include 'connect_db.php';
$query = 'use room;';
$stmt = $connect->prepare('SELECT token FROM invitation_tokens WHERE token = ?;');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["token"];
    $stmt->bindParam(1, $userInput, PDO::PARAM_STR);
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            return True;
        } else {
            return False;
        }
    } else {
        return False;
    }
} else {
    return False;
}
?>
