<!-- Joel Atkinson, April 7, 2026. CSD440 Server-Side Scripting Assignment 4.2
The purpose of this program is to check whether a given string is a palindrome.
It includes a custom function that tests each string, displays the original and
reversed versions, and indicates whether the string is a palindrome.
Six example strings are tested: three palindromes and three non-palindromes.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Palindrome Checker</title>
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
            width: 80%;
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
        .palindrome {
            color: green;
            font-weight: bold;
        }
        .not-palindrome {
            color: red;
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
    <h1>PHP Palindrome Checker</h1>
</div>
<hr class="divider">

<?php
/**
 * testPalindrome - Tests whether a given string is a palindrome.
 *
 * This function converts the string to lowercase and removes spaces so that
 * the comparison is case insensitive and ignores whitespace. It then reverses
 * the cleaned string and compares it to the original cleaned version.
 * The function outputs a table row displaying the original string, the
 * reversed string, and the result of the palindrome test.
 *
 * @param string $str The string to test for palindrome properties.
 * @return void Outputs an HTML table row directly.
 */
function testPalindrome($str) {
    // Convert to lowercase and remove spaces for an accurate comparison
    $cleaned = str_replace(' ', '', strtolower($str));

    // Reverse the cleaned string
    $reversed = strrev($cleaned);

    // Determine if the string is a palindrome
    $isPalindrome = ($cleaned === $reversed);

    // Build the reversed version of the original string for display purposes
    $displayReversed = strrev($str);

    // Set the result text and CSS class based on the test outcome
    if ($isPalindrome) {
        $result = "Yes - Palindrome";
        $cssClass = "palindrome";
    } else {
        $result = "No - Not a Palindrome";
        $cssClass = "not-palindrome";
    }

    // Output the table row with original string, reversed string, and result
    echo "<tr>";
    echo "<td>" . htmlspecialchars($str) . "</td>";
    echo "<td>" . htmlspecialchars($displayReversed) . "</td>";
    echo "<td class='$cssClass'>$result</td>";
    echo "</tr>";
}

// Define six test strings: three palindromes and three non-palindromes
$testStrings = array(
    "racecar",       // Palindrome
    "madam",         // Palindrome
    "A man a plan a canal Panama",  // Palindrome (ignoring case and white space)
    "hello",         // Not a palindrome
    "programming",   // Not a palindrome
    "Bellevue"         // Not a palindrome
);
?>

<div class="content">
    <table>
        <tr>
            <th>Original String</th>
            <th>Reversed String</th>
            <th>Result</th>
        </tr>

        <!-- Loop through each test string and call the testPalindrome function -->
        <?php foreach ($testStrings as $str): ?>
            <?php testPalindrome($str); ?>
        <?php endforeach; ?>

    </table>
</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 4.2<br>
    <strong>Description:</strong> This program checks whether a string is a palindrome using a custom PHP function called
    testPalindrome. This function removes white space and converts to lowercase before the string is reversed and tested
    to confirm whether the string is a palindrome or not. Six strings are tested (three palindromes and three non-palindromes).
    Each string is displayed alongside its reversed version, and the result of the palindrome test is clearly indicated.
</p>

</body>
</html>
