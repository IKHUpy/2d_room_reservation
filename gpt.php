<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <title>Super Admin Dashboard</title>
</head>
<body>

<h1>Super Admin Dashboard</h1>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>admin1</td>
            <td>admin1@example.com</td>
            <td>Super Admin</td>
            <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td>admin2</td>
            <td>admin2@example.com</td>
            <td>Admin</td>
            <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr>
        <tr>
            <td>3</td>
            <td>admin3</td>
            <td>admin3@example.com</td>
            <td>Admin</td>
            <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr>
        <!-- Add more rows as needed -->
    </tbody>
</table>

</body>
</html>
