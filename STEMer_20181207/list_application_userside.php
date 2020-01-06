<?php
/**
 * Created by PhpStorm.
 * User: fuzigeng
 * Date: 28/11/2018
 * Time: 6:17 PM
 */
session_start();
//Include header according to the login status
include ('./includes/header_after_login.php');


//if (isset($_SESSION['userID'])) { // Session is already set.
//    include ('./includes/header_after_login.php');
//} else { // Session is not set.
//    $message = "Please login first.";
//    echo "
//        <script type='text/javascript'>
//            var r = confirm($message);
//            if (r == true) { //Click OK button
//                header('Location: index.php'); //Redirect to the login page or index.php
//                exit; //Make sure that code below does not get executed when we redirect.
//            } else {  //Click Cancel button
//
//            }
//        </script>
//    ";
//}

require_once ('mysql_connect.php'); // Connect to the db.

//User ID get from session
$userID = $_SESSION['userID'];

//Test user ID
//$userID = '101';

// Number of records to show per page:
$display = 10;

// Determine how many pages there are.
if (isset($_GET['np'])) { // Already been determined.
    $num_pages = $_GET['np'];
} else { // Need to determine.
    // Count the number of records
    $query = "SELECT COUNT(*) FROM application app, position pos, company
              where app.userID= $userID and app.positionID = pos.positionID and pos.companyID = company.companyID
              ORDER BY app.applicationTime DESC";
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

// Default column links.
$link1 = "{$_SERVER['PHP_SELF']}?sort=dateAppAsc";

// Determine the sorting order.
if (isset($_GET['sort'])) {

    // Use existing sorting order.
    switch ($_GET['sort']) {
        case 'dateAppDesc':
            $order_by = 'app.applicationTime DESC';
            $link1 = "{$_SERVER['PHP_SELF']}?sort=dateAppAsc";
            break;
        case 'dateAppAsc':
            $order_by = 'app.applicationTime ASC';
            $link1 = "{$_SERVER['PHP_SELF']}?sort=dateAppDesc";
            break;
        default:
            $order_by = 'app.applicationTime DESC';
            break;
    }

    // $sort will be appended to the pagination links.
    $sort = $_GET['sort'];

} else { // Use the default sorting order.
    $order_by = 'app.applicationTime DESC';
    $sort = 'dateAppDesc';
}


// Make the query. (Joint four tables: application, position, feedback, company)
$query = "SELECT app.applicationID, pos.positionID, pos.title, company.name, company.state, company.city, app.applicationTime, app.status
          FROM application app, position pos, company 
          where app.userID=$userID and pos.companyID=company.companyID and app.positionID = pos.positionID
          ORDER BY $order_by LIMIT $start, $display";

$result = @mysql_query ($query); // Run the query.

echo '


<div class = "contentWrapper">
    <h4 style="margin-bottom: 30px">Manage Position Applications</h4>
    
    <div class="resultList">
    <table class="table table-striped" style="font-size: 12px">
    <thead>
        <tr>
            <th scope="col" align="left"><b>Position</b></th>
            <th scope="col" align="left"><b>Company</b></th>
            <th scope="col" align="left"><b>Location</b></th>
            <th scope="col" align="left"><b><a href="' . $link1 . '">Date Applied</a></b></th>
            <th scope="col" align="left"><b>Status</b></th>
            <th scope="col" style="padding-left: 25px"><b>Action</b></th>
        </tr>
    </thead class="thead-light">
    <tbody>
    
';


// Fetch and print all the records.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo '
		<tr>
		    <td scope="col" class="align-middle" align="left">'. $row['title'] .'</td>
		    <td scope="col" class="align-middle" align="left">'. $row['name'] .'</td>
		    <td scope="col" class="align-middle" align="left">'. $row['city'] .'</td>
		    <td scope="col" class="align-middle" align="left">'. $row['applicationTime'] .'</td> 
    ';

    if($row['status']=="Decided"){
        echo '
		    <td scope="col" class="align-middle" align="left"><span class="badge badge-success">'. $row['status'] .'</span></td>
        ';
    }else if($row['status']=="Pending"){
        echo '
		    <td scope="col" class="align-middle" align="left"><span class="badge badge-warning">'. $row['status'] .'</span></td>
        ';
    }

    echo '
		    <td scope="col" align="left">
                <a style="font-size: 12px" class="btn mini blue-stripe" role="button" href="applicant_application_userside.php?applicationID='.$row['applicationID'].' ">View</a>
                <a style="font-size: 12px" class="btn mini confirm-delete red-stripe" role="button" href="#">Delete</a>
            </td>
        </tr>
	';
}

echo '
    </tbody>	        
    </table>
    </div> 
</div>

';

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
			<a href="list_application_userside.php?s=' . ($start - $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		';
    }

    // Make all the numbered pages.
    for ($i = 1; $i <= $num_pages; $i++) {
        if ($i != $current_page) {
            echo'<li class="page-item"><a href="list_application_userside.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
        }
        else {
            echo'<li class="page-item active"><a href="list_application_userside.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '" class="page-link">' . $i . '</a></li>';
        }
    }

    // If it's not the last page, make a Next button.
    if ($current_page != $num_pages) {
        echo'
		<li class="page-item">
			<a href="list_application_userside.php?s=' . ($start + $display) . '&np=' . $num_pages . '" class="page-link" aria-label="Next">
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


include ('./includes/footer.html');
?>

