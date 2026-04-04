<!-- Joel Atkinson, April 3, 2026. CSD440 Server-Side Scripting Assignment 2.2
The purpose of this assignment is to generate an HTML table using a PHP nested loop structure.
Each cell in the table displays a PHP-generated random number. PHP tags are used only for logic, not for outputting
table tags directly.
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
                    <td><?php echo rand(1, 100); ?></td>
                <?php endfor; ?>

            </tr>
        <?php endfor; ?>

    </table>
</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 2.2<br>
    <strong>Description:</strong> This program uses a PHP nested loop structure to generate a 5x5 HTML table.
    Each cell is populated with a random number between 1 and 100 produced by PHP's rand() function.
    PHP tags handle only the logic and number output, while all table structure is written in standard HTML.
</p>

</body>
</html>
