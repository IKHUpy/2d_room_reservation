<?php
include 'connect_db.php';
include 'functions.php';
session_start();
$query = 'use room;';
$stmt = $connect->prepare('SELECT token FROM invitation_tokens WHERE token = ?;');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $_POST["token"];
    $_SESSION["userInput_token"] = $userInput;
    $stmt->bindParam(1, $userInput, PDO::PARAM_STR);
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            header("Location: bindEmail.php");
            exit();
        } else {
            header("Location: register.php");
            exit();
        }
    } else {
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
?>
