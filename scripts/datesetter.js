let currentMonth = 0;
let currentYear = new Date().getFullYear(); // Initialize with the current year
let selectedDateId; // To store the ID of the selected date
let startDateData;

function nextMonth() {
  currentMonth = (currentMonth + 1) % 12;
  if (currentMonth === 0) {
    currentYear++;
  }
  updateCalendar();
}

function prevMonth() {
  currentMonth = (currentMonth - 1 + 12) % 12;
  if (currentMonth === 11) {
    currentYear--;
  }
  updateCalendar();
}
function nextYear() {
    currentYear++;
    updateCalendar();
  }
  
  function prevYear() {
    currentYear--;
    updateCalendar();
  }

function updateCalendar() {
  generateCalendar(currentYear, currentMonth);
}

function generateCalendar(year, month) {
  const datePicker = document.getElementById("datePicker");
  const tbody = datePicker.querySelector("tbody");
  const monthYearHeader = document.getElementById("monthYearHeader");
  tbody.innerHTML = "";
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const daysInMonth = lastDay.getDate();
  monthYearHeader.textContent = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric' }).format(firstDay);
  let date = 1;
  let day = firstDay.getDay();
  for (let i = 0; i < 6; i++) {
    const row = document.createElement("tr");
    for (let j = 0; j < 7; j++) {
      const cell = document.createElement("td");
      if (i === 0 && j < day) {
        cell.textContent = "";
      } else if (date <= daysInMonth) {
        cell.textContent = date;
        cell.id = formatDate(year, month + 1, date);
        cell.addEventListener('click', highlightCell);
        date++;
      }
      row.appendChild(cell);
    }
    tbody.appendChild(row);
  }
  prehighlightCell(startDateData);
}

function formatDate(year, month, day) {
    return `${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}-${year % 100}`;
  }

function prehighlightCell(dateString) {
    console.log(dateString)
    const selectedCell = document.getElementById(dateString);
    if (selectedCell) {
      document.querySelectorAll('td.selected-date').forEach(cell => {
        cell.classList.remove('selected-date');
      });
      selectedCell.classList.add('selected-date');
      selectedDateId = selectedCell.id;
    } 
  }

  function highlightCell(event) {
    const selectedCell = event.target;
    document.querySelectorAll('td.selected-date').forEach(cell => {
      cell.classList.remove('selected-date');
    });
    selectedCell.classList.add('selected-date');
    selectedDateId = selectedCell.id;
  }

function saveDate(type) {
    const isConfirmed = confirm("Are you sure you want to save this date?");
    console.log(selectedDateId);
    if (isConfirmed && selectedDateId) {
      const postData = { dateId: selectedDateId, type: type};
      fetch('update_start_date_data.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(postData, type),
      })
      .then(response => response.json())
      .then(data => {
        console.log(data); 
        location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  }

    function processDateRange(type) {
        var outputHTML;
        var dateString;
        var dateRangeString = document.querySelector('.numerical-sys-data').textContent;
        if (type == 1) {
            outputHTML = htt('Setting end date');
            dateString = dateRangeString.split('–')[1].trim();
        } else if (type == 0) {
            outputHTML = htt('Setting start date');
            dateString = dateRangeString.split('–')[0].trim();
        }
        function htt(header) {
            return `
            <h2 id='header'>${header}</h2>
            <table id='datePicker'>
                <thead>
                    <tr>
                    <th colspan='7' id='monthYearHeader'></th>
                    </tr>
                    <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div>
                <button id="prevMonthBtn" onclick="prevYear()">Previous Year</button>
                <button id="prevMonthBtn" onclick="prevMonth()">Previous Month</button>
                <button id="nextMonthBtn" onclick="nextMonth()">Next Month</button>
                <button id="nextMonthBtn" onclick="nextYear()">Next Year</button>
            </div>
            <div>
                <button id="save-date" onclick="saveDate(${type})">save</button>
            </div>
        `};
        document.getElementById('output_section').innerHTML = outputHTML;
        var startDate = new Date(dateString);
        var processedMonth = startDate.getMonth();
        var processedYear = startDate.getFullYear();
        currentMonth = processedMonth;
        currentYear = processedYear;
        updateCalendar(processedYear, processedMonth);
        startDateData = dateString;
        prehighlightCell(dateString);
        selectedDateId = dateString;
    }