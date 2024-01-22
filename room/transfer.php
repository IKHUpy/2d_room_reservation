<?php 
include '../functions.php';
include '../connect_db.php';

session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule process...</title>
    <link rel="stylesheet" href="../styles3.css">
    <script>
        var to_transfer = [];
    </script>
</head>
<body>
    <div>
        <header>
            <h1>Rescheduling</h1>
            <h3><a href="./user/setting.php"><?php echo $_SESSION['email']?></a></h3>
        </header>
        <nav style="justify-content:space-between;">
            <div class='nav-nav'>
            </div>
            <div class='nav-nav'>
                <a href="../teacher/index.php">Back to dashboard</a>
                <a href="#">Settings</a>
            </div>
        </nav>
    </div>
    <h3 style='display:flex;align-self:center;'>choose slots to transfer...</h3>
    <p id="to-transfer" style='display:flex;align-self:center;'>0</p>
    <div class="room-body">

<?php
$token = $_SESSION['token'];
$email = $_SESSION['email'];
if ($_SESSION['room'] && $_SESSION['myRoom']) {
    $data = array();
    $rows = $_SESSION['room'];
    $rows2 = $_SESSION['myRoom'];
    
    $htmlContent = '';
    $days = array_unique(array_column($rows2, 'day_of_week'));
    $durations = array();
    foreach ($rows2 as $row) {
        $start = convertTime($row['start']);
        $end = convertTime($row['end']);
        $duration = "$start — $end";
        $durations[] = $duration;
    }
    $durations = array_unique($durations);
    $daysOfWeekCUT = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    foreach ($days as $day) {
        $htmlContent .= "<th class='dayofweekheader' onclick=''>$day</th>";
    }
    $generateTimeSlots = generateTimeSlots();   
    $ownedTimeSlots = getTimeSlots($rows2);
    $room_schedules = array();
    foreach ($durations as $duration) {
        $rowData = '';
        $empty = '';
        foreach ($days as $day) {
            $value = "$day - $duration";
            $cell_id = "";
            $td = "<td class='owned' value='$value'>";
            $found = false;
            foreach ($ownedTimeSlots as $ownedTimeSlot) {
                $vv = $ownedTimeSlot['cell_value'];
                $cc = $ownedTimeSlot['cell_code'];
                $rr = $ownedTimeSlot['cell_room'];
                $cell_day = $ownedTimeSlot['cell_day'];
                $roomSubDuration = $ownedTimeSlot['cell_start_end'];
                $id = $ownedTimeSlot['room_schedule_id'];
                if ($value == "$cell_day - $roomSubDuration") {
                    $cell_id = "room-schedule-$id";
                    $room_schedules[] = $cell_id;
                    $td = "<td id='$cell_id' class='owned' value='$value'>";
                    $td .= "<div>$rr - $cc</div>";
                    $found = true;
                    $cell_id = $id;
                }
            }
            $td .= "</td>";
            if ($found == true) {
                $rowData .= $td;
            }
        }
        if ($rowData != '') {
            $htmlContent .= "<tr><td>$duration</td>";
            $htmlContent .= $rowData;
            $htmlContent .= $empty;
            $htmlContent .= "</tr>";
        }
    }
    echo "
            <form class='rs-formtable' id='rs-formtable' action='' method='post'>
                <table>
                    <tr>
                        <th>Day</th>
                        ".($htmlContent)."
                    </tr>    
                </table>
            </form>
    ";
    echo "<script>";
    foreach ($room_schedules as $room_schedule) {
        echo "
        document.getElementById('$room_schedule').addEventListener('click', function() {
            this.classList.remove('owned');
            to_transfer.push('$room_schedule');
            document.getElementById('to-transfer').textContent = to_transfer.length;
        });
        ";
    }
    echo "</script>";
}
?>
</div>
</body>
</html>