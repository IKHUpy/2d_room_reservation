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
        <title>Dashboard</title>
        <link rel="stylesheet" href="styles2.css">
    </head>
    <body>
        <div class="main-nav">
            <?php
            if ($status === "Offline") {
                echo /*html*/"
                <div class='page-header'>
                    <h1>Laura's Dashbard</h1>
                    <p style='align-self: flex-end;'><b>Status: </b><b style='color:red'>offline</b></p>
                </div>

                <div class='item'>
                    <div class='from-sys'>
                        <b>Number of teachers &nbsp</b>
                        <img src='/2d_room_reservation/img/teacher.png' alt='Icon'>
                    </div>
                        <p class='numerical-sys-data'>$numTeachers</p>
                    <a class='btn' id='view-teachers'>
                        View
                    </a>
                </div>
                
                <div class='item'>
                    <div class='from-sys'>
                        <b>Invitation tokens made &nbsp</b>
                        <img src='/2d_room_reservation/img/coin.png' alt='token_icon'>
                    </div>
                    <p class='numerical-sys-data'>$numTokens</p>
                    <div class='function'>
                        <a class='btn' id='generateTokensBtn'>
                            Create
                        </a>
                        <a class='btn' id='viewTokens'>
                            View 
                        </a>
                        <a class='btn' id='more-token-info'>
                            More 
                        </a>
                    </div>
                </div>
                
                <div class='item'>
                    <div class='from-sys'>
                        <b>Scheduled Operation &nbsp</b>
                        <img src='/2d_room_reservation/img/calendar.png' alt='token_icon'>
                    </div>
                    <p class='numerical-sys-data'>$start – $end</p>
                    <div class='from-sys'>
                        <a class='btn' id='change_s_time'>
                            Update start date
                        </a>
                        <a class='btn' id='change_e_time'>
                            Update end date
                        </a>
                    </div>

                </div>
                
                ";
            } elseif ($status === 'Online') {
                echo /*html*/"
                <button href=''>View Rooms status</button>
                <button href=''>View Rooms status</button>
                ";
            }
            ?>
        </div>
        <div id="output_section" class="output" >
        
        </div>
        <div id="output_section_2" class='output-2'>

        </div>
        <script src="ldsh_script.js"></script>
        <script src='scripts/prepare.js'></script>

    </body>
</html>