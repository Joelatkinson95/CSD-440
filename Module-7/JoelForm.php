<!-- Joel Atkinson, April 23, 2026. CSD440 Server-Side Scripting Assignment 7.2
The purpose of this program is to create an HTML form that collects seven fields of
data using at least four different input types. When submitted, the PHP CGI validates
that all fields are populated and correctly entered. If valid, the data is displayed
in a formatted page. If not, an error message is returned indicating the problem.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's PHP Form</title>
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
            max-width: 600px;
            padding: 0 40px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="tel"],
        select,
        textarea {
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
    <h1>PHP User Form</h1>
</div>
<hr class="divider">

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect and trim all form data
    $firstName = trim($_POST["firstName"] ?? "");
    $lastName = trim($_POST["lastName"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $age = trim($_POST["age"] ?? "");
    $state = trim($_POST["state"] ?? "");
    $contact = trim($_POST["contact"] ?? "");

    // Array to hold any validation errors
    $errors = array();

    // Validate each field
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }

    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone)) {
        $errors[] = "Phone Number must be in the format 555-555-5555.";
    }

    if ($age === "") {
        $errors[] = "Age is required.";
    } elseif (!is_numeric($age) || intval($age) < 1 || intval($age) > 120) {
        $errors[] = "Please enter a valid age between 1 and 120.";
    }

    if (empty($state)) {
        $errors[] = "State is required.";
    }

    if (empty($contact)) {
        $errors[] = "Preferred Contact Method is required.";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        echo '<div class="content">';
        echo '<div class="error-box">';
        echo '<strong>Please fix the following errors:</strong>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<a href="JoelForm.php" class="submit-btn" style="text-align:center; text-decoration:none; display:block;">Go Back</a>';
        echo '</div>';
    } else {
        // No errors - display the submitted data in a formatted table
        echo '<div class="content">';
        echo '<div class="success-box">Form submitted successfully!</div>';
        echo '<table>';
        echo '<tr><th>Field</th><th>Value</th></tr>';
        echo '<tr><td>First Name</td><td>' . htmlspecialchars($firstName) . '</td></tr>';
        echo '<tr><td>Last Name</td><td>' . htmlspecialchars($lastName) . '</td></tr>';
        echo '<tr><td>Email</td><td>' . htmlspecialchars($email) . '</td></tr>';
        echo '<tr><td>Phone Number</td><td>' . htmlspecialchars($phone) . '</td></tr>';
        echo '<tr><td>Age</td><td>' . htmlspecialchars($age) . '</td></tr>';
        echo '<tr><td>State</td><td>' . htmlspecialchars($state) . '</td></tr>';
        echo '<tr><td>Preferred Contact</td><td>' . htmlspecialchars($contact) . '</td></tr>';
        echo '</table>';
        echo '<a href="JoelForm.php" class="submit-btn" style="text-align:center; text-decoration:none; display:block;">Submit Another</a>';
        echo '</div>';
    }

} else {
    // Form has not been submitted yet - display the form
?>

<div class="content">
    <h2>Enter Your Information</h2>

    <form method="POST" action="JoelForm.php">

        <!-- Field 1: Text input -->
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter your first name">

        <!-- Field 2: Text input -->
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter your last name">

        <!-- Field 3: Email input -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="example@email.com">

        <!-- Field 4: Tel input -->
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="555-555-5555">

        <!-- Field 5: Number input -->
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="1" max="120" placeholder="Enter your age">

        <!-- Field 6: Select dropdown -->
        <label for="state">State:</label>
        <select id="state" name="state">
            <option value="">-- Select a State --</option>
            <option value="Alabama">Alabama</option>
            <option value="Alaska">Alaska</option>
            <option value="Arizona">Arizona</option>
            <option value="Arkansas">Arkansas</option>
            <option value="California">California</option>
            <option value="Colorado">Colorado</option>
            <option value="Connecticut">Connecticut</option>
            <option value="Delaware">Delaware</option>
            <option value="Florida">Florida</option>
            <option value="Georgia">Georgia</option>
            <option value="Hawaii">Hawaii</option>
            <option value="Idaho">Idaho</option>
            <option value="Illinois">Illinois</option>
            <option value="Indiana">Indiana</option>
            <option value="Iowa">Iowa</option>
            <option value="Kansas">Kansas</option>
            <option value="Kentucky">Kentucky</option>
            <option value="Louisiana">Louisiana</option>
            <option value="Maine">Maine</option>
            <option value="Maryland">Maryland</option>
            <option value="Massachusetts">Massachusetts</option>
            <option value="Michigan">Michigan</option>
            <option value="Minnesota">Minnesota</option>
            <option value="Mississippi">Mississippi</option>
            <option value="Missouri">Missouri</option>
            <option value="Montana">Montana</option>
            <option value="Nebraska">Nebraska</option>
            <option value="Nevada">Nevada</option>
            <option value="New Hampshire">New Hampshire</option>
            <option value="New Jersey">New Jersey</option>
            <option value="New Mexico">New Mexico</option>
            <option value="New York">New York</option>
            <option value="North Carolina">North Carolina</option>
            <option value="North Dakota">North Dakota</option>
            <option value="Ohio">Ohio</option>
            <option value="Oklahoma">Oklahoma</option>
            <option value="Oregon">Oregon</option>
            <option value="Pennsylvania">Pennsylvania</option>
            <option value="Rhode Island">Rhode Island</option>
            <option value="South Carolina">South Carolina</option>
            <option value="South Dakota">South Dakota</option>
            <option value="Tennessee">Tennessee</option>
            <option value="Texas">Texas</option>
            <option value="Utah">Utah</option>
            <option value="Vermont">Vermont</option>
            <option value="Virginia">Virginia</option>
            <option value="Washington">Washington</option>
            <option value="West Virginia">West Virginia</option>
            <option value="Wisconsin">Wisconsin</option>
            <option value="Wyoming">Wyoming</option>
        </select>

        <!-- Field 7: Radio buttons -->
        <label>Preferred Contact Method:</label>
        <div style="margin-top: 5px;">
            <input type="radio" id="contactEmail" name="contact" value="Email">
            <label for="contactEmail" style="display:inline; font-weight:normal;">Email</label>
            &nbsp;&nbsp;
            <input type="radio" id="contactPhone" name="contact" value="Phone">
            <label for="contactPhone" style="display:inline; font-weight:normal;">Phone</label>
            &nbsp;&nbsp;
            <input type="radio" id="contactText" name="contact" value="Text">
            <label for="contactText" style="display:inline; font-weight:normal;">Text</label>
        </div>

        <button type="submit" class="submit-btn">Submit</button>

    </form>
</div>

<?php } ?>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 7.2<br>
    <strong>Description:</strong> This program creates an HTML form with seven fields using five different input types
    (text, email, tel, number, select, and radio). When submitted, the PHP CGI validates that all fields are
    populated and correctly formatted. Valid submissions display the data in a formatted table, while invalid
    submissions return an error display listing the problems found.
</p>

</body>
</html>
