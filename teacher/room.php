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
    <title>Schedule</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="../styles3.css">
</head>
<body>
    <div>
        <header>
            <h1>Schedule viewing</h1>
            <h3><?php echo $_SESSION['email']?></h3>
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
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
    if ($_SESSION['room'] && $_SESSION['myRoom']) {
        $data = array();
        $rows = $_SESSION['room'];
        $rows2 = $_SESSION['myRoom'];
        
        $htmlContent = '';
        if ($_SESSION["table_style"] == 'Week - Time' || $_GET['table_style'] == 'Week - Time') {
            $daysOfWeekCUT = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            foreach ($daysOfWeekCUT as $index => $day) {
                $htmlContent .= "<th class='dayofweekheader' onclick=''>$day</th>";
            }
            $rooms = generateTimeSlots();   
            $ownedTimeSlots = getTimeSlots($rows2);
            foreach ($rooms as $room) {
                $rowData = '';
                $empty = '';
                foreach ($daysOfWeek as $day) {
                    $value = "$day - $room";
                    foreach ($ownedTimeSlots as $ownedTimeSlot) {
                        $vv = $ownedTimeSlot['cell_value'];
                        $cc = $ownedTimeSlot['cell_code'];
                        $rr = $ownedTimeSlot['cell_room'];
                        if ($value == $vv) {
                            $rowData .= "<td class='owned' value='$vv'>$rr - $cc</td>";
                        } else {
                            $empty .= "<td class='' value='$vv'></td>";
                        }
                    }
                }
                if ($rowData != '') {
                    $htmlContent .= "<tr><td>$room</td>";
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
            $subjects = array();
            $rooms = array();
            foreach ($rows2 as $rowVal) {
                $subjects[] = $rowVal['subject_code'];
                $rooms[] = $rowVal['room_code'];
            }
            
            foreach ($subjects as $subject) {
                $htmlContent .= "<th class='dayofweekheader'>$subject</th>";
            }
            $generateTimeSlots = generateTimeSlots();   
            $ownedTimeSlots = getTimeSlots($rows2);
            foreach ($rooms as $room) {
                $rowData = '';
                $empty = '';
                foreach ($subjects as $subject) {
                    $value = "$subject - $room";

                    foreach ($ownedTimeSlots as $ownedTimeSlot) {
                        $vv = $ownedTimeSlot['cell_value'];
                        $nn = $ownedTimeSlot['cell_start_end'];
                        $jj = $ownedTimeSlot['cell_day'];
                        $cc = $ownedTimeSlot['cell_code'];
                        $rr = $ownedTimeSlot['cell_room'];
                        if ($value == "$cc - $rr") {
                            $rowData .= "<td class='owned' value='$value'>$jj - $nn</td>";
                        }
                    }
                }
                if ($rowData != '') {
                    $htmlContent .= "<tr><td>$room</td>";
                    $htmlContent .= $rowData;
                    $htmlContent .= $empty;
                    $htmlContent .= "</tr>";
                }
            }
            echo "
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


