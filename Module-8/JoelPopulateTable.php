<!-- Joel Atkinson, April 28, 2026. CSD440 Server-Side Scripting Assignment 8.2
The purpose of this program is to connect to the baseball_01 MySQL database using
MySQLi and insert all 30 Major League Baseball teams into the joel_mlb_teams
table. Each insert is performed using a prepared statement to safely bind the
field values. The result of each insert and the total number of rows inserted
are displayed back to the user in a formatted page.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Populate Table</title>
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
            max-width: 800px;
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
            padding: 8px 15px;
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
    <h1>Populate Table - Joel's MLB Teams</h1>
</div>
<hr class="divider">

<div class="content">
    <h2>INSERT Results</h2>

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

// All 30 MLB teams. Each row contains values for the seven non-key fields:
// team_name, city, league, division, founded_year, world_series_wins, mascot.
//
// City rule: the city listed is the city in the team name (for example
// "New York" for the Yankees). For teams named after a state, such as the
// Arizona Diamondbacks, the city listed is the city where the team's stadium
// is located (Phoenix in that example).
$teams = array(
    // American League - East
    array("Baltimore Orioles",    "Baltimore",      "AL", "East",    1901, 3,  "The Oriole Bird"),
    array("Boston Red Sox",       "Boston",         "AL", "East",    1901, 9,  "Wally the Green Monster"),
    array("New York Yankees",     "New York",       "AL", "East",    1901, 27, "None"),
    array("Tampa Bay Rays",       "Tampa",          "AL", "East",    1998, 0,  "Raymond"),
    array("Toronto Blue Jays",    "Toronto",        "AL", "East",    1977, 2,  "Ace"),

    // American League - Central
    array("Chicago White Sox",    "Chicago",        "AL", "Central", 1901, 3,  "Southpaw"),
    array("Cleveland Guardians",  "Cleveland",      "AL", "Central", 1901, 2,  "Slider"),
    array("Detroit Tigers",       "Detroit",        "AL", "Central", 1901, 4,  "Paws"),
    array("Kansas City Royals",   "Kansas City",    "AL", "Central", 1969, 2,  "Sluggerrr"),
    array("Minnesota Twins",      "Minneapolis",    "AL", "Central", 1901, 3,  "T.C. Bear"),

    // American League - West
    array("Houston Astros",       "Houston",        "AL", "West",    1962, 2,  "Orbit"),
    array("Los Angeles Angels",   "Los Angeles",    "AL", "West",    1961, 1,  "Rally Monkey"),
    array("Oakland Athletics",    "Oakland",        "AL", "West",    1901, 9,  "Stomper"),
    array("Seattle Mariners",     "Seattle",        "AL", "West",    1977, 0,  "Mariner Moose"),
    array("Texas Rangers",        "Arlington",      "AL", "West",    1961, 1,  "Rangers Captain"),

    // National League - East
    array("Atlanta Braves",       "Atlanta",        "NL", "East",    1871, 4,  "Blooper"),
    array("Miami Marlins",        "Miami",          "NL", "East",    1993, 2,  "Billy the Marlin"),
    array("New York Mets",        "New York",       "NL", "East",    1962, 2,  "Mr. Met"),
    array("Philadelphia Phillies","Philadelphia",   "NL", "East",    1883, 2,  "Phillie Phanatic"),
    array("Washington Nationals", "Washington",     "NL", "East",    1969, 1,  "Screech"),

    // National League - Central
    array("Chicago Cubs",         "Chicago",        "NL", "Central", 1876, 3,  "Clark"),
    array("Cincinnati Reds",      "Cincinnati",     "NL", "Central", 1882, 5,  "Mr. Red"),
    array("Milwaukee Brewers",    "Milwaukee",      "NL", "Central", 1969, 0,  "Bernie Brewer"),
    array("Pittsburgh Pirates",   "Pittsburgh",     "NL", "Central", 1882, 5,  "Pirate Parrot"),
    array("St. Louis Cardinals",  "St. Louis",      "NL", "Central", 1882, 11, "Fredbird"),

    // National League - West
    array("Arizona Diamondbacks", "Phoenix",        "NL", "West",    1998, 1,  "D. Baxter the Bobcat"),
    array("Colorado Rockies",     "Denver",         "NL", "West",    1993, 0,  "Dinger"),
    array("Los Angeles Dodgers",  "Los Angeles",    "NL", "West",    1883, 8,  "None"),
    array("San Diego Padres",     "San Diego",      "NL", "West",    1969, 0,  "Swinging Friar"),
    array("San Francisco Giants", "San Francisco",  "NL", "West",    1883, 8,  "Lou Seal")
);

// Prepare the INSERT statement once, then bind and execute for each row.
// The type string "ssssiis" maps to: string, string, string, string,
// integer, integer, string.
$sql  = "INSERT INTO joel_mlb_teams
            (team_name, city, league, division, founded_year, world_series_wins, mascot)
         VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo '<div class="error-box"><strong>Prepare failed:</strong> '
        . htmlspecialchars($conn->error) . '</div>';
    echo '</div></body></html>';
    $conn->close();
    exit;
}

// Track how many rows were inserted successfully
$inserted = 0;

echo '<table>';
echo '<tr><th>#</th><th>Team</th><th>Status</th></tr>';

// Loop through the array and insert each team one at a time
for ($i = 0; $i < count($teams); $i++) {
    $row = $teams[$i];

    $stmt->bind_param(
        "ssssiis",
        $row[0], // team_name         - string
        $row[1], // city              - string
        $row[2], // league            - string
        $row[3], // division          - string
        $row[4], // founded_year      - integer
        $row[5], // world_series_wins - integer
        $row[6]  // mascot            - string
    );

    if ($stmt->execute()) {
        $inserted++;
        $status = "Inserted";
    } else {
        $status = "Failed: " . $stmt->error;
    }

    echo '<tr>';
    echo '<td>' . ($i + 1) . '</td>';
    echo '<td>' . htmlspecialchars($row[0]) . '</td>';
    echo '<td>' . htmlspecialchars($status) . '</td>';
    echo '</tr>';
}

echo '</table>';

// Show a summary message indicating how many rows were inserted
echo '<div class="success-box">'
    . $inserted . ' of ' . count($teams)
    . ' rows inserted into joel_mlb_teams.</div>';

// Clean up the prepared statement and close the database connection
$stmt->close();
$conn->close();
?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 8.2 - Populate Table<br>
    <strong>Description:</strong> This program connects to the baseball_01 database using MySQLi
    and inserts all 30 Major League Baseball teams into the joel_mlb_teams table. A prepared
    statement is used so that each value is safely bound to the SQL before execution. The status
    of every insert and a final count of inserted rows are displayed in a formatted HTML page.
</p>

</body>
</html>
