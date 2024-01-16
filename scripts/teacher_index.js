var tpScheduleData;
var roomScheduleData;
function callTeacherSchedule() {
    if (!tpScheduleData) {
        fetch('../get_all_schedule_data.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            tpScheduleData = (data); 
            console.log(tpScheduleData);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
    }
}
function callRoomSchedule() {
    console.log('123');
    if (!roomScheduleData) {
        fetch('../get_all_room_schedule_data.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            roomScheduleData = (data); 
            console.log(roomScheduleData);
        })
        .catch(error => {
            console.error('Error:', (error));
        });
    } else {
    }
}