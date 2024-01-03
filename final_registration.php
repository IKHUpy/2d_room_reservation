<?php
include 'connect_db.php';
include 'functions.php';
session_start();
$cekEmail_stmt = $connect->prepare('SELECT email FROM teachers WHERE email = ?;');
$tknCheck_stmt = $connect->prepare("SELECT * FROM teachers WHERE token = ?");
$update_stmt = $connect->prepare("UPDATE invitation_tokens SET associated_email = ? WHERE token = ?;");
$token_stmt = $connect->prepare("INSERT INTO teachers(first_name, last_name, full_name, email, username, token, password) VALUES (?, ?, ?, ?, ?, ?, ?);");
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$fullName = $firstName . ' ' . $lastName;
$email = $_POST["email"];
$username = $_POST["username"];
$userInputToken = $_SESSION["userInput_token"];
$password = $_POST["password"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tknCheck_stmt->bindParam(1, $userInputToken);
    $cekEmail_stmt->bindparam(1, $_POST['email']);
    if ($tknCheck_stmt->execute() and $cekEmail_stmt->execute()) {
        if ($tknCheck_stmt->fetchColumn() !== false and $cekEmail_stmt->fetchColumn() !== false) {
            header("Location: register.php");
            exit();
        } else {
            $token_stmt->bindParam(1, $firstName);
            $token_stmt->bindParam(2, $lastName);
            $token_stmt->bindParam(3, $fullName);
            $token_stmt->bindParam(4, $email);
            $token_stmt->bindParam(5, $username);
            $token_stmt->bindParam(6, $userInputToken);
            $token_stmt->bindParam(7, $password);
            $update_stmt->bindParam(1, $email);
            $update_stmt->bindParam(2, $userInputToken);
            if ($token_stmt->execute() && $update_stmt->execute()) {
                if ($token_stmt->rowCount() > 0) {
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $username;
                    header("Location: teacher.php");
                    exit();
                } else {
                    header("Location: bindEmail.php");
                    echo 'Try again';
                    exit();
                }
            } else {
                header('Location: error.php');
                exit;
            }
        }
    }
    
} else {
    header('Location: pagenotfound.php');
    exit;
}
?>