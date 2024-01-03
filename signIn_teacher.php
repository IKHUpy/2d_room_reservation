<?php
    include 'connect_db.php';
    include 'functions.php';
    session_start();
    $cek_stmt = $connect->prepare('SELECT COUNT(*) FROM teachers WHERE email = ? AND password = ?;');
    $getUserData_stmt = $connect->prepare('SELECT email, username, last_name, token FROM teachers WHERE email = ?');
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $cek_stmt->bindparam(1, $_POST['email']);
        $cek_stmt->bindparam(2, $_POST['password']);
        $getUserData_stmt->bindparam(1, $_POST['email']);
        if ($cek_stmt->execute()) {
            $secondColumnValue = $cek_stmt->fetchColumn(0);
            if ($secondColumnValue >= 1){
                if ($getUserData_stmt->execute()) {
                    $userData = $getUserData_stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['email'] = $userData['email'];
                    $_SESSION['username'] = $userData['username'];
                    $_SESSION['last_name'] = $userData['last_name'];
                    $_SESSION['token'] = $userData['token'];
                    $_SESSION['type'] = $userData['is_fulltime'] ? "Regular" : "Part-time";
                    header("Location: teacherDashboard.php");
                    exit();
                }
            } else {
                header('Location: teacher.php');
                exit();
            }
        } else {
            header('Location: teacher.php');
            exit();
        }
    } else {
        header('Location: teacher.php');
        exit();
    }
?> 