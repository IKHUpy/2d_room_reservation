<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST['highlighted_slots']);
}
?>
<div class="col main_nav">
    <div class="main-nav-child userInfo">
        <h2>User Information </h2>
        <?php
        session_start();
        echo "<div class='userItem'><b>Last Name:&nbsp&nbsp</b><p>{$_SESSION['last_name']}</p></div>";
        echo "<div class='userItem'><b>Email:&nbsp&nbsp</b><p>{$_SESSION['email']}</p></div>";
        echo "<div class='userItem'><b>Username:&nbsp&nbsp</b><p>{$_SESSION['username']}</p></div>";
        echo "<div class='userItem'><b>Type:&nbsp&nbsp</b><p>{$_SESSION['type']}</p></div>";
        ?>
        <a href="">Sign out</a>
    </div>
    <div class="main-nav-child systemInfo">
        <h2>Messages from system</h2>
        <?php
        include "connect_db.php";
        $rtrv_stmt = $connect->prepare("SELECT message, message_type FROM laura_messages WHERE message_type = 'pre-semester';");
        if ($rtrv_stmt->execute()) {
            $data = $rtrv_stmt->fetch(PDO::FETCH_ASSOC);
            echo '<hr style="border: none; border-top: 1px solid #000; width: 70%; margin: 0 auto;">';
            if (isset($data['message'])) {
                echo '<p style="margin: 0; padding: 10px; font-size:1.4rem">'.$data['message'].'</p>';
            } else {
                echo '<p style="text-align: center; margin: 0; padding: 10px; font-size:1.4rem">inbox is empty</p>';
            }
        }
        ?>
    </div>
    <div class="main-nav-child sysSChed">
        <h2>System Schedule</h2>
        <?php
        include 'connect_db.php';

        $pstat_stmt = $connect->prepare("SELECT is_ongoing, start_time, end_time FROM program_status;");

        if ($pstat_stmt->execute()) {
            $data = $pstat_stmt->fetch(PDO::FETCH_ASSOC);
            $startDateTime = new DateTime($data['start_time']);
            $formattedStartTime = $startDateTime->format('F j, Y');
            $endDateTime = new DateTime($data['end_time']);
            $formattedEndTime = $endDateTime->format('F j, Y');
            echo "<div class='userItem'><b>Starting Date:&nbsp;&nbsp;</b><p>{$formattedStartTime}</p></div>";
            echo "<div class='userItem'><b>Ending Date:&nbsp;&nbsp;</b><p>{$formattedEndTime}</p></div>";
        }
        ?>
    </div>
</div>
<div class="col tableTab">
    <h2>Preferred Schedule Table</h2>
    <form class="formtable" id="formtable" action="updatePreferredSchedule.php" method="post">
        <table>
            <tr>
                <th>Day</th>
                <?php
                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $incre = 0;
                foreach ($daysOfWeek as $day) {
                    echo "<th class='dayofweekheader' onclick='selectColumn($incre)'>$day</th>";
                    $incre += 1;
                }
                ?>
            </tr>
    
            <?php
            $asRestrict = [];
            include 'connect_db.php';
            $getData_stmt = $connect->prepare('SELECT day_of_week, start_time, end_time, is_restricted FROM teacher_preferred_schedule WHERE token = ?;');
            $asPrefer = [];
            $token = $_SESSION['token'];
            if ($getData_stmt->execute([$token])) {
                $results = $getData_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) { 
                    $formattedStartTime = date('h:ia', strtotime($row['start_time']));
                    $formattedEndTime = date('h:ia', strtotime($row['end_time']));
                    $toAppend = $row['day_of_week'].' - '.$formattedStartTime.' — '.$formattedEndTime;
                    if (!$row['is_restricted']) {
                        $asPrefer[] = $toAppend;  
                    } elseif ($row['is_restricted']) {
                        $asRestrict[] = $toAppend;  
                    }
                }
            };
            $timeSlots = generateTimeSlots();
            $id = 0;
            $td_id = 0;
            foreach ($timeSlots as $time) {
                echo "<tr>";
                echo "<td id='row$td_id' class='' onclick='selectRow(row$td_id)' style='height: 40px; cursor: pointer;'>$time</td>";
                $td_id += 1;
                foreach ($daysOfWeek as $day) {
                    $inputName = "$day - $time";
                    $isRestrict = in_array($inputName, $asRestrict);
                    $isPrefer = in_array($inputName, $asPrefer);
                    $value = 0;
                    $value = $isPrefer ? 1 : $value;
                    $value = $isRestrict ? 2 : $value;
                    $class = '';
                    if ($value == 2) {
                        $class = 'unprefer-tool';
                    } elseif ($value == 1) {
                        $class = 'prefer-tool';
                    } elseif ($value == 0) {
                        $class = 'neutral-tool';
                    }

                    echo "<td style='' class='$class' onclick='writeToInput($id)' id='cell$id' value=''><input id='$id' type='text' value='$value' name='$inputName' class='' readonly></td>";
                    $id += 1;
                }
                echo "</tr>";
            }
            ?>
        </table>
    
        <br>
    </form>
</div>
<div class="col tools">
    <h2>Tools</h2>
    <div id="tools">
        <button href="#" onclick="selectTool(0)">Neutral tool</button>
        <button href="#" onclick="selectTool(1)">Prefer tool</button>
        <button href="#" onclick="selectTool(2)">Unprefer tool</button>
        <button href="#" onclick="reset()">Reset tool</button>
        <input type="submit" value="Save" onclick="submitForm()">
    </div>

</div>
<script>
    let selectedToolValue = 1; // Default to 0
    function selectTool(tool) {
        selectedToolValue = tool;
    }
    function writeToInput(inputId) {
        document.getElementById(inputId).setAttribute('value', selectedToolValue);
        document.getElementById('cell'+inputId).classList.remove('neutral-tool', 'prefer-tool', 'unprefer-tool');
        switch (selectedToolValue) {
            case 0:
                document.getElementById('cell'+inputId).classList.add('neutral-tool');
                break;
            case 1:
                document.getElementById('cell'+inputId).classList.add('prefer-tool');
                break;
            case 2:
                document.getElementById('cell'+inputId).classList.add('unprefer-tool');
                break;
            default:
                break;
        }
    }
    document.getElementById('tools').addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            selectTool(parseInt(event.target.getAttribute('data-tool')));
        }
    });
    function selectRow(inputId) {
        var tds = document.querySelectorAll('tr td');
        for (var i = 0; i < tds.length; i++) {
            if (tds[i].id === inputId.id) {
                for (var j = 1; j <= 6; j++) {
                    tds[j+i].querySelector('input').setAttribute('value', selectedToolValue);
                    tds[j+i].classList.remove('neutral-tool', 'prefer-tool', 'unprefer-tool');
                    switch (selectedToolValue) {
                        case 0:
                            tds[j+i].classList.add('neutral-tool');
                            break;
                        case 1:
                            tds[j+i].classList.add('prefer-tool');
                            break;
                        case 2:
                            tds[j+i].classList.add('unprefer-tool');
                            break;
                        default:
                            break;
                    }
                }
                break;
            } else {
                tds[i].classList.remove('clicked-cell');
            }
        }
    }
    function reset() {
    var tds = document.querySelectorAll('tr td');
        for (var i = 0; i < tds.length; i++) {
            if (tds[i].id !== undefined && tds[i].id !== null) {
                if (tds[i].id.substring(0, 4) == 'cell') {
                    tds[i].querySelector('input').setAttribute('value', 0);
                    tds[i].classList.remove('neutral-tool', 'prefer-tool', 'unprefer-tool');
                    tds[i].classList.add('neutral-tool');
                }
            }
        }
    };
    function selectColumn(inputId) {
        var tds = document.querySelectorAll('tr td');
        for (var i = inputId; i <= 161; i += 6) {
            var cell =  document.getElementById('cell'+i);
            cell.querySelector('input').setAttribute('value', selectedToolValue);
            cell.classList.remove('neutral-tool', 'prefer-tool', 'unprefer-tool');  
            switch (selectedToolValue) {
                case 0:
                    cell.classList.add('neutral-tool');
                    break;
                case 1:
                    cell.classList.add('prefer-tool');
                    break;
                case 2:
                    cell.classList.add('unprefer-tool');
                    break;
                default:
                    break;
            }
        }
        //for (var i = inputId; i < tds.length / 6; i+=6) {
        //    if (tds[i].id === inputId.id) {
        //        for (var j = 1; j <= 6; j++) {
        //            tds[j+i].querySelector('input').setAttribute('value', selectedToolValue);
        //            tds[j+i].classList.remove('neutral-tool', 'prefer-tool', 'unprefer-tool');
        //            switch (selectedToolValue) {
        //                case 0:
        //                    tds[j+i].classList.add('neutral-tool');
        //                    break;
        //                case 1:
        //                    tds[j+i].classList.add('prefer-tool');
        //                    break;
        //                case 2:
        //                    tds[j+i].classList.add('unprefer-tool');
        //                    break;
        //                default:
        //                    break;
        //            }
        //        }
        //        break;
        //    } else {
        //        tds[i].classList.remove('clicked-cell');
        //    }
        //}
    }
    function submitForm() {
        var form = document.getElementById('formtable');
        if (form) {
            form.submit();
        }
    }
</script>

<?php
function generateTimeSlots() {
    $timeSlots = [];
    $startTime = strtotime('7:30 AM');
    $endTime = strtotime('8:00 PM'); // 30 minutes less at least

    while ($startTime <= $endTime) {
        $nextTime = date('h:ia', $startTime + 30 * 59);
        $timeSlots[] = date('h:ia', $startTime).' — '. $nextTime;
        $startTime += 30 * 60; 
    }

    return $timeSlots;
}
?>
<script>
    
</script>
</body>
</html>
