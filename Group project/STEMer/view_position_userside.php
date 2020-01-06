<?php
session_start();
if (isset($_SESSION['userID'])) { // Already been determined.
    include ('./includes/header_after_login.php');
} else { // Need to determine.
    include ('./includes/header_before_login.php');
}
$page_title = 'view position userside';
if ( (isset($_GET['positionID']))  ) {
    $positionid = $_GET['positionID'];
}
require_once ('./mysql_connect.php'); // Connect to the db.
     // Connect to the db.
    
    // Retrieve the user's information.
    $query = "SELECT positionID, title, jobDescription, employmentType, responsibility, salary_low, salary_high, publishTime, position.companyID, logoPath, company.name, city, state, country, company.companyID FROM position, company WHERE positionID = $positionid AND company.companyID=position.companyID ";
    $result = @mysql_query ($query); // Run the query.
    
    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.
        
        // Get the user's information.
        $row = mysql_fetch_array ($result, MYSQL_ASSOC);
        
        // Create the form.
        echo '<!--basic info-->
       <img src="images\bk.jpg" style="height: 100%; width: 100%">
        <div class="card rounded-0" style="margin-left: 10%;max-width: 80%;margin-top: 30px;">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
                <img src="'. $row['logoPath'] . ' " style="height: 100px; height: 100px;">
            </div>
            <div class="col-sm-10">
                '. $row['title'] .'<br>
                '. $row['name'] .' '. $row['city'] .' '. $row['state'] .' '. $row['country'] .'<br>
                <span>Posted on</span>'. $row['publishTime'] .'<br>
                <button type="button" class="btn btn-primary" href="">Apply</button>
            </div>
        </div>
    </div>
</div>
        <!--position-->
<div class="card rounded-0" style="margin-left: 10%;max-width: 80%;margin-top: 30px;">
<ul class="list-group list-group-flush" style="list-style: none">
        <li class="list-group-item">
            <h3>Job Description</h3>
            <p>'. $row['jobDescription'] .'</p>
            <h4>Employment Type</h4>
            <p>'. $row['employmentType'] .'</p>
            <h4>Responsibilities</h4>
            <p>'. $row['responsibility'] .'</p>
            <h4>Salary</h4>
            <p>Between'. $row['salary_low'] .' and '. $row['salary_high'] .'</p>
            </li>
            <li style="min-height:60px" align="center">
            <button type="button" class="btn btn-secondary" href="" style="margin-top: 10px">Apply</button>
        </li>
    </ul>
</div>
';} else {
    echo '
        <p class="error">experience has been accessed in error.</p><p><br /><br /></p>';
}





mysql_free_result ($result);
mysql_close(); // Close the database connection.

include ('./includes/footer.html');
?>
