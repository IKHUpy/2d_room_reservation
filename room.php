<?php
include './functions.php';
session_start(); 
include 'connect_db.php';
$token = $_SESSION['token'];
$email = $_SESSION['email'];
updateData($token, $email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room viewing</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="./styles3.css">
</head>
<body>
    <div>
        <header>
            <h1>Room viewing</h1>
            <h3><a href="./user/setting.php"><?php echo $_SESSION['email']?></a></h3>
        </header>
        <nav style="justify-content:space-between;">
            <div class='nav-nav'>
                <a href="./room/transfer.php">Transfer a Subject</a>
            </div>  
            <div class='nav-nav'>
                <a href="./teacher/index.php">Back to dashboard</a>
                <a href="#">Settings</a>
            </div>
        </nav>
    </div>
    <div class="room-body">
<?php
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    if ($token && $email) { 
        $data = array();
        $rows = $_SESSION['room'];
        $rows3 = $_SESSION['allRoomSchedule'];
        $rows2 = $_SESSION['myRoom'];
        $roomCount = count($rows);

        if ($roomCounter < 0) {
            $roomCounter = 0;
        } elseif ($roomCounter >= $roomCount) {
            $roomCounter = $roomCount - 1;
        }
        $code = $rows[$roomCounter]['code'];
        $floorLevel = $rows[$roomCounter]['floor_level'];
        $hasProjector = $rows[$roomCounter]['has_projector'];
        $seatCount = $rows[$roomCounter]['seat_count'];
        if (($roomCounter - 1) > 0) {
            $prevCounter = $roomCounter - 1;
        } else {
            $prevCounter = 0;
        }
        $htmlContent = '';
        $daysOfWeekCUT = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($daysOfWeekCUT as $index => $day) {
            $htmlContent .= "<th class='dayofweekheader' onclick='selectColumn($index)'>$day</th>";
        }
        $tableTime = '';
        $timeSlots = generateTimeSlots();   
        $ownedTimeSlots = getTimeSlots($rows3);
        // column
        foreach ($timeSlots as $timeSlot) {
            $htmlContent .= "<tr>
                                <td>$timeSlot</td>";
            // row
            foreach ($daysOfWeek as $day) {
                $value = "$day - $timeSlot";
                $owned_td = "<td class='owned' value='$value'>";
                $td = "<td class='' value='$value'>";
                $owned = false;
                foreach ($ownedTimeSlots as $ownedTimeSlot) {
                    $vv = $ownedTimeSlot['cell_value'];
                    $cc = $ownedTimeSlot['cell_code'];
                    $rr = $ownedTimeSlot['cell_room'];
                    $fname = $ownedTimeSlot['first_name'];
                    $lname = $ownedTimeSlot['last_name'];
                    $alias = aliasName($fname, $lname);
                    $cell_day = $ownedTimeSlot['cell_day'];
                    $roomSubDuration = $ownedTimeSlot['cell_start_end'];
                    $year_section = $ownedTimeSlot['year_section'];
                    if ($value == $vv && $rr == $code) {
                        $owned_td .= "$alias - $cc - <b>$year_section</b>";
                        $owned = true;
                    }
                }
                if ($owned == true) { 
                    $owned_td .= "</td>";
                    $htmlContent .= $owned_td;
                } else {
                    $td .= "</td>";
                    $htmlContent .= $td;
                }
            } 
            $tableTime .= "</tr>";
        }

        echo "
        <div style='display: flex;flex-direction: row; justify-content:center;'>
            <button onclick='prevRoom()'>prev</button>
            <div class='row-data'>
                <p>Room code: <b>$code</b></p>
                <p>Floor level: <b>$floorLevel</b></p>
                <p>Has projector: <b>$hasProjector</b></p>
                <p>Seat count: <b>$seatCount</b></p>
            </div>
            <button onclick='nextRoom()'>next</button>
            </div>
                <form class='rs-formtable' id='rs-formtable' action='' method='post'>
                    <table>
                        <tr>
                            <th>Day</th>
                            ".($htmlContent)."
                        </tr>    
                    </table>
                </form>
                
        <script>
            
        function prevRoom() {
            window.location.replace('?roomCounter=" . ($prevCounter) . "');
        }

        function nextRoom() {
            window.location.replace('?roomCounter=" . ($roomCounter + 1) . "');
        }
        </script>
        ";
    } else {
        echo 'aw';
    }
?>
    </div>
</body>
</html>


