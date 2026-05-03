<!-- Joel Atkinson, April 29, 2026. CSD440 Server-Side Scripting Assignment 8.2
The purpose of this program is to connect to the baseball_01 MySQL database using
MySQLi and run a SELECT query against the joel_mlb_teams table. The result set
is displayed in a formatted HTML table so the contents of the table can be
verified. The rows are sorted by World Series wins from highest to lowest so the
most successful franchises appear first.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Query Table</title>
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
            max-width: 1000px;
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
            padding: 8px 12px;
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
    <h1>Query Table - Joel's MLB Teams</h1>
</div>
<hr class="divider">

<div class="content">
    <h2>SELECT Results</h2>

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

// SELECT query that returns all rows from joel_mlb_teams, ordered by the
// number of World Series wins from highest to lowest so the most successful
// franchises appear first.
$sql    = "SELECT team_id, team_name, city, league, division,
                  founded_year, world_series_wins, mascot
           FROM joel_mlb_teams
           ORDER BY world_series_wins DESC, team_name ASC";
$result = $conn->query($sql);

// Check whether the query ran and returned any rows
if ($result === false) {
    echo '<div class="error-box"><strong>Query failed:</strong> '
        . htmlspecialchars($conn->error) . '</div>';
} elseif ($result->num_rows === 0) {
    echo '<div class="error-box">No rows were returned from joel_mlb_teams. '
        . 'Run JoelPopulateTable.php to load sample data first.</div>';
} else {
    // Show how many rows were returned
    echo '<div class="success-box">'
        . $result->num_rows . ' rows returned from joel_mlb_teams.</div>';

    // Build the result table with one column per field
    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Team</th>';
    echo '<th>City</th>';
    echo '<th>League</th>';
    echo '<th>Division</th>';
    echo '<th>Founded</th>';
    echo '<th>WS Wins</th>';
    echo '<th>Mascot</th>';
    echo '</tr>';

    // Loop through every row and display each value in its own cell
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["team_id"])           . '</td>';
        echo '<td>' . htmlspecialchars($row["team_name"])         . '</td>';
        echo '<td>' . htmlspecialchars($row["city"])              . '</td>';
        echo '<td>' . htmlspecialchars($row["league"])            . '</td>';
        echo '<td>' . htmlspecialchars($row["division"])          . '</td>';
        echo '<td>' . htmlspecialchars($row["founded_year"])      . '</td>';
        echo '<td>' . htmlspecialchars($row["world_series_wins"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["mascot"])            . '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // Free the result set once we are finished reading from it
    $result->free();
}

// Close the database connection
$conn->close();
?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 8.2 - Query Table<br>
    <strong>Description:</strong> This program connects to the baseball_01 database using MySQLi
    and runs a SELECT query against the joel_mlb_teams table. The result set is sorted by
    World Series wins in descending order and rendered as a formatted HTML table so the
    contents of the table can be verified field by field.
</p>

</body>
</html>
