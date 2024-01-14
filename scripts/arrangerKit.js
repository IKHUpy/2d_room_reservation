var roomCounter = 0;
var roomScheduleData;
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
}
function callRoomSchedule() {
    if (!roomScheduleData) {
        fetch('get_all_room_schedule_data.php', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(rsData => {
            roomScheduleData = (rsData); 
            //showSchedules();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        //showSchedules();
    }
}
