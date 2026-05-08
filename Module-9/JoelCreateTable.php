<!-- Joel Atkinson, April 28, 2026. CSD440 Server-Side Scripting Assignment 8.2
The purpose of this program is to connect to the baseball_01 MySQL database using
MySQLi and create a new table named joel_mlb_teams. The table is used to store
information about Major League Baseball teams and contains eight fields covering
two different data types (INT and VARCHAR). The result of the CREATE TABLE
statement is reported back to the user in a formatted page along with the
structure of the new table.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Create Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .banner {
            background-color: #663399;
            padding: 20px 40px;
        }
        h1 {
            color: #DAA520;
            margin: 0;
            text-align: center;
        }
        h2 {
            color: #663399;
            text-align: center;
            margin-top: 30px;
        }
        .divider {
            border: none;
            border-top: 3px solid #DAA520;
            margin: 0;
        }
        .content {
            margin: 30px auto;
            max-width: 700px;
            padding: 0 40px;
        }
        .success-box {
            background-color: #e0ffe0;
            border: 2px solid #008800;
            color: #008800;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .error-box {
            background-color: #ffe0e0;
            border: 2px solid #cc0000;
            color: #cc0000;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #666;
            padding: 10px 20px;
            text-align: left;
        }
        th {
            background-color: #663399;
            color: #DAA520;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .info {
            text-align: center;
            color: black;
            margin: 20px 40px 40px;
            line-height: 1.8;
        }
    </style>
</head>
<body>

<div class="banner">
    <h1>Create Table - Joel's MLB Teams</h1>
</div>
<hr class="divider">

<div class="content">
    <h2>CREATE TABLE Result</h2>

<?php
// Database connection variables for the baseball_01 MySQL database
$servername = "localhost";
$username   = "student1";
$password   = "pass";
$database   = "baseball_01";

// Open a new connection to the MySQL server using MySQLi
$conn = new mysqli($servername, $username, $password, $database);

// Check that the connection was opened successfully
if ($conn->connect_error) {
    echo '<div class="error-box"><strong>Connection failed:</strong> '
        . htmlspecialchars($conn->connect_error) . '</div>';
    echo '</div></body></html>';
    exit;
}

// SQL statement that creates the joel_mlb_teams table.
// The table contains eight fields and uses two different data types:
//   INT and VARCHAR.
$sql = "CREATE TABLE joel_mlb_teams (
            team_id           INT AUTO_INCREMENT PRIMARY KEY,
            team_name         VARCHAR(75) NOT NULL,
            city              VARCHAR(50) NOT NULL,
            league            VARCHAR(10) NOT NULL,
            division          VARCHAR(10) NOT NULL,
            founded_year      INT         NOT NULL,
            world_series_wins INT         NOT NULL,
            mascot            VARCHAR(50) NOT NULL
        )";

// Run the CREATE TABLE statement and report the result
if ($conn->query($sql) === TRUE) {
    echo '<div class="success-box">Table "joel_mlb_teams" created successfully.</div>';

    // Display the structure of the new table so the user can verify the fields
    echo '<h2>Table Structure</h2>';
    echo '<table>';
    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>';

    $describe = $conn->query("DESCRIBE joel_mlb_teams");
    while ($row = $describe->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["Field"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["Type"])  . '</td>';
        echo '<td>' . htmlspecialchars($row["Null"])  . '</td>';
        echo '<td>' . htmlspecialchars($row["Key"])   . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    $describe->close();
} else {
    echo '<div class="error-box"><strong>Error creating table:</strong> '
        . htmlspecialchars($conn->error) . '</div>';
}

// Close the database connection
$conn->close();
?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 8.2 - Create Table<br>
    <strong>Description:</strong> This program connects to the baseball_01 database using MySQLi
    and runs a CREATE TABLE statement that builds the joel_mlb_teams table. The table stores
    information about each Major League Baseball team and contains eight fields across two
    data types (INT and VARCHAR). The result of the operation, along with the structure of the
    new table, is displayed in a formatted HTML page.
</p>

</body>
</html>
