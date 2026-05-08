<!-- Joel Atkinson, April 30, 2026. CSD440 Server-Side Scripting Assignment 8.2
The purpose of this program is to connect to the baseball_01 MySQL database using
MySQLi and drop the joel_mlb_teams table. The DROP TABLE IF EXISTS form is used
so the program can be run safely whether or not the table currently exists. The
result of the operation is reported back to the user in a formatted page.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Drop Table</title>
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
    <h1>Drop Table - Joel's MLB Teams</h1>
</div>
<hr class="divider">

<div class="content">
    <h2>DROP TABLE Result</h2>

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

// SQL statement that drops the joel_mlb_teams table.
// IF EXISTS is used so the script does not error if the table is already gone.
$sql = "DROP TABLE IF EXISTS joel_mlb_teams";

// Run the DROP TABLE statement and report the result
if ($conn->query($sql) === TRUE) {
    echo '<div class="success-box">Table "joel_mlb_teams" dropped successfully '
        . '(or did not exist).</div>';
} else {
    echo '<div class="error-box"><strong>Error dropping table:</strong> '
        . htmlspecialchars($conn->error) . '</div>';
}

// Close the database connection
$conn->close();
?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 8.2 - Drop Table<br>
    <strong>Description:</strong> This program connects to the baseball_01 database using MySQLi
    and runs a DROP TABLE IF EXISTS statement that removes the joel_mlb_teams table from the
    database. Using the IF EXISTS clause allows this script to be run safely regardless of
    whether the table is currently present. The result of the operation is displayed in a
    formatted HTML page.
</p>

</body>
</html>


