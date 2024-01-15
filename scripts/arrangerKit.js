var roomCounter = 0;
var roomScheduleData;
var teacherSubjectData;
function arrangeSchedule() {
    var outputSection = document.getElementById('output_section');
    var existingParent = document.getElementById('parentContainer');
    var roomSection = document.createElement('div');
    var subjectSection = document.createElement('div');
    subjectSection.id = 'subjectSection';
    roomSection.id = 'roomSection';

    if (!existingParent) {
        var parentDiv = document.createElement('div');
        parentDiv.id = 'parentContainer';
        parentDiv.className = 'parent';
        parentDiv.appendChild(outputSection.cloneNode(true));
        parentDiv.appendChild(subjectSection);
        parentDiv.appendChild(roomSection);
        outputSection.parentNode.replaceChild(parentDiv, outputSection);
    }
    callTeacherSchedule();
};
function roomSection() {
    if (roomScheduleData) {
        var roomSection = document.getElementById('roomSection');
        roomSection.innerHTML = '';
        roomSection.classList.add('output');
        var room_code = roomScheduleData[roomCounter]['room_code'];
        var floor_level = roomScheduleData[roomCounter]['floor_level'];
        var has_projector = roomScheduleData[roomCounter]['has_projector'];
        if (has_projector == 1) {
            has_projector = 'Yes';
        } else if (has_projector == 0) {
            has_projector = 'No';
        }
        var seat_count = roomScheduleData[roomCounter]['seat_count'];
    
        var htmlContent = `
            <h2>Room Schedule</h2>
            <div class='roomData' class='stick-main'>
                <button onclick='decreRoomCount()'>prev</button>
                <p>Room: ${room_code}</p>
                <p>Level: ${floor_level}</p>
                <p>Projector: ${has_projector}</p>
                <p>Seat count: ${seat_count}</p>
                <button onclick='increRoomCount()'>next</button>
            </div>
            <form class="rs-formtable" id="rs-formtable" action="" method="post">
                <table>
                    <tr>
                        <th>Day</th>`;
        var daysOfWeekCUT = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        daysOfWeekCUT.forEach(function (day, index) {
            htmlContent += `<th class='dayofweekheader' onclick='selectColumn(${index})'>${day}</th>`;
        });
        htmlContent += `</tr>`;
        var timeSlots = generateTimeSlots();
        timeSlots.forEach(function (timeSlot) {
            htmlContent += `<tr>
                                <td>${timeSlot}</td>`;
            daysOfWeek.forEach(function (day) {
                htmlContent += `<td value='${day} - ${timeSlot}'></td>`;
            });
            htmlContent += `</tr>`;
        });
        htmlContent += `</table></form>
        <div></div>
        <div id='tbl'></div>`;
        roomSection.innerHTML = htmlContent;
    }
};
function callRoomSchedule() {
    console.log('123');
    if (!roomScheduleData) {
        fetch('get_all_room_schedule_data.php', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            roomScheduleData = (data); 
            console.log(roomScheduleData);
            roomSection();
        })
        .catch(error => {
            console.error('Error:', (error));
        });
    } else {
        roomSection();
    }
}
function callTeacherSubject() {
    console.log('321');
    if (!teacherSubjectData) {
        fetch('get_all_teacher_subject_data.php', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            teacherSubjectData = (data); 
            console.log(teacherSubjectData);
        })
        .catch(error => {
            console.error('Error:', (error));
        });
    } else {
        console.log(teacherSubjectData);
    }
}
function increRoomCount() {
    if (roomScheduleData[roomCounter+1] != undefined){
        roomCounter += 1;
        roomSection();
    };
};
function decreRoomCount() {
    if (roomCounter != 0) {
        roomCounter -= 1;
        roomSection();
    };
};
