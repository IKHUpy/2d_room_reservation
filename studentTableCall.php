
<?php
function displayRoomDetails($roomCounter, $filter) {
    include 'functions.php';
    session_start(); 
    include 'connect_db.php';
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
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
        foreach ($timeSlots as $timeSlot) {
            $htmlContent .= "<tr>
                                <td>$timeSlot</td>";
            foreach ($daysOfWeek as $day) {
                $value = "$day - $timeSlot";
                $owned_td = "<td class='owned' value='$value'>";
                $td = "<td id='$value' class='' value='$value'>";
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
                    $sec = $ownedTimeSlot['year_section'];
                    if ($value == $vv && $rr == $code && ($filter == $sec|| $filter == $cc|| $filter == $alias)) {
                        $owned_td .= "<div>$alias - $cc - <b>$sec</b></div>";
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
        <div id='room-tools' style='display: flex;flex-direction: row; justify-content:center;'>
            <button onclick='prevRoom()'>prev</button>
            <div class='row-data'>
                <p>Room code: <b id='current-room-code'>$code</b></p>
                <p>Floor level: <b>$floorLevel</b></p>
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
        ";
    } else {
        echo 'aw';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    displayRoomDetails($roomCounter, $_GET['filter']);
} else {
    echo 'aw';
}
?>