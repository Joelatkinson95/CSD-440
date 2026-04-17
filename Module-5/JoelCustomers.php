<!-- Joel Atkinson, April 16, 2026. CSD440 Server-Side Scripting Assignment 5.2
The purpose of this program is to demonstrate PHP classes and the $this keyword
by creating a Customer class. The class stores customer properties such as name,
email, and membership level. Multiple Customer objects are created, stored in an
array, and displayed in a styled HTML table using class methods and $this references.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's Customer Array</title>
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
    <h1>PHP Customer Array</h1>
</div>
<hr class="divider">

<?php
// Customer class - acts as a blueprint for creating customer objects
class Customer {
    // Customer properties
    public $name;
    public $email;
    public $phone;
    public $membership;

    // Constructor - sets up a new Customer object with the passed in values
    public function __construct($name, $email, $phone, $membership) {
        $this->name = $name;           // assigns the passed in name to this object
        $this->email = $email;         // assigns the passed in email to this object
        $this->phone = $phone;         // assigns the passed in phone to this object
        $this->membership = $membership; // assigns the passed in membership to this object
    }

    // Returns a formatted string with all of this customer's details
    public function getDetails() {
        return $this->name . " | " . $this->email . " | " . $this->phone . " | " . $this->membership;
    }

    // Outputs an HTML table row displaying this customer's info
    public function getTableRow() {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($this->name) . "</td>";
        echo "<td>" . htmlspecialchars($this->email) . "</td>";
        echo "<td>" . htmlspecialchars($this->phone) . "</td>";
        echo "<td>" . htmlspecialchars($this->membership) . "</td>";
        echo "<td>" . htmlspecialchars($this->getDetails()) . "</td>";
        echo "</tr>";
    }
}

// Create an array of at least 10 Customer objects using the new keyword
$customers = array(
    new Customer("Joel Atkinson", "joel@example.com", "555-101-2020", "Gold"),
    new Customer("Sarah Johnson", "sarah@example.com", "555-202-3030", "Silver"),
    new Customer("Mike Thompson", "mike@example.com", "555-303-4040", "Platinum"),
    new Customer("Emily Davis", "emily@example.com", "555-404-5050", "Gold"),
    new Customer("Chris Martinez", "chris@example.com", "555-505-6060", "Silver"),
    new Customer("Anna Wilson", "anna@example.com", "555-606-7070", "Platinum"),
    new Customer("David Lee", "david@example.com", "555-707-8080", "Gold"),
    new Customer("Jessica Brown", "jessica@example.com", "555-808-9090", "Silver"),
    new Customer("Ryan Clark", "ryan@example.com", "555-909-1010", "Platinum"),
    new Customer("Megan Taylor", "megan@example.com", "555-111-2222", "Gold")
);
?>

<div class="content">
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Membership</th>
            <th>Full Details</th>
        </tr>

        <!-- Loop through the array of Customer objects and call getTableRow() on each -->
        <?php foreach ($customers as $customer): ?>
            <?php $customer->getTableRow(); ?>
        <?php endforeach; ?>

    </table>
</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 5.2<br>
    <strong>Description:</strong> This program demonstrates PHP classes and the $this keyword by defining a Customer class.
    The class uses a constructor to assign properties to each object using $this, and includes methods that use $this
    to access and display each customer's data. Ten Customer objects are created, stored in an array, and displayed
    in an HTML table by calling each object's getTableRow() method.
</p>

</body>
</html>
