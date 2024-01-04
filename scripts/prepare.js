
document.getElementById('generateTokensBtn').addEventListener('click', function() {
    var numberOfTokens = prompt("Enter the number of tokens to generate:");

    if (numberOfTokens !== null && !isNaN(numberOfTokens) && numberOfTokens > 0) {
        fetch('generateTokensEndpoint.php?numberOfTokens=' + numberOfTokens)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(tokens => {
                createTable(tokens, 'Token');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});


function createTable(data, header) {
    console.log('entered createTable()');
    var output_section = document.getElementById('output_section');
    document.getElementById("output_section").innerHTML = "";
    var table = document.createElement('table');
    table.classList.remove(...table.classList);
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
            cell.innerHTML = token + '<button onclick="copyToClipboard(this)" style="margin-left: 10px;">Copy</button>';
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
    } else if (header === 'view_tokens') {
        table.classList.add('token-tbl');
        output_section.appendChild(document.createElement('h2')).textContent = 'Viewing Tokens';
        var headers = ['Binded Email', 'Token']; 
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
            cell2.classList.add('token-box');
            if (data[j]['associated_email'] == null) {
                cell2.innerHTML ='<div>' + data[j]['token'] + '</div>' + '<button onclick="copyToClipboard(this)" style="margin-left: 10px;">Copy</button>';
                cell1.innerHTML = 'None';
            } else {
                cell2.innerHTML ='<div>' + data[j]['token'] + '</div>';
                cell1.innerHTML = data[j]['associated_email'];
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
    fetch('teachers_view_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            createTable(data, 'Teacher');
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

var page_num = 1;
document.getElementById('viewTokens').addEventListener('click', function () {
    console.log(page_num);
    fetch('tokens_view_data.php?page=' + page_num, {
        method : 'GET'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            createTable(data, 'view_tokens');
            page_num += 1;
        })
});