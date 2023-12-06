<?php
    function getStatus() {
        include 'connect_db.php';
        $query = $connect->prepare('SELECT is_ongoing FROM program_status');
        $query->execute();
        $result = $query->fetchColumn();
        if ($result !== false) {
            $status = ($result == 1) ? 'Online' : 'Offline';
            return $status;
        } else {
            return 'err';
        }
    }
    function authenticateUser($enteredPassword) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            include 'connect_db.php';
            echo $enteredPassword;
            $inputpass = $_POST["password"];
            $query = "SELECT password FROM super_admin WHERE name = 'Laura' AND password = '$enteredPassword'";
            $stmt = $connect->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return True;
            } else {
                return False;
            }
        }
    }
    function generateToken($how_many) {
    include 'connect_db.php';
    $query = '';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $current_year = date('Y');
    $school_year_code = $current_year . "-" . ($current_year + 1) . "-";
    $generatedTokens = array();
    for ($j = 0; $j < $how_many; $j++) {
        $randomString = '';
        for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $code = $school_year_code . $randomString;
        $query .= "INSERT INTO invitation_tokens(token) VALUES ('" . $code . "');";
        $generatedTokens[] = $code;
    }
    
    $stmt = $connect->prepare($query);
    $stmt->execute();

    return $generatedTokens;
}

?>
