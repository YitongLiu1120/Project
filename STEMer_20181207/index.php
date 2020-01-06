<?php # Script 3.4 - index.php
$page_title = 'Welcome to this Site!';
session_start();
if (isset($_SESSION['userID'])) { // Already been determined.
	include ('./includes/header_after_login.php');
} else { // Need to determine.
	include ('./includes/header_before_login.php');
}

require_once ('mysql_connect.php'); // Connect to the db.

// Number of records to show per page:
$position_display = 8;
$company_display = 6;

// Determine where in the database to start returning results.
$start = 0;

// Determine the sorting order.
$order_by = 'publishTime DESC';
	
		
// Make the query.
$query = "SELECT positionID, title, name, address, city, state, zipcode, country, logoPath, DATE_FORMAT(publishTime, '%M %d, %Y') AS pt FROM position, company where position.companyID = company.companyID ORDER BY $order_by LIMIT $start, $position_display";		
$result = @mysql_query ($query); // Run the query.

// 
echo '<div id="section1" class="container-fluid rounded position">
      <h5 style="padding-bottom: 30px;">RECENT PUBLISHED POSITIONS</h5>
		  <div class="row" style="padding-bottom: 20px;">
';

// Fetch and print all the records.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '
			<div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card rounded-top">
                    <img class="card-img-top rounded-top company_logo" src="'. $row['logoPath'] . ' " alt="Card image">
                    <div class="card-body">
                        <div class="title-height">
                            <h6 class="card-title" style="line-height: 15px">' . $row['title'] . '</h6>
                        </div>                        
                        <div class="companyName-height">
                            <p class="card-title" style="font-size: 14px; line-height: 15px">'. $row['name'] . '</p>
                        </div>
                        <div class="companyInfo-height">
                            <p class="card-text" style="color:gray; font-size: 12px; line-height: 15px">' . $row['city'] . ', ' . $row['state'] . '<br>' . $row['country'] . '</p>
                        </div>
                        <div class="postTime-height">
                            <p class="card-text" style="color:gray; font-size: 12px; line-height: 15px"> Posted on ' . $row['pt'] .'</p>
                        </div>
                    </div>
                    <div class="card-footer btn bg-dark ">
						<a href="view_position_userside.php?positionID=' . $row['positionID'] . '" class="card-link" style="color:white"><h6>View Position</h6></a>
					</div>
				</div>
			</div>
	';
}

echo '
			<div style="width:90%">
				<a href="Job_page.php" class="card-link float-right pagination"><p style="color:gray">View more position >></p></a>
			</div>
        </div>
    </div>
';

// Make the query.
$query = "SELECT companyID, name, industry, description, logoPath FROM company LIMIT $start, $company_display";		
$result = @mysql_query ($query); // Run the query.

// 
echo '<div id="section2" class="container-fluid rounded position" style="margin-bottom: 70px">
        <h5 style="padding-bottom: 30px;">POPULAR COMPANIES</h5>
        <div class="row" style="padding-bottom: 20px;">
';

// Fetch and print all the records.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '
		<div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4 ">
			<div class="card" style="padding-top: 10px">
				 <img class="company_logo2" src=" '. $row['logoPath'] . '" alt="Card image">
				 <div class="company-title">
					<h5>' . $row['name'] . '</h5>
					<p class="industry">' . $row['industry'] . '</p> 
				 </div>                    
				 <div class="card-body text_height2" style="font-size: 14px;">';
	$description = $row['description'];
	if(strlen($description)>150){
		$description= substr($description, 0, 150);
		$description = $description . '...';
	}
	echo'				<p class="company-body">'. $description . '</p>
				</div>
				<div class="card-footer btn bg-dark ">
					<a href="view_company_userside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h6>Learn More</h6></a>
				</div>
			</div>
		</div>
	';
}

echo '
			<div style="width:90%">
				<a href="Company_page.php" class="card-link float-right pagination"><p style="color:gray">Find more companies >></p></a>
			</div>
        </div>
    </div>
';

mysql_free_result ($result); // Free up the resources.	
if(isset($result1)){
	mysql_free_result ($result1);
}

mysql_close(); // Close the database connection.

include ('./includes/footer.html');
?>