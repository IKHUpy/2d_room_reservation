<?php
include './functions.php';
session_start(); 
include 'connect_db.php';
$token = $_SESSION['token'];
$email = $_SESSION['email'];
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
            <h3><?php echo $_SESSION['email']?></h3>
        </header>
        <nav>
            <a href="./teacher/index.php">Back to dashboard</a>
            <a href="#">Settings</a>
        </nav>
    </div>
    <div class="room-body">
<?php
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    if ($token && $email) { 
        $data = array();
        $rows = $_SESSION['room'];
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
        $ownedTimeSlots = getTimeSlots($rows2);
        foreach ($timeSlots as $timeSlot) {
            $htmlContent .= "<tr>
                                <td>$timeSlot</td>";
            
            foreach ($daysOfWeek as $day) {
                $value = "$day - $timeSlot";
                if ($ownedTimeSlots) {
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
                } else {
                    $htmlContent .= "<td class='' value='$value'></td>";
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


