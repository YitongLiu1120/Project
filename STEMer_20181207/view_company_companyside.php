<?php
session_start();
if (isset($_SESSION['companyID'])) { // Already been determined.
    include ('./includes/header_after_login_company.php');
} else { // Need to determine.
    include ('./includes/header_before_login.php');
}
$page_title = 'company information company side';
if ( (isset($_GET['companyID']))  ) {
    $companyid = $_GET['companyID'];
}
require_once ('./mysql_connect.php'); // Connect to the db.
     // Connect to the db.
$id= $_SESSION['companyID'];

$querytest = "SELECT name FROM company WHERE companyID = $id";
$resulttest = @mysql_query ($querytest);
$row1 = mysql_fetch_array ($resulttest, MYSQL_ASSOC);
if ($row1['name'] == null) {
     // Run the query.
    echo'<div align="center" style="padding-bottom: 500px;"><a type="button" class="btn btn-outline-danger" href="Addcompany_page.php" >Add Information</a></div>';
} else{
    // Retrieve the user's information.
    $query = "SELECT companyID, name, address, city, state, zipcode, country, foundYear, industry, description, websiteAddr, logoPath FROM company WHERE companyID = $id";
    $result = @mysql_query ($query); // Run the query.
    
    if (mysql_num_rows($result) == 1) { // Valid user ID, show the form.
        
        // Get the user's information.
        $row = mysql_fetch_array ($result, MYSQL_ASSOC);
        
        // Create the form.
        echo '
<img src="images/bg_company.jpg" style="height: 100%; width: 100%">
        <div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
                <img src="'. $row['logoPath'] .'" style="height: 100px; height: 100px;">
            </div>
            <div class="col-sm-10">
                '. $row['name'] .'
                <a class="button" href="Editcompany_page.php" style="float:right">
                    <i class="fas fa-user-edit"></i>
                </a>
                <br>
                '. $row['city'] .'<span>，</span>'. $row['state'] .'<br>
            </div>
        </div>
    </div>
</div>
    <!--position-->
<div class="card rounded-0" style="margin-left: 15%;max-width: 70%;margin-top: 30px;">
    <div class="card-body">
        <h3>About Company</h3>
        <p>'. $row['description'] .'</p>
        <h3>Company details</h3>
        <h4>Website</h4>
        <p>'. $row['websiteAddr'] .'</p>
        <h4>headquarters</h4>
        <p>'. $row['city'] .','. $row['state'] .'</p>
        <h4>Year Founded</h4>
        <p>'. $row['foundYear'] .'</p>
        <h4>Specialties</h4>
        <p>'. $row['industry'] .'</p>
    </div>
</div>
';} else {
    echo '
        <p class="error">company info has been accessed in error.</p><p><br /><br /></p>';
}



mysql_free_result ($result);
mysql_close(); // Close the database connection.
}
include ('./includes/footer.html');
?>
