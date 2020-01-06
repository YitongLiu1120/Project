<?php # Script 3.4 - index.php

require_once ('mysql_connect.php'); // Connect to the db.

// Number of records to show per page:
$display = 12;
$companyID = $_GET['companyID'];
// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
} else { // Need to determine.

 	// Count the number of records
	$query = "SELECT COUNT(*) FROM position WHERE position.companyID='$companyID' ";
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

// Determine the sorting order.
$order_by = 'publishTime DESC';
		
// Make the query.
$query = "SELECT positionID, title, name, address, city, state, zipcode, country, logoPath, DATE_FORMAT(publishTime, '%M %d, %Y') AS pt FROM position, company where position.companyID ='$companyID' AND position.companyID = company.companyID  ORDER BY $order_by LIMIT $start, $display";		
$result = @mysql_query ($query); // Run the query.		

echo '<div id="section1" class="container-fluid rounded position">
      <h5 style="padding-bottom: 30px;">PUBLISHED POSITIONS</h5>
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
                        <a href="position_description_page.php?id=' . $row['positionID'] . '" class="card-link" style="color:white"><h5>View Position</h5></a>
                    </div>
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
			<a href="Job_page.php?s=' . ($start - $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo'<li class="page-item"><a href="Job_page.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
		} 
		else {
			echo'<li class="page-item active"><a href="Job_page.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
		}
	}
	
	// If it's not the last page, make a Next button.
	if ($current_page != $num_pages) {
		echo'
		<li class="page-item">
			<a href="Job_page.php?s=' . ($start + $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Next">
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

?>