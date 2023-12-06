<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php
            include 'functions.php';
            $status = getStatus();
            if ($status === "Offline") {
                echo "<h1>Laura's Dashboard</h1>";
                echo '<b>Status: ' . $status . '<br>';
                echo '<button href="">View Teachers</button>';
                echo '<button href="">View enrolled Students</button>';
                echo '<button href="">Invite Teachers</button>';
                echo '<button href="">Turn Online</button>';
                echo '<button id="generateTokensBtn"">Generate Invitation tokens</button>';
            } elseif ($status === 'Online') {
                echo '
                <button href="">View Rooms status</button>
                <button href="">View Rooms status</button>
                ';
            }
        ?>
        <section id="output_section">
        </section>
        <script>
            document.getElementById('generateTokensBtn').addEventListener('click', function() {
            var numberOfTokens = prompt("Enter the number of tokens to generate:");

            if (numberOfTokens !== null && !isNaN(numberOfTokens) && numberOfTokens > 0) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'generateTokensEndpoint.php?numberOfTokens=' + numberOfTokens, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Parse the JSON response
                        var tokens = JSON.parse(xhr.responseText);
                        // Create a table and append it to the document body
                        createTable(tokens);
                    }
                };

                xhr.send();
            }
        });

        function createTable(tokens) {
            // Create a table element
            var table = document.createElement('table');
            // Create a header row
            var headerRow = table.insertRow(0);
            // Add column headers
            var headers = ['Token']; // Add your column names
            for (var i = 0; i < headers.length; i++) {
                var th = document.createElement('th');
                th.textContent = headers[i];
                headerRow.appendChild(th);
            }

            // Add data rows
            for (var j = 0; j < tokens.length; j++) {
                var token = tokens[j];
                var row = table.insertRow(j + 1);
                var cell = row.insertCell(0);
                cell.textContent = token;
                // Add additional cells for other data if needed
                // cell = row.insertCell(1);
                // cell.textContent = token.column1;
                // cell = row.insertCell(2);
                // cell.textContent = token.column2;
            }

            // Append the table to the document body
            document.body.appendChild(table);
        }
        </script>
    </body>
</html>