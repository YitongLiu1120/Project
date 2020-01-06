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
                    <div class="card-body text_height">
                        <h6 class="card-title" style="line-height: 15px">' . $row['title'] . '</h6>
                        <p class="card-title" style="font-size: 14px; line-height: 15px">'. $row['name'] . '</p>
                        <p class="card-text" style="color:gray; font-size: 12px; line-height: 15px">' . $row['address'] . ', <br>' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zipcode'] . ', ' . $row['country'] . '<br><br>Published on ' . $row['pt'] . '</p>
					</div>
                    <div class="card-footer btn bg-dark ">
	';
	if (isset($_SESSION['accountID'])) { // Already been determined.
		$accountID = $_SESSION['accountID'];
		$query1 = "SELECT accountType FROM account where accountID='$accountID'";		
		$result1 = @mysql_query ($query1); // Run the query.
		if (mysql_num_rows($result1) == 1) {
			$row1 = mysql_fetch_array ($result, MYSQL_NUM);
			$accountType = $row1[0];
			if($accountType == "Company"){
				echo'<a href="view_position_companyside.php?positionID=' . $row['positionID'] . '" class="card-link" style="color:white"><h5>View Position</h5></a>';
			}
			else{
				echo'<a href="view_position_userside.php?positionID=' . $row['positionID'] . '" class="card-link" style="color:white"><h5>View Position</h5></a>';
			}
		}
		else{
			echo' accountID error';
		}
	} 
	else { // Need to determine.
		echo'<a href="view_position_userside.php?positionID=' . $row['positionID'] . '" class="card-link" style="color:white"><h5>View Position</h5></a>';
	}
    echo '</div>
                </div>
            </div>
	';
}

echo '
			<div style="width:90%">
				<a href="Job_page.php" class="card-link float-right pagination"><p style="color:gray">View more position</p></a>
			</div>
        </div>
    </div>
';

// Make the query.
$query = "SELECT companyID, name, industry, description, logoPath FROM company LIMIT $start, $company_display";		
$result = @mysql_query ($query); // Run the query.

// 
echo '<div id="section2" class="container-fluid rounded position">
        <h5 style="padding-bottom: 30px;">POPULAR COMPANIES</h5>
        <div class="row" style="padding-bottom: 20px;">
';

// Fetch and print all the records.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '
		<div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4 ">
			<div class="card">
				 <img class="company_logo2" src=" '. $row['logoPath'] . '" alt="Card image">
				 <div class="company-title">
					<h5>' . $row['name'] . '</h5>
					<p class="industry">' . $row['industry'] . '</p> 
				 </div>                    
				 <div class="card-body text_height2">
					<p class="company-body">'. $row['description'] . '</p>
				</div>
				<div class="card-footer btn bg-dark ">
				';
	if(isset($accountType)){
		if($accountType == "Company"){
			echo'<a href="view_company_companyside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
		}
		else{
			echo'<a href="view_company_userside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
		}
	}
	else{
		echo'<a href="view_company_userside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
	}
	echo'</div>
			</div>
		</div>
	';
}

echo '
			<div style="width:90%">
				<a href="Company_page.php" class="card-link float-right pagination"><p style="color:gray">Find more companies</p></a>
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