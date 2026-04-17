<!-- Joel Atkinson, April 16, 2026. CSD440 Server-Side Scripting Assignment 6.2
The purpose of this program is to demonstrate PHP classes by defining a JoelMyInteger
class that holds a single integer. The class includes methods to check if a number is
even, odd, or prime, as well as getter and setter methods. Two instances are created
and all methods are tested and displayed in a styled HTML table.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's MyInteger Class</title>
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
            margin: 20px 40px;
            display: flex;
            justify-content: center;
        }
        table {
            border-collapse: collapse;
            width: 60%;
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
        .true {
            color: green;
            font-weight: bold;
        }
        .false {
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
    <h1>PHP MyInteger Class</h1>
</div>
<hr class="divider">

<?php
// JoelMyInteger class - holds a single integer and provides methods to test it
class JoelMyInteger {
    // The integer value stored in this object
    private $value;

    // Constructor - sets the integer value when a new object is created
    public function __construct($value) {
        $this->value = $value;
    }

    // Getter - returns the current integer value
    public function getValue() {
        return $this->value;
    }

    // Setter - updates the integer value
    public function setValue($value) {
        $this->value = $value;
    }

    // Checks if the passed in number is even
    public function isEven($num) {
        return $num % 2 === 0;
    }

    // Checks if the passed in number is odd
    public function isOdd($num) {
        return $num % 2 !== 0;
    }

    // Checks if the stored value is a prime number
    public function isPrime() {
        $num = $this->value;

        // Numbers less than 2 are not prime
        if ($num < 2) {
            return false;
        }

        // Check for factors from 2 up to the square root of the number
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i === 0) {
                return false;
            }
        }

        return true;
    }
}

// Helper function - returns "Yes" or "No" with the appropriate CSS class
function formatResult($bool) {
    if ($bool) {
        return "<span class='true'>Yes</span>";
    } else {
        return "<span class='false'>No</span>";
    }
}

// Create two instances of JoelMyInteger
$num1 = new JoelMyInteger(7);
$num2 = new JoelMyInteger(12);
?>

<!-- Testing Instance 1 -->
<h2>Instance 1 - Value: <?php echo $num1->getValue(); ?></h2>
<div class="content">
    <table>
        <tr>
            <th>Test</th>
            <th>Result</th>
        </tr>
        <tr>
            <td>isEven(<?php echo $num1->getValue(); ?>)</td>
            <td><?php echo formatResult($num1->isEven($num1->getValue())); ?></td>
        </tr>
        <tr>
            <td>isOdd(<?php echo $num1->getValue(); ?>)</td>
            <td><?php echo formatResult($num1->isOdd($num1->getValue())); ?></td>
        </tr>
        <tr>
            <td>isPrime()</td>
            <td><?php echo formatResult($num1->isPrime()); ?></td>
        </tr>
    </table>
</div>

<!-- Testing Instance 2 -->
<h2>Instance 2 - Value: <?php echo $num2->getValue(); ?></h2>
<div class="content">
    <table>
        <tr>
            <th>Test</th>
            <th>Result</th>
        </tr>
        <tr>
            <td>isEven(<?php echo $num2->getValue(); ?>)</td>
            <td><?php echo formatResult($num2->isEven($num2->getValue())); ?></td>
        </tr>
        <tr>
            <td>isOdd(<?php echo $num2->getValue(); ?>)</td>
            <td><?php echo formatResult($num2->isOdd($num2->getValue())); ?></td>
        </tr>
        <tr>
            <td>isPrime()</td>
            <td><?php echo formatResult($num2->isPrime()); ?></td>
        </tr>
    </table>
</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 5.3<br>
    <strong>Description:</strong> This program defines a JoelMyInteger class that holds a single integer set through the
    constructor. The class includes isEven() and isOdd() methods that accept an integer parameter, an isPrime() method
    that checks the stored value, and getter and setter methods. Two instances are created and all methods are tested.
</p>

</body>
</html>
