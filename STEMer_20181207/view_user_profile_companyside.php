<?php
session_start();
if (isset($_SESSION['companyID'])) { // Already been determined.
    include ('./includes/header_after_login.php');
} else { // Need to determine.
    include ('./includes/header_before_login.php');
}
$page_title = 'Profile userside';
require_once ('./mysql_connect.php'); // Connect to the db.
// Connect to the db.

// Retrieve the user's information.
$id= $_GET['profileID'];

$querytest = "SELECT * FROM edu_background WHERE profileID = $id";
$resulttest = @mysql_query ($querytest);
if (mysql_num_rows($resulttest) == 0) {
    echo'<h4 style="padding-bottom: 500px">He does not have profile yet!</h4>';
} else {
    $query = "SELECT profileID, firstName, lastName, contactEmail, phone, address, city, state, zipcode, country, summary, portraitPath FROM profile WHERE profileID = $id";
    $result = @mysql_query ($query); // Run the query.
    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.

        // Get the user's information.
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        // Create the form.
        echo '<!--basic info-->
        <img src="images/bg_user.jpg" style="height: 100%; width: 100%">
        <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
        <div class="card-body">
        <div class="row">
        <div class="col-sm-2">
        <img src="' . $row['portraitPath'] . '" style="height: 100px; height: 100px;">
        </div>
        <div class="col-sm-10">
        ' . $row['firstName'] . '&nbsp;' . $row['lastName'] . '
        <br>
        ' . $row['city'] . '&nbsp;' . $row['state'] . '<br>
        <hr>
        ' . $row['summary'] . '
        </div>
        </div>
        </div>
        </div>
';
    } else {
        echo '
        <p class="error">profile has been accessed in error.</p><p><br /><br /></p>';
    }

    $query = "SELECT profileID, title, company, location, fromDate, toDate, description FROM experience WHERE profileID = $id";
    $queryLogo = "SELECT company, logoPath, name FROM experience, company WHERE company = name ";
    $result = @mysql_query($query);
    $resultLogo = @mysql_query($queryLogo);

    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.

        // Get the user's information.
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        // Create the form.
        echo '
     <!--Experience-->
        <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
        <div class="card-header rounded-0" style="background-color:#b0e4fa">
        Experience
        </div>
        <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <div class="row">
        <div class="col-sm-5">';
        $rowLogo = mysql_fetch_array($resultLogo, MYSQL_ASSOC);
        if (mysql_num_rows($resultLogo) == 1) {

            echo ' <img src="' . $rowLogo['logoPath'] . '" style="height: 50px; height: 50px;">' . $row['company'] . '';
        } else {
            echo ' <img src="images/company_logo1.png" style="height: 50px; height: 50px;">' . $row['company'] . '';
        }
        echo '
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-3">' . $row['fromDate'] . '<span>-</span>' . $row['toDate'] . '</div>
        </div>
        <p>' . $row['title'] . '<br>' . $row['experience.description'] . '
        </p>
        </li>
        </ul>
        </div>
';
    } else {
        echo '
        <p class="error">experience has been accessed in error.</p><p><br /><br /></p>';
    }

    $query = "SELECT profileID, university, degree, major, activity, fromYear, toYear, description FROM edu_background WHERE profileID = $id";
    $result = @mysql_query($query); // Run the query.

    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.

        // Get the user's information.
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        // Create the form.
        echo '
     <!--Education background-->
        <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
        <div class="card-header rounded-0" style="background-color:#b0e4fa">
        Education Background
        </div>
        <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <div class="row">
        <div class="col-sm-5">
        ' . $row['university'] . '
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-3">' . $row['fromYear'] . '' . $row['toYear'] . '</div>
        </div>
        <p>' . $row['degree'] . 'in ' . $row['major'] . '<br>' . $row['activity'] . '<br>' . $row['edu_background.description'] . '
        </p>
        </li>
        </ul>
        </div>
';
    } else {
        echo '
        <p class="error">education background has been accessed in error.</p><p><br /><br /></p>';
    }

    $query = "SELECT profileID, skillsContent FROM experience WHERE profileID = $id";
    $result = @mysql_query($query); // Run the query.

    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.

        // Get the user's information.
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        // Create the form.
        echo '
    <!--skill&tools-->
        <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
        <div class="card-header rounded-0" style="background-color:#b0e4fa">
        Skills & Tools
        </div>
        <div class="card-body">';
        $skills = "SELECT skillsContent FROM skills WHERE profileID = $id";
        $hello = explode(',', $skills);

        for ($index = 0; $index < count($hello); $index++) {
            echo '<button type="button" class="btn btn-outline-dark" disabled="disabled">' . $hello[$index] . '</button>';
        }
        echo ' 
        </div>
        </div>
        ';
    } else { // Not a valid user ID.
        echo '<h1 id="mainhead">Page Error</h1>
        <p class="error">skills has been accessed in error.</p><p><br /><br /></p>';
    }

    mysql_free_result($result);
    mysql_close(); // Close the database connection.
}
include ('./includes/footer.html');
?>
