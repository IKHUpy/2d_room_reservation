<?php
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
function getTimeSlots($rows2) {
    $return = array();

    foreach ($rows2 as $rowVal) {
        $toConvert = $rowVal['day_of_week']. ' - '.convertTime($rowVal['start']) . ' — ' . convertTime($rowVal['end']);
        $return[] = array(
            'cell_value' => $toConvert,
            'cell_code' => $rowVal['subject_code'],
            'cell_room' => $rowVal['room_code']
        );
    }
    return $return;
}

function convertTime($time) {
    $formattedTime = DateTime::createFromFormat('H:i:s', $time)->format('h:i A');
    return $formattedTime;
}
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
            <h3><?php session_start(); echo $_SESSION['email']?></h3>
        </header>
        <nav>
            <a href="#">Settings</a>
        </nav>
    </div>
    <div class="room-body">
<?php
    include 'connect_db.php';
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    $query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room;";
    $query2 = "SELECT start, end, reserver, is_fixed, day_of_week, subject_code, room_code FROM room_schedules WHERE reserver = ?";
    $stmt2 = $connect->prepare($query2);
    $stmt = $connect->query($query);
    if ($stmt && $stmt2->execute([$email])) {
        $data = array();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
        $ownedTimeSlots = getTimeSlots($rows2);
        foreach ($timeSlots as $timeSlot) {
            $htmlContent .= "<tr>
                                <td>$timeSlot</td>";
            foreach ($daysOfWeek as $day) {
                $value = "$day - $timeSlot";
                foreach ($ownedTimeSlots as $ownedTimeSlot) {
                    $vv = $ownedTimeSlot['cell_value'];
                    $cc = $ownedTimeSlot['cell_code'];
                    $rr = $ownedTimeSlot['cell_room'];
                    if ($value == $vv && $rr == $code) {
                        $htmlContent .= "<td class='owned' value='$vv'>$cc</td>";
                    } else {
                        $htmlContent .= "<td class='' value='$value'></td>";
                    }
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
                window.location.href = '?roomCounter=" . ($prevCounter) . "';
            }
    
            function nextRoom() {
                window.location.href = '?roomCounter=" . ($roomCounter + 1) . "';
            }
        </script>
        ";
    }
?>
    </div>
</body>
</html>


