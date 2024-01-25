<?php
include '../functions.php';
include '../connect_db.php';

session_start(); 
updateData($_SESSION['token'], $_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="../styles3.css">
    <script>
        function formatTo12Hour(time) {
            var [hours, minutes] = time.split(':').map(Number);
            var period = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} ${period}`;
        }
        function incrementTimeBy30Minutes(time) {
            var [hours, minutes] = time.split(':').map(Number);
            minutes += 30;
            hours += Math.floor(minutes / 60);
            minutes %= 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }
        function incrementTimeBy29Minutes(time) {
            var [hours, minutes] = time.split(':').map(Number);
            minutes += 29;
            hours += Math.floor(minutes / 60);
            minutes %= 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }
        function formatTo24Hour(time) {
            var components = time.split(' ');
            var timePart = components[0];
            var period = components[1];
            var [hours, minutes] = timePart.split(':').map(Number);
            if (period === 'PM' && hours !== 12) {
                hours += 12;
            } else if (period === 'AM' && hours === 12) {
                hours = 0;
            }
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }
        function showBlanks() {
            var tbody = document.querySelector('tbody');
            var timeElements = tbody.getElementsByClassName('time-row');
            var last = timeElements[timeElements.length - 1];
            for (var i = 0; i < timeElements.length; i++) {
                if (timeElements[i + 1]) {
                    var timeCell1 = timeElements[i].querySelector('.time');
                    var timeCell2 = timeElements[i + 1].querySelector('.time');
                    var time1 = formatTo24Hour(timeCell1.textContent);
                    var time2 = formatTo24Hour(timeCell2.textContent);
                    var time1_incre = incrementTimeBy30Minutes(time1);
                    var qwe = incrementTimeBy29Minutes(time1);
                    if (time1_incre !== time2) {
                        var tr = document.createElement('tr');
                        tr.classList.add('time-row');
                        var td = document.createElement('td');
                        td.textContent = formatTo12Hour(time1_incre) + ' — ' + formatTo12Hour(qwe); // Replace this with the content you want to add
                        td.classList.add('time');
                        tr.appendChild(td);
                        timeElements[i + 1].parentNode.insertBefore(tr, timeElements[i].nextSibling);
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div>
        <header>
            <h1>Schedule viewing</h1>
            <h3><a href="./user/setting.php"><?php echo $_SESSION['email']?></a></h3>
        </header>
        <nav style="justify-content:space-between;">
            <div class='nav-nav'>
                <select name="dynamicSelect" id="dynamicSelect" onchange="updateSession()">
                    <?php
                    $options = ['Week - Time', 'Subject - Room'];
                    $options2 = ['Subject - Room', 'Week - Time'];
                    if ($_GET['table_style'] == 'Subject - Room') {
                        foreach ($options2 as $option2) {
                            echo "<option value='$option2'>$option2</option>";
                        }
                        $_SESSION["table_style"] = 'Subject - Room';
                    } else {
                        foreach ($options as $option) {
                            echo "<option value='$option'>$option</option>";
                        }
                        $_SESSION["table_style"] = 'Week - Time';
                    }
                    ?>
                </select>
            </div>
            <div class='nav-nav'>
                <a href="./index.php">Back to dashboard</a>
                <a href="#">Settings</a>
            </div>
        </nav>
    </div>
    <div class="room-body">
<?php
    function compareTimeRanges($range1, $range2) {
        // Extract the first 5 characters (hours and minutes) from each time range
        $time1 = substr($range1, 0, 5);
        $time2 = substr($range2, 0, 5);
    
        // Convert to a format like '0730'
        $formattedTime1 = str_replace(':', '', $time1);
        $formattedTime2 = str_replace(':', '', $time2);
    
        // Compare the formatted times
        return strcmp($formattedTime1, $formattedTime2);
    }
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
    if ($_SESSION['room'] && $_SESSION['myRoom']) {
        $data = array();
        $rows = $_SESSION['room'];
        $rows2 = $_SESSION['myRoom'];
        
        $htmlContent = '';
        if ($_SESSION["table_style"] == 'Week - Time' || $_GET['table_style'] == 'Week - Time') {
            $days = array_unique(array_column($rows2, 'day_of_week'));
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $durations = array();
            foreach ($rows2 as $row) {
                $start = convertTime($row['start']);
                $end = convertTime($row['end']);
                $duration = "$start — $end";
                $durations[] = $duration;
            }
            $durations = array_unique($durations);
            $daysOfWeekCUT = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($daysOfWeek as $day) {
                if (in_array($day, $days)) {
                    $htmlContent .= "<th class='dayofweekheader' onclick=''>$day</th>";
                }
            }
            $generateTimeSlots = generateTimeSlots();   
            $ownedTimeSlots = getTimeSlots($rows2);
            foreach ($durations as $duration) {
                $rowData = '';
                $empty = '';
                foreach ($daysOfWeek as $day) {
                    $value = "$day - $duration";
                    $td = "<td class='owned' value='$value'>";
                    $found = false;
                    foreach ($ownedTimeSlots as $ownedTimeSlot) {
                        $vv = $ownedTimeSlot['cell_value'];
                        $cc = $ownedTimeSlot['cell_code'];
                        $rr = $ownedTimeSlot['cell_room'];
                        $cell_day = $ownedTimeSlot['cell_day'];
                        $year_section = $ownedTimeSlot['year_section'];
                        $roomSubDuration = $ownedTimeSlot['cell_start_end'];
                        if ($value == "$cell_day - $roomSubDuration") {
                            $td .= "<div>$rr - $cc - <b>$year_section</b></div>";
                            $found = true;
                        }
                    }
                    $td .= "</td>";
                    if ($found == true) {
                        $rowData .= $td;
                    }else {
                        $rowData .= "<td> </td>";
                    }
                }
                if ($rowData != '') {
                    $htmlContent .= "<tr class='time-row'><td class='time'>$duration</td>";
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
        } else if ($_SESSION["table_style"] == 'Subject - Room' || $_GET['table_style'] == 'Subject - Room') {
            $subjects = array_unique(array_column($rows2, 'subject_code'));
            $rooms = array_unique(array_column($rows2, 'room_code'));
            
            foreach ($subjects as $subject) {
                $htmlContent .= "<th class='dayofweekheader'>$subject</th>";
            }
            $generateTimeSlots = generateTimeSlots();   
            $roomSchedules = getTimeSlots($rows2);
            foreach ($rooms as $room) {
                $rowData = '';
                foreach ($subjects as $subject) {
                    $value = "$subject - $room";
                    $td = "<td class='owned' value='$value'>";
                    $found = false;
                    foreach ($roomSchedules as $roomSchedule) {
                        $vv = $roomSchedule['cell_value'];
                        $nn = $roomSchedule['cell_start_end'];
                        $jj = $roomSchedule['cell_day'];
                        $cc = $roomSchedule['cell_code'];
                        $rr = $roomSchedule['cell_room'];
                        $year_section = $roomSchedule['year_section'];
                        if ($value == "$cc - $rr") {
                            $td .= "<div>$jj - $nn - <b>$year_section</b></div>";
                            $found = true;
                        } 
                    }
                    $td .= "</td>";
                    if ($found == true) {
                        $rowData .= $td;
                    } else {
                        $rowData .= "<td> </td>";
                    }
                }
                if ($rowData != '') {
                    $htmlContent .= "<tr><td>$room</td>";
                    $htmlContent .= $rowData;
                    $htmlContent .= "</tr>";
                }
            }
            echo /*html*/"
                    <form class='rs-formtable' id='rs-formtable' action='' method='post'>
                        <table>
                            <tr>
                                <th>Subject</th>
                                ".($htmlContent)."
                            </tr>    
                        </table>
                    </form>
            ";
        } else {
            echo 'wtf?';
        }
    }
?>

<script>
    function updateSession() {
        var selectedValue = document.getElementById('dynamicSelect').value;

        window.location.href = '?table_style=' + encodeURIComponent(selectedValue);
    }
</script>
    </div>
</body>
</html>


