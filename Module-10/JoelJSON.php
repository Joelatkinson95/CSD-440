<!-- Joel Atkinson, May 14, 2026. CSD440 Server-Side Scripting Assignment 10.2
The purpose of this program is to provide an HTML form that collects nine
different fields of fan-profile data from the user. When the form is
submitted, the PHP CGI validates each field. If every field passes
validation, the data is encoded into JSON using json_encode and shown
inside a well-formatted output display. If any field fails validation, a
clearly formatted error display lists the problems instead.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel's JSON Form</title>
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
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
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
        textarea {
            resize: vertical;
            min-height: 80px;
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
        .json-box {
            background-color: #f4f0fa;
            border: 2px solid #663399;
            border-radius: 4px;
            padding: 15px 20px;
            margin: 20px 0;
            color: #222;
            font-family: "Courier New", Courier, monospace;
            font-size: 14px;
            white-space: pre-wrap;
            word-break: break-word;
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
    <h1>Joel's JSON Form</h1>
</div>
<hr class="divider">

<div class="content">

<?php
// Decide whether to process a submission or display an empty form.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Pull each field from the POST array, trimming whitespace and
    // defaulting to an empty string when a field was not submitted.
    $firstName  = trim($_POST["first_name"]    ?? "");
    $lastName   = trim($_POST["last_name"]     ?? "");
    $email      = trim($_POST["email"]         ?? "");
    $phone      = trim($_POST["phone"]         ?? "");
    $dob        = trim($_POST["dob"]           ?? "");
    $sport      = trim($_POST["sport"]         ?? "");
    $team       = trim($_POST["team"]          ?? "");
    $newsletter = trim($_POST["newsletter"]    ?? "");
    $comments   = trim($_POST["comments"]      ?? "");

    // Collect any validation errors into a single list.
    $errors = array();

    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    } elseif (strlen($firstName) > 50) {
        $errors[] = "First Name must be 50 characters or fewer.";
    }

    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    } elseif (strlen($lastName) > 50) {
        $errors[] = "Last Name must be 50 characters or fewer.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    if (empty($phone)) {
        $errors[] = "Phone is required.";
    } elseif (!preg_match('/^[0-9 ()+\-]{7,20}$/', $phone)) {
        $errors[] = "Phone must be 7-20 characters of digits, spaces, +, -, or ().";
    }

    if (empty($dob)) {
        $errors[] = "Date of Birth is required.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        $errors[] = "Date of Birth must be in YYYY-MM-DD format.";
    }

    $validSports = array("Baseball", "Basketball", "Football", "Hockey", "Soccer");
    if (!in_array($sport, $validSports, true)) {
        $errors[] = "Favorite Sport must be selected from the list.";
    }

    if (empty($team)) {
        $errors[] = "Favorite Team is required.";
    } elseif (strlen($team) > 75) {
        $errors[] = "Favorite Team must be 75 characters or fewer.";
    }

    if ($newsletter !== "Yes" && $newsletter !== "No") {
        $errors[] = "Newsletter choice must be Yes or No.";
    }

    if (empty($comments)) {
        $errors[] = "Comments are required.";
    } elseif (strlen($comments) > 500) {
        $errors[] = "Comments must be 500 characters or fewer.";
    }

    // If anything failed validation, show the error display and stop.
    if (!empty($errors)) {
        echo '<div class="error-box">';
        echo '<strong>Your submission could not be encoded as JSON because of the following problems:</strong>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<a href="JoelJSON.php" class="submit-btn link">Go Back</a>';
    } else {

        // Build an associative array of the validated values.
        $formData = array(
            "first_name"          => $firstName,
            "last_name"           => $lastName,
            "email"               => $email,
            "phone"               => $phone,
            "date_of_birth"       => $dob,
            "favorite_sport"      => $sport,
            "favorite_team"       => $team,
            "newsletter_signup"   => $newsletter,
            "comments"            => $comments
        );

        // Encode the array into JSON. JSON_PRETTY_PRINT gives readable
        // indentation, and JSON_UNESCAPED_SLASHES keeps the output clean.
        $jsonOutput = json_encode($formData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        // json_encode returns false if it cannot encode the data - check
        // explicitly and show an error display if that happens.
        if ($jsonOutput === false) {
            echo '<div class="error-box">';
            echo '<strong>JSON encoding failed:</strong> '
                . htmlspecialchars(json_last_error_msg());
            echo '</div>';
            echo '<a href="JoelJSON.php" class="submit-btn link">Go Back</a>';
        } else {
            echo '<div class="success-box">Form data was successfully encoded as JSON.</div>';
            echo '<h2>JSON Output</h2>';
            echo '<div class="json-box">' . htmlspecialchars($jsonOutput) . '</div>';
            echo '<a href="JoelJSON.php" class="submit-btn link">Submit Another</a>';
        }
    }

} else {
    // No POST submission yet - show the empty form.
?>

    <h2>Enter Your Fan Profile</h2>

    <form method="POST" action="JoelJSON.php">

        <!-- Field 1: First Name (text) -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name"
               maxlength="50" placeholder="First Name">

        <!-- Field 2: Last Name (text) -->
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name"
               maxlength="50" placeholder="Last Name">

        <!-- Field 3: Email (email) -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               maxlength="100" placeholder="Enter Your Email">

        <!-- Field 4: Phone (tel) -->
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone"
               maxlength="20" placeholder="e.g. (555) 123-4567">

        <!-- Field 5: Date of Birth (date) -->
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob">

        <!-- Field 6: Favorite Sport (select dropdown) -->
        <label for="sport">Favorite Sport:</label>
        <select id="sport" name="sport">
            <option value="">-- Select a Sport --</option>
            <option value="Baseball">Baseball</option>
            <option value="Basketball">Basketball</option>
            <option value="Football">Football</option>
            <option value="Hockey">Hockey</option>
            <option value="Soccer">Soccer</option>
        </select>

        <!-- Field 7: Favorite Team (text) -->
        <label for="team">Favorite Team:</label>
        <input type="text" id="team" name="team"
               maxlength="75" placeholder="e.g. Arizona Cardinals">

        <!-- Field 8: Newsletter Signup (radio) -->
        <label>Sign Up for Newsletter?</label>
        <div style="margin-top: 5px;">
            <input type="radio" id="newsYes" name="newsletter" value="Yes">
            <label for="newsYes" style="display:inline; font-weight:normal;">Yes</label>
            &nbsp;&nbsp;
            <input type="radio" id="newsNo" name="newsletter" value="No">
            <label for="newsNo" style="display:inline; font-weight:normal;">No</label>
        </div>

        <!-- Field 9: Comments (textarea) -->
        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" maxlength="500"
                  placeholder="Tell us a little about yourself..."></textarea>

        <button type="submit" class="submit-btn">Submit as JSON</button>

    </form>

<?php } ?>

</div>

<p class="info">
    <strong>Author:</strong> Joel Atkinson<br>
    <strong>Course:</strong> CSD 440 - Server-Side Scripting<br>
    <strong>Assignment:</strong> 10.2 - JSON Form Page<br>
    <strong>Description:</strong> This program displays an HTML form that
    collects nine different fields of fan-profile data. When the form is
    posted back to the same PHP CGI, each field is validated. If every
    field is valid, the data is encoded with json_encode and displayed in
    a pretty-printed, well-formatted output box. If any field fails
    validation - or if json_encode itself fails - an error display lists
    the problem so the user can correct it and resubmit.
</p>

</body>
</html>
