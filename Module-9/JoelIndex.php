<!-- Joel Atkinson, May 6, 2026. CSD440 Server-Side Scripting Assignment 9.2
The purpose of this program is to serve as the index page for the Module 9
assignment. It provides a navigation hub with links to all PHP files used in
this assignment, including the four files carried over from Module 8 (create,
populate, query, drop) and the three new files added in Module 9 (this index
page, a search/query page driven by user form input, and a form page that adds
a new record to the joel_mlb_teams table).
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's MLB Index</title>
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
        .intro {
            text-align: center;
            color: #333;
            line-height: 1.6;
            margin: 20px 0;
        }
        .nav-section {
            margin: 30px 0;
        }
        .nav-section h3 {
            color: #663399;
            border-bottom: 2px solid #DAA520;
            padding-bottom: 8px;
        }
        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .nav-list li {
            margin: 10px 0;
        }
        .nav-list a {
            display: block;
            padding: 12px 20px;
            background-color: #663399;
            color: #DAA520;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .nav-list a:hover {
            background-color: #7a42b0;
        }
        .nav-list .description {
            display: block;
            font-weight: normal;
            font-size: 0.9em;
            color: #f2e5ff;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="banner">
    <h1>Joel's MLB Teams Database - Index</h1>
</div>
<hr class="divider">

<div class="content">
    <p class="intro">
        Welcome to the Module 9 index page for the joel_mlb_teams database.
        Use the links below to navigate to each PHP program. The Module 9
        programs are listed first, followed by the supporting Module 8
        programs that build, load, and tear down the table.
    </p>

    <div class="nav-section">
        <h3>Module 9 Programs</h3>
        <ul class="nav-list">
            <li>
                <a href="JoelQuery.php">
                    JoelQuery.php
                    <span class="description">
                        Search the joel_mlb_teams table using a form. Filter by
                        league, division, team name, and minimum World Series wins.
                    </span>
                </a>
            </li>
            <li>
                <a href="JoelAddTeam.php">
                    JoelAddTeam.php
                    <span class="description">
                        Add a new team record to the joel_mlb_teams table using a
                        validated HTML form.
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-section">
        <h3>Module 8 Programs</h3>
        <ul class="nav-list">
            <li>
                <a href="JoelCreateTable.php">
                    JoelCreateTable.php
                    <span class="description">
                        Create the joel_mlb_teams table in the baseball_01 database.
                    </span>
                </a>
            </li>
            <li>
                <a href="JoelPopulateTable.php">
                    JoelPopulateTable.php
                    <span class="description">
                        Populate the joel_mlb_teams table with all 30 MLB teams.
                    </span>
                </a>
            </li>
            <li>
                <a href="JoelQueryTable.php">
                    JoelQueryTable.php
                    <span class="description">
                        Run a baseline SELECT query that returns every team sorted
                        by World Series wins.
                    </span>
                </a>
            </li>
            <li>
                <a href="JoelDropTable.php">
                    JoelDropTable.php
                    <span class="description">
                        Drop the joel_mlb_teams table from the baseball_01 database.
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>

</body>
</html>
