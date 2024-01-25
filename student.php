<?php
    session_start();
    include 'functions.php';
    include 'connect_db.php';
    $query = "SELECT code, floor_level, has_projector, seat_count, 'type' FROM room;";
    $query3 = "SELECT id, year_section, start, end, reserver, is_fixed, day_of_week, subject_code, room_code, teacher_first_name, teacher_last_name FROM room_schedules";
    $stmt3 = $connect->query($query3);
    $stmt = $connect->query($query);
    if ($stmt && $stmt3) {
        $_SESSION['room'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['allRoomSchedule'] = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }
    $data = array();
    $rows = $_SESSION['room'];
    $rows3 = $_SESSION['allRoomSchedule'];
    $roomCount = count($rows);
    $slots1 = getTimeSlots($rows3);
    $subjectNames = array();
    $yearSections = array();
    $aliasNames = array();
    foreach ($slots1 as $slots) {
        $subjCode = $slots['cell_code'];
        $firstName = $slots['first_name'];
        $lastName = $slots['last_name'];
        $aliasName = aliasName($firstName, $lastName);
        $yearSection = $slots['year_section'];
        $subjectNames[] = $subjCode;
        $yearSections[] = $yearSection;
        $aliasNames[] = $aliasName;
    }
    array_unshift($subjectNames, '');
    array_unshift($yearSections, '');
    array_unshift($aliasNames, '');
    $subjectNames = array_unique($subjectNames);
    $yearSections = array_unique($yearSections);
    $aliasNames = array_unique($aliasNames);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles3.css">
        <title>Hello, Student</title>
    <script>
        var room_counter = 0;
        var filter = '';
        document.addEventListener('DOMContentLoaded', function () {
            var subjectCodeSelect = document.getElementById('subject-code');
            var teacherNameSelect = document.getElementById('teacher-name');
            var yearSectionSelect = document.getElementById('year-section');
            subjectCodeSelect.addEventListener('change', function () {
                filter = subjectCodeSelect.value;
                teacherNameSelect.selectedIndex = 0;
                yearSectionSelect.selectedIndex = 0;
                fetch('studentTableCall.php?roomCounter=' + room_counter + '&filter=' + filter, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    var tempDiv = document.getElementById('room-body');
                    tempDiv.innerHTML = data;
                    tempDiv.id = 'room-body';
                    document.body.appendChild(tempDiv);
                    var tds = document.querySelectorAll('td');
                    tds.forEach(function (td) {
                        if (td.id) {
                            td.style.cursor = 'pointer';
                        }
                    })
                })
                .catch(error => {
                console.error('Error fetching room details:', error);
                });
            });
            teacherNameSelect.addEventListener('change', function () {
                filter = teacherNameSelect.value;
                subjectCodeSelect.selectedIndex = 0;
                yearSectionSelect.selectedIndex = 0;
                fetch('studentTableCall.php?roomCounter=' + room_counter + '&filter=' + filter, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    var tempDiv = document.getElementById('room-body');
                    tempDiv.innerHTML = data;
                    tempDiv.id = 'room-body';
                    document.body.appendChild(tempDiv);
                    var tds = document.querySelectorAll('td');
                    tds.forEach(function (td) {
                        if (td.id) {
                            td.style.cursor = 'pointer';
                        }
                    })
                })
                .catch(error => {
                console.error('Error fetching room details:', error);
                });
            });
            yearSectionSelect.addEventListener('change', function () {
                filter = yearSectionSelect.value;
                subjectCodeSelect.selectedIndex = 0;
                teacherNameSelect.selectedIndex = 0;
                fetch('studentTableCall.php?roomCounter=' + room_counter + '&filter=' + filter, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    var tempDiv = document.getElementById('room-body');
                    tempDiv.innerHTML = data;
                    tempDiv.id = 'room-body';
                    document.body.appendChild(tempDiv);
                    var tds = document.querySelectorAll('td');
                    tds.forEach(function (td) {
                        if (td.id) {
                            td.style.cursor = 'pointer';
                        }
                    })
                })
                .catch(error => {
                console.error('Error fetching room details:', error);
                });
            });
        });
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
            <h1>Room Schedule viewing</h1>
        </header>
        <nav style="justify-content:space-between;">
            <div class='nav-nav'>
                <select name="subject-code" id="subject-code">
                    <?php
                    foreach ($subjectNames as $subjectName) {
                        echo "<option value='$subjectName'>$subjectName</option>";
                    }
                    ?>
                </select>
                <select name="teacher-name" id="teacher-name">
                    <?php
                    foreach ($aliasNames as $aliasName) {
                        echo "<option value='$aliasName'>$aliasName</option>";
                    }
                    ?>
                </select>
                <select name="year-section" id="year-section">
                    <?php
                    foreach ($yearSections as $yearSection) {
                        echo "<option value='$yearSection'>$yearSection</option>";
                    }
                    ?>
                </select>
            </div>
            <div class='nav-nav'>
                <a href="index.php">back to selecting privileges</a>
            </div>
        </nav>
    </div>
    <div id='room-body' class="room-body">
<?php
    $roomCounter = isset($_GET['roomCounter']) ? intval($_GET['roomCounter']) : 0;
    if (True) { 
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
    <script>
    function prevRoom() {
        if (room_counter != 0) {
            room_counter -= 1;
        }
        fetch('studentTableCall.php?roomCounter=' + room_counter + '&filter=' + filter, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            var tempDiv = document.getElementById('room-body');
            tempDiv.innerHTML = data;
            tempDiv.id = 'room-body';
            document.body.appendChild(tempDiv);
            var tds = document.querySelectorAll('td');
            tds.forEach(function (td) {
                if (td.id) {
                    td.style.cursor = 'pointer';
                }
            })
        })
        .catch(error => {
        console.error('Error fetching room details:', error);
        });
    }
    function nextRoom() {
        room_counter += 1;
        fetch('studentTableCall.php?roomCounter=' + room_counter + '&filter=' + filter, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            var tempDiv = document.getElementById('room-body');
            tempDiv.innerHTML = data;
            tempDiv.id = 'room-body';
            document.body.appendChild(tempDiv);
            var tds = document.querySelectorAll('td');
            tds.forEach(function (td) {
                if (td.id) {
                    td.style.cursor = 'pointer';
                }
            })
        })
        .catch(error => {
        console.error('Error fetching room details:', error);
        });
    }
    </script>
</body>
</html>