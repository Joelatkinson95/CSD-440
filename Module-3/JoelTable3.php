<!-- Joel Atkinson, April 4, 2026. CSD440 Server-Side Scripting Assignment 3.2
The purpose of this program is to build on the Module 2 PHP table. It uses an external PHP file (Mod_3_Functions.php)
containing a function that accepts two random numbers as parameters and returns their sum. That sum is displayed in
each cell of the HTML table, generated using a PHP nested loop structure.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's PHP Random Number Table</title>
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
        .divider {
            border: none;
            border-top: 3px solid #DAA520;
            margin: 0;
        }
        .content {
            margin: 40px;
            display: flex;
            justify-content: center;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #666;
            padding: 10px 20px;
            text-align: center;
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

<?php
// Including the external file containing the getCellValue() function
require_once 'Mod_3_Functions.php';
?>

<div class="banner">
    <h1>PHP Random Number Table</h1>
</div>
<hr class="divider">

<div class="content">
    <table>
        <tr>
            <th>Col 1</th>
            <th>Col 2</th>
            <th>Col 3</th>
            <th>Col 4</th>
            <th>Col 5</th>
        </tr>

        <!-- Outer loop iterates over each row -->
        <?php for ($row = 0; $row < 5; $row++): ?>
            <tr>

                <!-- Inner loop iterates over each column in the current row -->
                <?php for ($col = 0; $col < 5; $col++): ?>
                    <td><?php echo getCellValue(rand(1, 100), rand(1, 100)); ?></td>
                <?php endfor; ?>

            </tr>
        <?php endfor; ?>

    </table>
</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 3.2<br>
    <strong>Description:</strong> This program builds on the Module 2 table by introducing an external PHP function.
    The getCellValue() function, stored in Mod_3_Functions.php, accepts two random numbers as parameters and returns
    their sum. A PHP nested loop populates each cell with the result, while all table structure remains in standard HTML.
</p>

</body>
</html>

