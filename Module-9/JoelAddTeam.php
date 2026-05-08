<!-- Joel Atkinson, May 7, 2026. CSD440 Server-Side Scripting Assignment 9.2
The purpose of this program is to provide an HTML form that adds a new record
to the joel_mlb_teams table in the baseball_01 database. The form collects the
seven non-key fields (team name, city, league, division, founded year, World
Series wins, and mascot), validates them, and inserts the new row using a
MySQLi prepared statement. A success message is displayed when the insert
completes, or a list of validation errors when the input is invalid.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's MLB Add Team</title>
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
        .nav-bar {
            text-align: center;
            margin: 20px 0;
        }
        .nav-bar a {
            color: #663399;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
        }
        .nav-bar a:hover {
            text-decoration: underline;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #666;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .submit-btn {
            margin-top: 25px;
            padding: 10px 30px;
            background-color: #663399;
            color: #DAA520;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #7a42b0;
        }
        .submit-btn.link {
            text-align: center;
            text-decoration: none;
            display: block;
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
            width: 35%;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .error-box {
            background-color: #ffe0e0;
            border: 2px solid #cc0000;
            color: #cc0000;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .error-box ul {
            margin: 10px 0 0 0;
            padding-left: 20px;
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
    <h1>Add a Team to Joel's MLB Database</h1>
</div>
<hr class="divider">

<div class="content">
    <div class="nav-bar">
        <a href="JoelIndex.php">&larr; Back to Index</a>
    </div>

<?php
// Decide whether to process a form submission or simply display the form.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect and trim each submitted field, defaulting to an empty string if
    // the field was not posted at all.
    $teamName  = trim($_POST["team_name"]         ?? "");
    $city      = trim($_POST["city"]              ?? "");
    $league    = trim($_POST["league"]            ?? "");
    $division  = trim($_POST["division"]          ?? "");
    $founded   = trim($_POST["founded_year"]      ?? "");
    $wsWins    = trim($_POST["world_series_wins"] ?? "");
    $mascot    = trim($_POST["mascot"]            ?? "");

    // Collect any validation errors found in the input
    $errors = array();

    if (empty($teamName)) {
        $errors[] = "Team Name is required.";
    } elseif (strlen($teamName) > 75) {
        $errors[] = "Team Name must be 75 characters or fewer.";
    }

    if (empty($city)) {
        $errors[] = "City is required.";
    } elseif (strlen($city) > 50) {
        $errors[] = "City must be 50 characters or fewer.";
    }

    if ($league !== "AL" && $league !== "NL") {
        $errors[] = "League must be AL or NL.";
    }

    if ($division !== "East" && $division !== "Central" && $division !== "West") {
        $errors[] = "Division must be East, Central, or West.";
    }

    if ($founded === "") {
        $errors[] = "Founded Year is required.";
    } elseif (!ctype_digit($founded) || intval($founded) < 1800 || intval($founded) > 2100) {
        $errors[] = "Founded Year must be a whole number between 1800 and 2100.";
    }

    if ($wsWins === "") {
        $errors[] = "World Series Wins is required.";
    } elseif (!ctype_digit($wsWins) || intval($wsWins) < 0 || intval($wsWins) > 50) {
        $errors[] = "World Series Wins must be a whole number between 0 and 50.";
    }

    if (empty($mascot)) {
        $errors[] = "Mascot is required.";
    } elseif (strlen($mascot) > 50) {
        $errors[] = "Mascot must be 50 characters or fewer.";
    }

    // If any validation errors were found, show them and stop.
    if (!empty($errors)) {
        echo '<div class="error-box">';
        echo '<strong>Please fix the following errors:</strong>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<a href="JoelAddTeam.php" class="submit-btn link">Go Back</a>';
    } else {

        // Input passed validation - open a database connection and insert.
        $servername = "localhost";
        $username   = "student1";
        $password   = "pass";
        $database   = "baseball_01";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            echo '<div class="error-box"><strong>Connection failed:</strong> '
                . htmlspecialchars($conn->connect_error) . '</div>';
            echo '<a href="JoelAddTeam.php" class="submit-btn link">Go Back</a>';
        } else {

            // Use a prepared statement so the user's input is bound safely
            // and never concatenated directly into the SQL string.
            $sql  = "INSERT INTO joel_mlb_teams
                        (team_name, city, league, division,
                         founded_year, world_series_wins, mascot)
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                echo '<div class="error-box"><strong>Prepare failed:</strong> '
                    . htmlspecialchars($conn->error) . '</div>';
                echo '<a href="JoelAddTeam.php" class="submit-btn link">Go Back</a>';
            } else {

                $foundedInt = intval($founded);
                $wsWinsInt  = intval($wsWins);

                // Bind types: four strings, two integers, one string.
                $stmt->bind_param(
                    "ssssiis",
                    $teamName,
                    $city,
                    $league,
                    $division,
                    $foundedInt,
                    $wsWinsInt,
                    $mascot
                );

                if ($stmt->execute()) {
                    $newId = $stmt->insert_id;

                    echo '<div class="success-box">New team added successfully! Assigned team_id: '
                        . htmlspecialchars($newId) . '</div>';

                    // Echo the inserted record back so the user can confirm.
                    echo '<h2>Inserted Record</h2>';
                    echo '<table>';
                    echo '<tr><th>Field</th><th>Value</th></tr>';
                    echo '<tr><td>Team ID</td><td>'   . htmlspecialchars($newId)      . '</td></tr>';
                    echo '<tr><td>Team Name</td><td>' . htmlspecialchars($teamName)   . '</td></tr>';
                    echo '<tr><td>City</td><td>'      . htmlspecialchars($city)       . '</td></tr>';
                    echo '<tr><td>League</td><td>'    . htmlspecialchars($league)     . '</td></tr>';
                    echo '<tr><td>Division</td><td>'  . htmlspecialchars($division)   . '</td></tr>';
                    echo '<tr><td>Founded</td><td>'   . htmlspecialchars($foundedInt) . '</td></tr>';
                    echo '<tr><td>WS Wins</td><td>'   . htmlspecialchars($wsWinsInt)  . '</td></tr>';
                    echo '<tr><td>Mascot</td><td>'    . htmlspecialchars($mascot)     . '</td></tr>';
                    echo '</table>';

                    echo '<a href="JoelAddTeam.php" class="submit-btn link">Add Another Team</a>';
                    echo '<div class="nav-bar"><a href="JoelQuery.php">View teams in JoelQuery.php</a></div>';
                } else {
                    echo '<div class="error-box"><strong>Insert failed:</strong> '
                        . htmlspecialchars($stmt->error) . '</div>';
                    echo '<a href="JoelAddTeam.php" class="submit-btn link">Go Back</a>';
                }

                $stmt->close();
            }

            $conn->close();
        }
    }

} else {
    // No POST submission yet - show the empty form.
?>

    <h2>Enter New Team Information</h2>

    <form method="POST" action="JoelAddTeam.php">

        <!-- Field 1: Team Name (text) -->
        <label for="team_name">Team Name:</label>
        <input type="text" id="team_name" name="team_name"
               maxlength="75" placeholder="e.g. Seattle Mariners">

        <!-- Field 2: City (text) -->
        <label for="city">City:</label>
        <input type="text" id="city" name="city"
               maxlength="50" placeholder="e.g. Seattle">

        <!-- Field 3: League (radio) -->
        <label>League:</label>
        <div style="margin-top: 5px;">
            <input type="radio" id="leagueAL" name="league" value="AL">
            <label for="leagueAL" style="display:inline; font-weight:normal;">American League (AL)</label>
            &nbsp;&nbsp;
            <input type="radio" id="leagueNL" name="league" value="NL">
            <label for="leagueNL" style="display:inline; font-weight:normal;">National League (NL)</label>
        </div>

        <!-- Field 4: Division (select dropdown) -->
        <label for="division">Division:</label>
        <select id="division" name="division">
            <option value="">-- Select a Division --</option>
            <option value="East">East</option>
            <option value="Central">Central</option>
            <option value="West">West</option>
        </select>

        <!-- Field 5: Founded Year (number) -->
        <label for="founded_year">Founded Year:</label>
        <input type="number" id="founded_year" name="founded_year"
               min="1800" max="2100" placeholder="e.g. 1977">

        <!-- Field 6: World Series Wins (number) -->
        <label for="world_series_wins">World Series Wins:</label>
        <input type="number" id="world_series_wins" name="world_series_wins"
               min="0" max="50" placeholder="e.g. 0">

        <!-- Field 7: Mascot (text) -->
        <label for="mascot">Mascot:</label>
        <input type="text" id="mascot" name="mascot"
               maxlength="50" placeholder="e.g. Mariner Moose">

        <button type="submit" class="submit-btn">Add Team</button>

    </form>

<?php } ?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 9.2 - Form Page<br>
    <strong>Description:</strong> This program presents an HTML form that adds
    a new record to the joel_mlb_teams table. It collects seven fields using
    text, radio, select, and number input types, validates each field, and
    inserts the row using a MySQLi prepared statement. A formatted summary of
    the inserted record is displayed on success, while validation errors are
    listed when the input is invalid.
</p>

</body>
</html>