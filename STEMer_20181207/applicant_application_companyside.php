<?php
session_start();
if (isset($_SESSION['companyID'])) { // Already been determined.
    include ('./includes/header_after_login_company.php');
} else { // Need to determine.
    include ('./includes/header_before_login.php');
}

$page_title = 'application userside';
if ( (isset($_GET['applicationID']))  ) {
    $applicationid = $_GET['applicationID'];
}
require_once ('./mysql_connect.php'); // Connect to the db.
    
    // Retrieve the user's information.
    $query = "SELECT applicationID,userID, positionID, firstName, lastName, contactEmail, phone, address, city, state, zipcode, country, resumePath, workBeginDate, applicantWebsite, status FROM application WHERE applicationID = '$applicationid'";
    $queryProfileID ="SELECT profileID, profile.userID, application.userID FROM profile, application WHERE profile.userID = application.userID";

    $result = @mysql_query ($query); // Run the query.
    $resultProfileID = @mysql_query ($queryProfileID);
    $rowProfileID = mysql_fetch_array ($resultProfileID, MYSQL_ASSOC);
    $profileid = $rowProfileID['profileID'];
    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.
        
        // Get the user's information.
        $row = mysql_fetch_array ($result, MYSQL_ASSOC);
        
        // Create the form.
        echo '
<div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
    <ul class="list-group list-group-flush">
        <li class="list-group-item" style="background-color:#ededed">
            Applicant Information
        </li>
        <li class="list-group-item">
        <p><b>Name</b></p>
        <p>'. $row['firstName'] .'&nbsp'. $row['lastName'] .'</p>
        <p><b>Applicant Profile Page</b></p>
        <a href="view_user_profile_companyside.php?profileID='.$profileid.'">'. $row['firstName'] .'&nbsp'. $row['lastName'] .' Homepage</a>
        <p><b>Email</b></p>
        <p>'. $row['contactEmail'] .'</p>
        <p><b>Phone</b></p>
        <p>'. $row['phone'] .'</p>
        <p><b>Address</b></p>
        <p>'. $row['address'] .'</p>
        <p><b>City</b></p>
        <p>'. $row['city'] .'</p>
        <p><b>State</b></p>
        <p>'. $row['state'] .'</p>
        <p><b>Zip Code</b></p>
        <p>'. $row['zipcode'] .'</p>
        <p><b>Country</b></p>
        <p>'. $row['country'] .'</p>
        </li>
        <li class="list-group-item" style="background-color:#e5e5e5">
            Reference
        </li>
        <li class="list-group-item">
        <p><b>Resume</b></p>
        <button type="button" class="btn btn-outline-success" onclick="">Download</button>
        <p><b>Date Available</b></p>
        <p>'. $row['workBeginDate'] .'</p>
        <p><b>Website, Blog or Portfolio</b></p>
        <p><a href="'. $row['applicantWebsite'] .'">'. $row['applicantWebsite'] .'</a></p>
        </li>
        <li class="list-group-item" style="background-color:#e5e5e5">
            Feedback
        </li>
        <li class="list-group-item">
            <b>Application Status: </b>';
        $queryFeedback = "SELECT applicationID, feedbackID, result, interviewTime, interviewLocation, comments FROM feedback WHERE applicationID = '$applicationid'";
        $resultFeedback = @mysql_query ($queryFeedback);
        $rowFeedback = mysql_fetch_array ($resultFeedback, MYSQL_ASSOC);
        if($row['status'] == "Pending") {
            echo '<span style="color: blue">Pending</span>
                 <a type="button" class="btn btn-outline-success" href="Scheduleinterview_page.php?applicationID='.$applicationid.'">Schedule an Interview</a>
                 <a type="button" class="btn btn-outline-danger" href="Scheduleinterview_rejected.php?applicationID='.$applicationid.'">Rejected</a>';
        }elseif($rowFeedback['result'] == "Rejected"){
            echo'<p style="color: red">Rejected</p>';
        }
        if($rowFeedback['result'] == "Interview Scheduled"){
            echo'<p style="color: limegreen">Scheduled Interview</p>';
        }
echo'
        </li>
    </ul>
</div>
';} else {
            echo '
        <p class="error">application has been accessed in error.</p><p><br /><br /></p>';
        }

 // Run the query.
if (mysql_num_rows($resultFeedback) == 1) { // Valid user ID, show the form.

    // Create the form.
    if($rowFeedback['result'] == "Interview Scheduled" ){
        echo '
<div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
    <ul class="list-group list-group-flush">
        <li class="list-group-item" style="background-color:#ededed">
            Interview Arrangement
        </li>
        <li class="list-group-item">
        <p><b>Date</b></p>
        <p>'. $rowFeedback['interviewTime'] .'</p>
        <p><b>Location</b></p>
        <p>'. $rowFeedback['interviewLocation'] .'</p>
        <p><b>Comments</b></p>
        <p>'. $rowFeedback['comments'] .'</p>
        </li>
    </ul>
</div>
';}
    elseif ($rowFeedback['result'] == "Rejected") {
        echo '
       <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
    <ul class="list-group list-group-flush">
    <li class="list-group-item" style="background-color:#ededed">
            Sorry For Rejection
        </li>
        <li class="list-group-item">
        <p><b>Comments:</b></p>
        <p>' . $rowFeedback['comments'] . '</p>
        </li>
    </ul>
</div>
        ';
    }
}

mysql_free_result ($result);
mysql_close(); // Close the database connection.

include ('./includes/footer.html');
?>
