<?php
    include 'functions.php';
    include 'connect_db.php';
    if (isset($_POST['password'])) {
        $enteredPassword = $_POST['password'];
        $is_authenticated = authenticateUser($enteredPassword); 
        if ($is_authenticated === True) {
            header("Location: lauraDashboard.php");
            exit();
        }  else {
            header("Location: index.php");
            exit();
        }
    }
?>