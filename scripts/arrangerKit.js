function arrangeSchedule() {
    var outputSection = document.getElementById('output_section');
    var existingParent = document.getElementById('parentContainer');

    if (!existingParent) {
        var parentDiv = document.createElement('div');
        parentDiv.id = 'parentContainer';
        parentDiv.className = 'parent';
        parentDiv.appendChild(outputSection.cloneNode(true));
        outputSection.parentNode.replaceChild(parentDiv, outputSection);
    }
    callTeacherSchedule();
}
function callRoomSchedule() {
    
}
