
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
                var num_token_block = document.getElementById('num-token');
                //num_token_block.innerText = (parseInt(num_token_block.innerText) + numberOfTokens).toString();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});


function createTable(data, header) {
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
    } else if (header === 'view_tokens' || header === 'get_used_tokens') {
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
        })
});

function dataBlock(json, header) {
    var outputSection2 = document.getElementById('output_section_2');
    document.getElementById("output_section_2").innerHTML = "";
    var new_block = document.createElement('div');
    var line_one = document.createElement('div');
    var header_block = document.createElement('b');
    var data_block = document.createElement('p');
    var more_btn = document.createElement('a');
    var more_btn = document.getElementById('show-used-token');
    if (!more_btn) {
        more_btn = document.createElement('a');
        more_btn.textContent = 'Show';
        more_btn.classList.add('btn');
        more_btn.style.display = 'flex';
        more_btn.id = 'show-used-token';
        
        // Add click event listener only if the element is created
        more_btn.addEventListener('click', function () {
            fetch('get_used_tokens.php', {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                createTable(data, 'get_used_tokens');
                console.log('qwewqeweqw');

            });
        });
    };
    

    console.log(json[0]['count(*)']);
    console.log(header);
    if (header == 'used_token_count_data') {
        header_block.textContent = 'Used Tokens: ';
        data_block.textContent = json[0]['count(*)'];
    }
    
    
    line_one.classList.add('line-blk');
    line_one.appendChild(header_block);
    line_one.appendChild(data_block);

    
    header_block.style.display = 'flex';
    header_block.style.fontSize = '1.2rem';
    header_block.style.alignItems = 'center';
    header_block.style.justifyContent = 'flex-start';


    data_block.style.display = 'flex';
    data_block.style.alignItems = 'center';
    data_block.classList.add('numerical-sys-data');
    data_block.style.justifyContent = 'center';

    new_block.classList.add('post-data-block');
    new_block.appendChild(line_one);
    new_block.appendChild(more_btn);

    outputSection2.appendChild(new_block);
   
}

document.getElementById('more-token-info').addEventListener('click', function () {
fetch('used_token_count_data.php', {
        method : 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        dataBlock(data, 'used_token_count_data');
    })
});

document.getElementById('change_e_time').addEventListener('click', function () {
    var date_block = document.createElement('div');
    var date_input = document.createElement('input');
    date_input.type = 'date';
    
    date_block.classList.add('date-block');
}); 