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
    <title>Reschedule process...</title>
    <link rel="stylesheet" href="../styles3.css">
    <script>
        var to_transfer = [];
        var room_counter = 0;
    </script>
</head>
<body>
    <div>
        <header>
            <h1>Rescheduling</h1>
            <h3><a href="./user/setting.php"><?php echo $_SESSION['email']?></a></h3>
        </header>
        <nav class="secondary-nav" id="secondary-nav">
            <div class='nav-nav'>
                <a href="../teacher/index.php">Back to dashboard</a>
                <a href="#">Settings</a>
            </div>
        </nav>
    </div>
    <h3 id='progress-header' style='display:flex;align-self:center;'>choose slots to transfer...</h3>
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
    foreach ($daysOfWeek as $day) {
        if (in_array($day, $days)) {
            $htmlContent .= "<th class='dayofweekheader' onclick=''>$day</th>";
        }
    }
    $generateTimeSlots = generateTimeSlots();   
    $ownedTimeSlots = getTimeSlots($rows2);
    $room_schedules = array();
    foreach ($durations as $duration) {
        $rowData = '';
        $empty = '';
        foreach ($daysOfWeek as $day) {
            $value = "$day - $duration";
            $cell_id = "";
            $td = "<td class='owned' value='$value'>";
            $found = false;
            foreach ($ownedTimeSlots as $ownedTimeSlot) {
                foreach ($daysOfWeek as $dayweek) {
                    $vv = $ownedTimeSlot['cell_value'];
                    $cc = $ownedTimeSlot['cell_code'];
                    $rr = $ownedTimeSlot['cell_room'];
                    $cell_day = $ownedTimeSlot['cell_day'];
                    $roomSubDuration = $ownedTimeSlot['cell_start_end'];
                    $id = $ownedTimeSlot['room_schedule_id'];
                    $year_section = $ownedTimeSlot['year_section'];
                    if ($value == "$cell_day - $roomSubDuration" && $dayweek == $cell_day) {
                        $cell_id = "room-schedule-$id";
                        $room_schedules[] = $cell_id;
                        $td = "<td id='$cell_id' class='owned' value='$value' style='cursor:pointer;'>";
                        $td .= "<div>$rr - $cc - <b>$year_section</b></div>";
                        $found = true;
                        $cell_id = $id;
                    } 
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
    echo /*html*/"<script>
    var parser = new DOMParser();
    var displaySlotsTemplate = '<label>selected 30m slot/s:</label><p>&nbsp&nbsp<b>?</p>';
    function transferReset() {
        var formTable = document.getElementById('rs-formtable');
        var owneds = formTable.querySelectorAll('.owned');
        to_transfer.forEach(function (item) {
            document.getElementById(item).classList.add('owned');
        });
        to_transfer = [];
        var toUpdate = displaySlotsTemplate.replace('?', 0);
        document.getElementById('to-transfer').innerHTML = toUpdate;
    }
    var selected = '';
    var selectedIdToDelete = [];
    var selectedTransferred = [];
    var selectedObjects = [];
    var toTransferObjects = [];
    var taken = [];
    var takenTime = [];

    function selectCell() {
        if (selected && num != 0) {
            var num = parseInt(document.getElementById(selected).querySelector('b').textContent, 10);
            if (num) {
                selectedTransferred.push(selected);
                this.classList.add('selected');
                this.style.color = 'white';
                this.textContent = selected;
                var self = this.id;
                toTransferObjects.forEach(function (toTransferObject) {
                    to_transfer.forEach(function (to_trans) {
                        if (selected == to_trans['code'] && to_trans['id'] == toTransferObject['id'] && !taken.includes(to_trans['id']) && !takenTime.includes(self)) {
                            var toPushObject = {
                                'room_code': document.getElementById('current-room-code').textContent,
                                'dayweek_time': self,
                                'room_sched_id': toTransferObject['id'],
                            }
                            console.log(toPushObject);
                            selectedObjects.push(toPushObject);
                            taken.push(to_trans['id']);
                            takenTime.push(self);
                            console.log(taken);
                        };
                    });
                });
                var selected_div = document.getElementById(selected);
                selected_div.querySelector('b').textContent = num - 1;
                if (((num - 1) == 0)) {
                    selected = '';
                };
            };
        };
    };
    function resetSelectedCells() {

    }
    function submitTransfer() {
        if (to_transfer.length === selectedTransferred.length) {
            var postData = {
                selectedObjects: selectedObjects
            };
            fetch('processTransfer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(postData)
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = '../teacher/index.php';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Place all first');
        }
    }

    function toTransfer(schedule_code) {
        var block = document.getElementById(schedule_code);
        var slotsDiv = document.getElementById('slotsDiv').querySelectorAll('div');
        var code_block = block.querySelector('p');
        var num = parseInt(block.querySelector('b').textContent, 10);
        if (num !== 0) {
            block.style.backgroundColor = '#3da9ef';
            block.querySelector('b').textContent = num;
            slotsDiv.forEach(function (div) {
                if (div.id != schedule_code){
                    div.style.backgroundColor = '#0271b9';
                }
            })
            num += 1;
        }
        selected = schedule_code;
    }
    
    function transferConfirm() {
        var s_slot = document.getElementById('to-transfer');
        if (to_transfer) {
            s_slot.innerHTML = '';
            document.getElementById('rs-formtable').remove();
            fetch(`calltable.php`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                var code_track = [];
                var slotsDiv = document.createElement('div');
                slotsDiv.id = 'slotsDiv';
                Object.assign(slotsDiv.style, {
                    display: 'flex',
                    flexDirection: 'row',
                    justifyContent: 'center',
                    alignSelf: 'center',
                    width: '40%',
                    gap: '20px',
                    color: 'white',
                });
                document.body.appendChild(slotsDiv);
                var slotsDiv = document.getElementById('slotsDiv');
                to_transfer.forEach(function (json) {
                    var box = document.createElement('div');
                    var code = json['code'];
                    var id = json['id'];
                    var toObjTrack = {
                        'id': id,
                        'code': code
                    }
                    toTransferObjects.push(toObjTrack);
                    box.id = code;
                    Object.assign(box.style, {
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'space-between',
                        backgroundColor: '#0271B9',
                        borderRadius: '5px',
                        padding: '0 20px',
                        height: 'auto',
                        cursor: 'pointer',
                    });
                    var subjData = document.createElement('p');
                    var subjNum = document.createElement('b');
                    subjData.textContent = code;
                    Object.assign(subjData.style, {
                        display: 'flex',
                        padding: '0 10px',
                        alignItems: 'center', 
                        justifyContent: 'center',
                    });
                    Object.assign(subjNum.style, {
                        display: 'flex',
                        padding: '0 10px',
                        height: '100%',
                        alignItems: 'center', 
                        justifyContent: 'center',
                        borderLeft: '1px solid black',
                    });
                    box.appendChild(subjData);
                    box.appendChild(subjNum);
                    box.onclick = function() {
                        toTransfer(code);
                    };
                    if (!code_track.includes(code)) {
                        slotsDiv.appendChild(box);
                        code_track.push(code);
                        subjNum.textContent = 1;
                    } else {
                        var new_val = parseInt(document.getElementById(code).querySelector('b').textContent, 10) + 1;
                        document.getElementById(code).querySelector('b').textContent = new_val;
                    }
                });
                document.body.appendChild(slotsDiv);
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                tempDiv.id = 'table-capture';
                document.body.appendChild(tempDiv);
                var tds = document.querySelectorAll('td');
                tds.forEach(function (td) {
                    if (td.id) {
                        td.style.cursor = 'pointer';
                        td.onclick = selectCell;
                    }
                })
                this.onclick = submitTransfer;
            })
            .catch(error => {
            console.error('Error fetching room details:', error);
            });
        }
    }
    function prevRoom() {
        if (room_counter != 0) {
            room_counter -= 1;
        }
        fetch('calltable.php?roomCounter=' + room_counter, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            var tempDiv = document.getElementById('table-capture');
            tempDiv.innerHTML = data;
            tempDiv.id = 'table-capture';
            document.body.appendChild(tempDiv);
            var tds = document.querySelectorAll('td');
            tds.forEach(function (td) {
                if (td.id) {
                    td.style.cursor = 'pointer';
                    td.onclick = selectCell;
                }
            })
        })
        .catch(error => {
        console.error('Error fetching room details:', error);
        });
    }
    function nextRoom() {
        room_counter += 1;
        fetch('calltable.php?roomCounter=' + room_counter, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            var tempDiv = document.getElementById('table-capture');
            tempDiv.innerHTML = data;
            tempDiv.id = 'table-capture';
            document.body.appendChild(tempDiv);
            var tds = document.querySelectorAll('td');
            tds.forEach(function (td) {
                if (td.id) {
                    td.style.cursor = 'pointer';
                    td.onclick = selectCell;
                }
            })
        })
        .catch(error => {
        console.error('Error fetching room details:', error);
        });
    }

    function roomTransferTool() {
        var roomgrid = document.getElementById('room-grid-tools');
        if (!roomgrid) { 
            var div = document.createElement('div');
            div.id = 'room-grid-tools';
            div.classList.add('nav-nav');
            var a_reset = document.createElement('a');
            a_reset.classList.add('btn');
            a_reset.id = 'transfer-reset';
            a_reset.onclick = transferReset;
            var a_proceed = document.createElement('a');
            a_proceed.classList.add('btn');
            a_proceed.id = 'transfer-proceed';
            a_proceed.onclick = transferConfirm;
            var to_transfer_div = document.getElementById('secondary-nav');
            a_reset.text = 'reset';
            a_proceed.text = 'proceed';
            div.appendChild(a_reset);
            div.appendChild(a_proceed);
            to_transfer_div.insertBefore(div, to_transfer_div.firstChild);
            console.log(1);
        } else {
            console.log(0);
        }
    };
    ";
    foreach ($room_schedules as $room_schedule) {
        echo /*html*/"
        document.getElementById('$room_schedule').addEventListener('click', function() {
            var div_to_transfer = document.getElementById('to-transfer');
            var id = '$room_schedule';
            var code = document.getElementById('$room_schedule').textContent;
            if (this.classList.contains('owned')) {
                if (!div_to_transfer) {
                    var to_transfer_div = document.getElementById('secondary-nav');
                    var div = document.createElement('div');
                    div.id = 'to-transfer';
                    div.style.color = 'white';
                    this.classList.remove('owned');
                    to_transfer.push({'id': id, 'code': code});
                    var toUpdate = displaySlotsTemplate.replace('?', to_transfer.length);
                    div.innerHTML = toUpdate;
                    to_transfer_div.insertBefore(div, to_transfer_div.firstChild);
                    roomTransferTool();
                } else {
                    div_to_transfer.innerHTML = '';
                    this.classList.remove('owned');
                    to_transfer.push({'id': id, 'code': code});
                    var toUpdate = displaySlotsTemplate.replace('?', to_transfer.length);
                    div_to_transfer.innerHTML = toUpdate;
                    roomTransferTool();
                }
            }
        });
        ";
    }
    echo "</script>";
}
?>
</div>
</body>
</html>