<?php
include 'functions.php';
$status = getStatus();
$numTeachers = getTeacherCount();
$numTokens = getTokenCount();
$numTokenUsed = getUsedTokenCount();

$start = getStart();
$end = getEnd();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laura dashboard</title>
        <script>

            </script>
        <link rel="stylesheet" href="styles2.css">
    </head>
    <body>
        <div class="main-nav">
            <?php
            if ($status === "Offline") {
                echo "
                <div class='page-header'>
                    <h1>Laura's Dashbard</h1>
                    <p style='align-self: flex-end;'><b>Status: </b><b style='color:red'>offline</b></p>
                </div>
                <div class='stick-main'>
                    <div class='item'>
                        <div class='from-sys'>
                            <b>Teachers &nbsp</b>
                            <img src='/2d_room_reservation/img/teacher.png' alt='Icon'>
                        </div>
                        <div class='function'>
                            <a class='btn' id='view-teachers'>
                                View
                            </a>
                            
                            <a class='btn' id='viewTokens'>
                                Invite teachers 
                            </a>
                        </div>
                    </div>
                    

                    <div class='item'>
                        <div class='from-sys'>
                            <b>Preferred schedules &nbsp</b>
                            <img src='/2d_room_reservation/img/teacher.png' alt='Icon'>
                        </div>
                        <div class='function'>
                            <a class='btn' id='view-schedules' onclick='callTeacherSchedule()'>
                                View
                            </a>
                        </div>
                    </div>
                    

                    <div class='item'>
                        <div class='from-sys'>
                            <b>Semestral duration &nbsp</b>
                            <img src='/2d_room_reservation/img/calendar.png' alt='token_icon'>
                        </div>
                        <p class='numerical-sys-data'>$start – $end</p>
                        <div class='from-sys'>
                            <a class='btn' id='change_s_time' onclick='processDateRange(0)'>
                                Update start date
                            </a>
                            <a class='btn' id='change_e_time' onclick='processDateRange(1)'>
                                Update end date
                            </a>
                        </div>
                    </div>

                    
                    <div class='item'>
                        <div class='from-sys'>
                            <b>Arrange &nbsp</b>
                            <img src='/2d_room_reservation/img/calendar.png' alt='token_icon'>
                        </div>
                        <div class='function'>
                            <a class='btn' id='view-schedules' onclick='arrangeSchedule()'>
                                Start
                            </a>
                        </div>
                    </div>
                </div>
                ";
                } elseif ($status === 'Online') {
                    echo "
                    <button href=''>View Rooms status</button>
                    <button href=''>View Rooms status</button>
                    ";
                }
            ?>
        </div>
        <div id="output_section" class="output" >
            
        </div>
        <script src="ldsh_script.js"></script>
        <script src="scripts/datesetter.js"></script>
        <script src="scripts/scheduleKit.js"></script>
        <script src='scripts/prepare.js'></script>
        <script src='scripts/arrangerKit.js'></script>
    </body>
</html>