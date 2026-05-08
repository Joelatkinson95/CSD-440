<!-- Joel Atkinson, May 7, 2026. CSD440 Server-Side Scripting Assignment 9.2
The purpose of this program is to query the joel_mlb_teams table based on
user-supplied form input. The user can filter results by league, division,
a partial team name match, and a minimum number of World Series wins. The
program builds a SELECT statement using prepared statements, binds the user
input safely, and displays the matching rows in a formatted HTML table.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's MLB Query</title>
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
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row > div {
            flex: 1;
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
        .info-box {
            background-color: #fff8e0;
            border: 2px solid #DAA520;
            color: #5a4500;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
            text-align: center;
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
    <h1>Query Joel's MLB Teams</h1>
</div>
<hr class="divider">

<div class="content">
    <div class="nav-bar">
        <a href="JoelIndex.php">&larr; Back to Index</a>
    </div>

    <h2>Search the joel_mlb_teams Table</h2>

    <?php
    // Capture the submitted values so the SQL query below can use them.
    // The form itself is rendered empty on every load so the user always
    // sees a blank search form.
    $searchTeam     = isset($_GET["team_name"])    ? trim($_GET["team_name"])    : "";
    $searchLeague   = isset($_GET["league"])       ? trim($_GET["league"])       : "";
    $searchDivision = isset($_GET["division"])     ? trim($_GET["division"])     : "";
    $searchMinWins  = isset($_GET["min_wins"])     ? trim($_GET["min_wins"])     : "";
    ?>

    <form method="GET" action="JoelQuery.php" autocomplete="off">

        <label for="team_name">Team Name Contains:</label>
        <input type="text" id="team_name" name="team_name"
               placeholder="e.g. Sox, Yankees, Cardinals">

        <div class="form-row">
            <div>
                <label for="league">League:</label>
                <select id="league" name="league">
                    <option value="" selected>-- Any League --</option>
                    <option value="AL">American League (AL)</option>
                    <option value="NL">National League (NL)</option>
                </select>
            </div>
            <div>
                <label for="division">Division:</label>
                <select id="division" name="division">
                    <option value="" selected>-- Any Division --</option>
                    <option value="East">East</option>
                    <option value="Central">Central</option>
                    <option value="West">West</option>
                </select>
            </div>
        </div>

        <label for="min_wins">Minimum World Series Wins:</label>
        <input type="number" id="min_wins" name="min_wins" min="0" max="50"
               placeholder="Leave blank for any">

        <button type="submit" class="submit-btn">Search Teams</button>
    </form>

    <?php
    // Only run a query when the user has actually submitted the form. We use
    // the presence of the form's submit method (GET) plus at least one of the
    // search fields being set. Checking $_SERVER["QUERY_STRING"] keeps the
    // results from running on the very first page load.
    if (!empty($_SERVER["QUERY_STRING"])) {

        // Database connection variables for the baseball_01 MySQL database
        $servername = "localhost";
        $username   = "student1";
        $password   = "pass";
        $database   = "baseball_01";

        // Open a new connection to the MySQL server using MySQLi
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            echo '<div class="error-box"><strong>Connection failed:</strong> '
                . htmlspecialchars($conn->connect_error) . '</div>';
        } else {

            // Build the WHERE clause dynamically based on which fields the user
            // filled in. Each filter adds a placeholder to the SQL and a value
            // to the bind list, which keeps the query safe from SQL injection.
            $whereParts = array();
            $bindTypes  = "";
            $bindValues = array();

            if ($searchTeam !== "") {
                $whereParts[] = "team_name LIKE ?";
                $bindTypes   .= "s";
                $bindValues[] = "%" . $searchTeam . "%";
            }

            if ($searchLeague !== "") {
                $whereParts[] = "league = ?";
                $bindTypes   .= "s";
                $bindValues[] = $searchLeague;
            }

            if ($searchDivision !== "") {
                $whereParts[] = "division = ?";
                $bindTypes   .= "s";
                $bindValues[] = $searchDivision;
            }

            if ($searchMinWins !== "" && is_numeric($searchMinWins)) {
                $whereParts[] = "world_series_wins >= ?";
                $bindTypes   .= "i";
                $bindValues[] = intval($searchMinWins);
            }

            // Assemble the final SQL. If no filters were provided, the WHERE
            // clause is omitted and the query returns every row.
            $sql = "SELECT team_id, team_name, city, league, division,
                           founded_year, world_series_wins, mascot
                    FROM joel_mlb_teams";

            if (!empty($whereParts)) {
                $sql .= " WHERE " . implode(" AND ", $whereParts);
            }

            $sql .= " ORDER BY world_series_wins DESC, team_name ASC";

            // Use a prepared statement so the user's input is bound safely.
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                echo '<div class="error-box"><strong>Prepare failed:</strong> '
                    . htmlspecialchars($conn->error) . '</div>';
            } else {

                if (!empty($bindValues)) {
                    $stmt->bind_param($bindTypes, ...$bindValues);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result === false) {
                    echo '<div class="error-box"><strong>Query failed:</strong> '
                        . htmlspecialchars($stmt->error) . '</div>';
                } elseif ($result->num_rows === 0) {
                    echo '<div class="info-box">No teams matched your search criteria. '
                        . 'Try removing a filter or broadening your search.</div>';
                } else {
                    echo '<div class="success-box">'
                        . $result->num_rows . ' team(s) matched your search.</div>';

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
                    $result->free();
                }

                $stmt->close();
            }

            $conn->close();
        }
    }
    ?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 9.2 - Query Page<br>
    <strong>Description:</strong> This program lets the user search the
    joel_mlb_teams table by team name (partial match), league, division, and
    minimum World Series wins. It uses a MySQLi prepared statement so user
    input is bound safely, and displays the matching rows in a formatted HTML
    table sorted by World Series wins.
</p>

</body>
</html>