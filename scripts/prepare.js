
document.getElementById('generateTokensBtn').addEventListener('click', function() {
    var numberOfTokens = prompt("Enter the number of tokens to generate:");
    if (numberOfTokens !== null && !isNaN(numberOfTokens) && numberOfTokens > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'generateTokensEndpoint.php?numberOfTokens=' + numberOfTokens, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var tokens = JSON.parse(xhr.responseText);
                createTable(tokens, 'Token');
            }
        };
        xhr.send();
    }
});

function createTable(data, header) {
    var output_section = document.getElementById('output_section');
    document.getElementById("output_section").innerHTML = "";
    var table = document.createElement('table');
    var headerRow = table.insertRow(0);
    if (header === 'Token') {
        output_section.appendChild(document.createElement('h2')).textContent = 'New tokens';
        var headers = [header]; 
        for (var i = 0; i < headers.length; i++) {
            var th = document.createElement('th');
            th.textContent = headers[i];
            headerRow.appendChild(th);
        }
        for (var j = 0; j < data.length; j++) {
            var token = data[j];
            var row = table.insertRow(j + 1);
            var cell = row.insertCell(0);
            cell.innerHTML = token + '&nbsp&nbsp&nbsp<button onclick="copyToClipboard(this)">Copy</button>';
        }
    } else if (header === 'Teacher') {
        output_section.appendChild(document.createElement('h2')).textContent = 'Teacher';
        var headers = ['Full Name', 'Email', 'Is full-time']; 
        for (var i = 0; i < headers.length; i++) {
            var th = document.createElement('th');
            th.textContent = headers[i];
            headerRow.appendChild(th);
        }
        for (var j = 0; j < data.length; j++) {
            var token = data[j];
            var row = table.insertRow(j + 1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = data[j]['full_name'];
            cell2.innerHTML = data[j]['email'];
            if (data[j]['is_fulltime'] == 0) {
                cell3.innerHTML = 'No';
            } else {
                cell3.innerHTML = 'Yes';
            }
        }
    }
    output_section.appendChild(table);
}
function copyToClipboard(button) {
const textToCopy = button.parentNode.textContent.trim().slice(0, -4);
const textarea = document.createElement('textarea');
textarea.value = textToCopy;
document.body.appendChild(textarea);
textarea.select();
document.execCommand('copy');
document.body.removeChild(textarea);
alert('Text copied to clipboard: ' + textToCopy);
}



document.getElementById('view-teachers').addEventListener('click', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'teachers_data.php');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            createTable(data, 'Teacher');
        }
    };
    xhr.send();
});