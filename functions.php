<?php
    function getStatus() {
        include 'connect_db.php';
        $query = $connect->prepare('SELECT is_ongoing FROM program_status;');
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
        $school_year_code = $current_year . "-";
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
    function isTokenValid($userInput) {
        include 'connect_db.php';
        $stmt = $connect->prepare('SELECT token FROM invitation_tokens WHERE token = ?;');
        $stmt->bindParam(1, $userInput, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        } else {
            return false;
        }
    }
    function checkEmail($emailInput){
        include 'connect_db.php';
        $cekEmail_stmt = $connect->prepare('SELECT * FROM teachers WHERE email = ?;');
        $cekEmail_stmt->bindParam(1, $emailInput);
        if ($cekEmail_stmt->execute()){
            if ($cekEmail_stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function getTeacherCount() {
        include 'connect_db.php';
        $stmt = $connect->prepare('select count(*) from teachers; ');
        if ($stmt->execute()) {
            $count = $stmt->fetchColumn();
            return $count;
        }
    }
    function getTokenCount() {
        include 'connect_db.php';
        $stmt = $connect->prepare('select count(*) from invitation_tokens; ');
        if ($stmt->execute()) {
            $count = $stmt->fetchColumn();
            return $count;
        }
    }
    function getUsedTokenCount() {
        include 'connect_db.php';
        $stmt = $connect->prepare('select count(*) from invitation_tokens where associated_email is not null;');
        if ($stmt->execute()) {
            $count = $stmt->fetchColumn();
            return $count;
        }
    }
    function getStart() {
        include 'connect_db.php';
        $stmt = $connect->prepare('select start_time from program_status;');
        if ($stmt->execute()) {
            $time = $stmt->fetchColumn();
            $dateOnly = date('m-d-y', strtotime($time));
            return $dateOnly;
        }
    }
    function getEnd() {
        include 'connect_db.php';
        $stmt = $connect->prepare('select end_time from program_status;');
        if ($stmt->execute()) {
            $time = $stmt->fetchColumn();
            $dateOnly = date('m-d-y', strtotime($time));
            return $dateOnly;
        }
    }
    function setStart($new_start) {
        include 'connect_db.php';
        $stmt = $connect->prepare('');
    } 
    function displayTbl() {

    }
    function getTimeSlots($rows2) {
        $return = array();

        foreach ($rows2 as $rowVal) {
            $toConvert = $rowVal['day_of_week']. ' - '.convertTime($rowVal['start']) . ' — ' . convertTime($rowVal['end']);
            $return[] = array(
                'cell_value' => $toConvert,
                'cell_day' => $rowVal['day_of_week'],
                'cell_start_end' => convertTime($rowVal['start']) . ' — ' . convertTime($rowVal['end']),
                'cell_code' => $rowVal['subject_code'],
                'cell_room' => $rowVal['room_code'],
                'first_name' => $rowVal['teacher_first_name'],
                'last_name' => $rowVal['teacher_last_name'],
                'room_schedule_id' => $rowVal['id'],
                'var' => $rowVal['day_of_week'],
            );
        }
        return $return;
    }

    function convertTime($time) {
        $formattedTime = DateTime::createFromFormat('H:i:s', $time)->format('h:i A');
        return $formattedTime;
    }
    function generateTimeSlots() {
        $timeSlots = [];
        $startTime = new DateTime('1970-01-01T07:30:00');
        $endTime = new DateTime('1970-01-01T20:00:00');
    
        while ($startTime <= $endTime) {
            $nextTime = clone $startTime;
            $nextTime->add(new DateInterval('PT' . (30 * 59) . 'S'));
    
            $formattedStartTime = $startTime->format('h:i A');
            $formattedNextTime = $nextTime->format('h:i A');
    
            $timeSlots[] = "$formattedStartTime — $formattedNextTime";
    
            $startTime->add(new DateInterval('PT' . (30 * 60) . 'S'));
        }
        return $timeSlots;
    };
    function aliasName($first_name, $last_name) {
        $mutated_first_name = strtoupper(substr($first_name, 0, 1)) . '.';
        $aliasName = $mutated_first_name . ' ' . $last_name;
        return $aliasName;
    }
?>