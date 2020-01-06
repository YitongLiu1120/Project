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
$display = 9;

// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
} else { // Need to determine.

 	// Count the number of records
	$query = "SELECT COUNT(*) FROM company";
	$result = @mysql_query ($query);
	$row = mysql_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];
	
	// Calculate the number of pages.
	if ($num_records > $display) { // More than 1 page.
		$num_pages = ceil ($num_records/$display);
	} else {
		$num_pages = 1;
	}
	
} // End of np IF.

// Determine where in the database to start returning results.
if (isset($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
	
// Make the query.
$query = "SELECT companyID, name, industry, description, logoPath FROM company LIMIT $start, $display";		
$result = @mysql_query ($query); // Run the query.

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
				<div class="card-footer btn bg-dark ">';
	if (isset($_SESSION['accountID'])) { // Already been determined.
		$accountID = $_SESSION['accountID'];
		$query1 = "SELECT accountType FROM account where accountID='$accountID'";		
		$result1 = @mysql_query ($query1); // Run the query.
		if (mysql_num_rows($result1) == 1) {
			$row1 = mysql_fetch_array ($result, MYSQL_NUM);
			$accountType = $row1[0];
			if($accountType == "Company"){
				echo'<a href="view_company_companyside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
			}
			else{
				echo'<a href="view_company_userside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
			}
		}
		else{
			echo' accountID error';
		}
	} 
	else { // Need to determine.
		echo'<a href="view_company_userside.php?companyID=' . $row['companyID'] . '" class="card-link" style="color:white"><h5>Learn More</h5></a>';
	}			
	echo'</div>
			</div>
		</div>
	';
}

mysql_free_result ($result); // Free up the resources.	

mysql_close(); // Close the database connection.

// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	echo'
	<div style="width:90%">
		<nav class="float-right page">
			<ul class="pagination">
';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button.
	if ($current_page != 1) {
		echo'
		<li class="page-item">
			<a href="Company_page.php?s=' . ($start - $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo'<li class="page-item"><a href="Company_page.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
		} 
		else {
			echo'<li class="page-item active"><a href="Company_page.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
		}
	}
	
	// If it's not the last page, make a Next button.
	if ($current_page != $num_pages) {
		echo'
		<li class="page-item">
			<a href="Company_page.php?s=' . ($start + $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
		';
	}
	
	echo '
	</ul>
	</nav>
	</div>
	';
	
} // End of links section.

echo'</div></div>';

include ('./includes/footer.html');
?>