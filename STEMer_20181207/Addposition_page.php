<?php
/**
 * Created by PhpStorm.
 * User: yitongliu
 * Date: 11/26/18
 * Time: 6:02 PM
 */
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

    .grey {
        background-color: white;
        margin-left: 20%;
        margin-right: 20%;
        margin-top: 5%;
        margin-bottom: 5%;
        padding-bottom: 3%;
        border-style:ridge;
    }
    .white{
        background-color: white;
        margin-left: 5%;
        margin-right: 5%;
        padding-bottom: 30px;

    }
    .header1{
        padding-top: 40px;
        margin-left: 10%;
        margin-right: 8%;
        font-size: 30px;
        font-family: Helvetica;

    }
    .header2{
        padding-top: 40px;
        text-align: center;
        font-size: 20px;
        font-family: Kefa;

    }
    h3{margin-left: 20%;

    }
    p{
        font-size: 20px;
        font-family: Helvetica;
        padding-left: 30px;
    }
    .row{
        padding-left: 65px;
        padding-right: 100px;
        padding-top: 10px;
        font-size: 20px;
        font-family: Helvetica;


    }
    #Email{
        font-size: 15px;
        font-family: Helvetica;

    }
    #Password1{
        font-size: 15px;
        font-family: Helvetica;

    }
    #Password2{
        font-size: 15px;
        font-family: Helvetica;

    }

    .form-check-inline{
        margin-left: 30px;
        padding-right:10px;
        padding-top: 15px;
        font-size: 20px;
        font-family: Helvetica;

    }
    .agreement{
        margin-top: 30px;
        margin-left: 85px;

    }
    .btn-secondary{
        margin-bottom:20px;
        margin-top:15px;
    }

    .btn{
        margin-left: 25%;
        padding-right: 300%;
        margin-bottom: 10%;

    }


</style>
<?php
session_start();
$companyAccountID=$_SESSION["companyID"];
if (isset($_POST['submitted'])) {

    require_once ('mysql_connect.php'); // Connect to the db.

    $errors = array(); // Initialize error array.

    if (empty($_POST['title'])) {
        $errors[] = 'You forgot to enter the title.';
    } else {
        $title = escape_data($_POST['title']);
    }

    if (empty($_POST['description'])) {
        $errors[] = 'You forgot to enter the description.';
    } else {
        $description = escape_data($_POST['description']);
    }
    if (empty($_POST['type'])) {
        $errors[] = 'You forgot to enter the employment type.';
    } else {
        $type = escape_data($_POST['type']);
    }
    if (empty($_POST['responsibilities'])) {
        $errors[] = 'You forgot to enter the responsibilities.';
    } else {
        $responsibilities = escape_data($_POST['responsibilities']);
    }
    if (empty($_POST['lowest'])) {
        $errors[] = 'You forgot to enter the lowest salary.';
    } else {
        $lowest = escape_data($_POST['lowest']);
    }
    if (empty($_POST['highest'])) {
        $errors[] = 'You forgot to enter the highest salary.';
    } else {
        $highest = escape_data($_POST['highest']);
    }






    if (empty($errors)) { // If everything's OK.




            //插入数据到表格 profile
            $query2 = "INSERT INTO position (companyID,title,jobDescription,employmentType,responsibility,salary_low,salary_high,publishTime) VALUES ('$companyAccountID','$title', '$description', '$type', '$responsibilities', '$lowest', '$highest', NOW() )";
            $result2 = @mysql_query ($query2); // Run the query2, return TRUE if success, FALSE if failed.
            $query3 = "SELECT positionID FROM position WHERE companyID='$companyAccountID'";
            $result3 = @mysql_query ($query3);
            $number=mysql_num_rows($result3);
            $n=$number-1;
            $row=mysql_fetch_array($result3,MYSQL_NUM);
        $url = "list_positions_companyside.php";
        echo '<meta http-equiv="refresh" content="1;url='.$url.'">';

            if ($result2 ) { // If it ran OK.

                // Redirect the user to the thanks.php page.
                // Start defining the URL.
                $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

                // Check for a trailing slash.
                if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) {
                    $url = substr ($url, 0, -1); // Chop off the slash.
                }

                exit();

            } else { // If it did not run OK.
                $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
                if ($result2 == false)
                    $errors[] = mysql_error() . '<br /><br />Query: ' . $query2; // Debugging message.

            }

        }
//        else { // Email address is already taken.
//            $errors[] = 'The email address has already been registered.';
//        }


    mysql_close(); // Close the database connection.

} else { // Form has not been submitted.

    $errors = NULL;

} // End of the main Submit conditional.

// Begin the page now.
$page_title = 'Log In Or Sign Up';

if (!empty($errors)) { // Print any error messages.
    echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) { // Print each error.
        echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p>';
}

// Create the form.
?>
<?php
include ('./includes/header_after_login_company.php');
?>
<FORM method="post" action="Addposition_page.php">
    <h1 class="header2"><Strong>Position Information</Strong></h1>

    <div class="grey">
        <h1> <br></h1>
            <div class="row">
                <label><strong>Title*</strong></label>
                <input  type="text" id="title"  name="title">
            </div>
            <div class="row">
                <label><strong>Job Description*</strong></label>
                <input  type="text" id="description"  name="description">
            </div>
            <div class="row">
                <label><strong>Employment Type*</strong></label>
                <input  type="text" id="type"  name="type">
            </div>
            <div class="row">
            <label><strong>Responsibilities*</strong></label>
            <input  type="text" id="responsibilities"  name="responsibilities">
             </div>
             <div class="row">
            <label><strong>Monthly Salary Range (USD)*</strong></label>
             </div>

            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>Lowest:*</strong></label>
                    <input  type="text" id="lowest"  name="lowest">

                </div>
                <div class="form-check">
                    <label><strong>Highest:*</strong></label>
                    <input  type="text" id="highest"  name="highest">


                </div>

            </div>
        <div class="btn">

            <button class="btn btn-secondary btn-lg btn-block" type="submit" name="submitted">Save</button>
        </div>
    </div>

    <?php
    include ('./includes/footer.html');
    ?>

