var teacherCounter = 0;
var tpScheduleData;
var daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

function showSchedules() {
    if (tpScheduleData[teacherCounter]) {
        var outputSection = document.getElementById('output_section');
        outputSection.innerHTML = '';
        var username = tpScheduleData[teacherCounter]['username'];
        var is_fulltime = tpScheduleData[teacherCounter]['is_fulltime'];
        var email = tpScheduleData[teacherCounter]['email'];
        var schedule = tpScheduleData[teacherCounter]['schedule'];
    
        var htmlContent = `
            <h2>Teacher Preferred Schedule</h2>
            <div class='userdata'>
                <button onclick='decreCount()'>prev</button>
                <p>${username}</p>
                <p>${is_fulltime}</p>
                <p>${email}</p>
                <button onclick='increCount()'>next</button>
            </div>
            <form class="tps-formtable" id="tps-formtable" action="" method="post">
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
        outputSection.innerHTML = htmlContent;
        schedule.forEach(function (n) {
            var sstart = convertTimeToAMPM(n['start_time']);
            var eend = convertTimeToAMPM(n['end_time']);
            var day = n['day_of_week'];
            var is_unprefer = n['is_restricted'];
            var idValue = day + ' - ' + sstart + ' — ' + eend;
            var element = document.querySelector('[value="' + idValue + '"]');
        
            if (element) {
                if (is_unprefer == 0) {
                    element.classList.add('prefer');
                } else if (is_unprefer == 1) {
                    element.classList.add('restricted');
                }
            }
        });
    } else if (!tpScheduleData) {
        document.getElementById('output_section').innerHTML(`<h2>Teacher Preferred Schedule</h2>
        <p>No saved schedules :<</p>
        `);
    }

}
function callTeacherSchedule() {
    if (!tpScheduleData) {
        fetch('get_all_schedule_data.php', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            tpScheduleData = (data); 
            showSchedules();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        showSchedules();
    }
}
function generateTimeSlots() {
    var timeSlots = [];
    var startTime = new Date('1970-01-01T07:30:00');
    var endTime = new Date('1970-01-01T20:00:00');

    while (startTime <= endTime) {
        var nextTime = new Date(startTime.getTime() + 30 * 59 * 1000);
        timeSlots.push(
            startTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }) +
            ' — ' +
            nextTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })
        );
        startTime = new Date(startTime.getTime() + 30 * 60 * 1000);
    }

    return timeSlots;
}
function convertTimeToAMPM(time) {
    var hours = parseInt(time.substring(0, 2), 10);
    var minutes = time.substring(3, 5);
    var period = hours >= 12 ? 'PM' : 'AM';
    
    if (hours > 12) {
        hours -= 12;
    } else if (hours === 0) {
        hours = 12;
    }

    return hours + ':' + minutes + ' ' + period;
}
function increCount() {
    if (tpScheduleData[teacherCounter+1] != undefined){
        teacherCounter += 1;
        showSchedules();
    };
};
function decreCount() {
    if (teacherCounter != 0) {
        teacherCounter -= 1;
        showSchedules();
    };
};