<?php
/**
 * Created by PhpStorm.
 * User: yitongliu
 * Date: 11/26/18
 * Time: 6:03 PM
 */
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

    .outsider{
        background-color: #E4E4E4;
        padding-top: 5px;
        margin-left: 20%;
        margin-right: 20%;
        border-style:ridge;
    }
    h4{
        margin-left:25px;
    }

    .grey {
        background-color: white;
        margin-bottom: 5%;
        padding-bottom: 3%;

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
    .form-check-inline{
        margin-left: 30px;
        padding-right:10px;

        font-size: 20px;
        font-family: Helvetica;

    }
    .form-check1{
        margin-left: 65px;
        padding-right:10px;

        font-size: 20px;
        font-family: Arial;

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


$ID=$_SESSION["userID"];
$profileID=$_SESSION["profileID"];
    $positionID = $_GET['positionID'];
require_once('mysql_connect.php');
if (isset($_POST['submitted'])) {

    // Connect to the db.

    if (empty($_POST['first_name'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        $f = escape_data($_POST['first_name']);
    }

    if (empty($_POST['last_name'])) {
        $errors[] = 'You forgot to enter your last name.';
    } else {
        $l = escape_data($_POST['last_name']);
    }
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email.';
    } else {
        $e = escape_data($_POST['email']);
    }
    if (empty($_POST['phone'])) {
        $errors[] = 'You forgot to enter your phone number.';
    } else {
        $phone = escape_data($_POST['phone']);
    }
    if (empty($_POST['address'])) {
        $errors[] = 'You forgot to enter your address.';
    } else {
        $addr = escape_data($_POST['address']);
    }
    if (empty($_POST['city'])) {
        $errors[] = 'You forgot to enter the city.';
    } else {
        $city = escape_data($_POST['city']);
    }
    if (empty($_POST['state'])) {
        $errors[] = 'You forgot to enter the state.';
    } else {
        $state = escape_data($_POST['state']);
    }
    if (empty($_POST['zipcode'])) {
        $errors[] = 'You forgot to enter the zip code.';
    } else {
        $zip = escape_data($_POST['zipcode']);
    }
    if (empty($_POST['country'])) {
        $errors[] = 'You forgot to enter the country.';
    } else {
        $c = escape_data($_POST['country']);
    }
    if (empty($_POST['date'])) {
        $errors[] = 'You forgot to enter the available date.';
    } else {
        $date = escape_data($_POST['date']);
    }
    if (empty($_POST['website'])) {
        $errors[] = 'You forgot to enter the website.';
    } else {
        $website = escape_data($_POST['website']);
    }
    if (empty($_POST['date'])) {
        $errors[] = 'You forgot to enter the available date.';
    } else {
        $date = escape_data($_POST['date']);
    }
    if (empty($_POST['website'])) {
        $errors[] = 'You forgot to enter the website.';
    } else {
        $website = escape_data($_POST['website']);
    }




    if (empty($errors)) { // If everything's OK.



        //插入数据到表格 profile
        $status='Pending';
        $query2 = "INSERT INTO application (userID,positionID,firstName,lastName,contactEmail,phone,address,city,state,zipcode,country,workBeginDate,applicantWebsite,status,applicationTime) VALUES ('$ID','$positionID','$f', '$l', '$e', '$phone', '$addr', '$city', '$state', '$zip', '$c' ,'$date','$website','$status',NOW())";
        $result2 = mysql_query($query2); // Run the query2, return TRUE if success, FALSE if failed.
//        $query3="SELECT LAST_INSERT_ID() FROM application";
//        $result3=mysql_query($query3);
//        $row=mysql_fetch_array($result3);
        $w="You have submitted application successfully!";
        echo "<script> alert('{$w}') </script>";

        $url = "list_application_userside.php";
        echo '<meta http-equiv="refresh" content="1;url='.$url.'">';
        if ($result2 ) { // If it ran OK.

            // Redirect the user to the thanks.php page.
            // Start defining the URL.
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

            // Check for a trailing slash.
            if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) {
                $url = substr ($url, 0, -1); // Chop off the slash.
            }



        } else { // If it did not run OK.
            $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
            if ($result2 == false)
                $errors[] = mysql_error() . '<br /><br />Query: ' . $query2; // Debugging message.

        }

    }


    mysql_close(); // Close the database connection.

} else { // Form has not been submitted.

    $errors = NULL;

}

if (!empty($errors)) { // Print any error messages.
    echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) { // Print each error.
        echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p>';
}



include ('./includes/header_after_login_company.php');

$query = "SELECT firstName, lastName,contactEmail,phone,address,city,state,zipcode,country FROM profile WHERE profileID='$profileID'";
$result = @mysql_query ($query); // Run the query.
$row = mysql_fetch_row($result);
echo' <FORM method="post" action="ApplyForJob.php?positionID='.$positionID.'">
    <div class="outsider">
    <h4>Applicant Information</h4>

    <div class="grey">
        <h1> <br></h1>
        <div class="container-fluid">
            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>First Name*</strong></label>
                    <input  type="text" id="first_name"  name="first_name" value=' . $row[0] . '>

                </div>

                <div class="form-check">
                    <label><strong>Last Name*</strong></label>
                    <input  type="text" id="last_name"  name="last_name" value=' . $row[1] . '>

                </div>
            </div>
            <div class="row">
                <label><strong>Contact Email*</strong></label>
                <input  type="text" id="email"  name="email" value=' . $row[2] . '>
            </div>
            <div class="row">
                <label><strong>Phone*</strong></label>
                <input  type="text" id="last_name"  name="phone" value=' . $row[3] . '>
            </div>
            <div class="row">
                <label><strong>Address*</strong></label>
                <input  type="text" id="address"  name="address" value=' . $row[4] . '>
            </div>

            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>City*</strong></label>
                    <input  type="text" id="city"  name="city" value=' . $row[5] . '>

                </div>

                <div class="form-check">
                    <label><strong>State*</strong></label>
                    <input  type="text" id="state"  name="state" value=' . $row[6] . '></div>
                <div class="form-check">
                    <label><strong>Zip Code*</strong></label>
                    <input  type="text" id="zipcode"  name="zipcode" value=' . $row[7] . '>


                </div>
            </div>
            <div class="row">
                <label><strong>Country*</strong></label>
                <input  type="text" id="country"  name="country" value=' . $row[8] . '>
            </div>
           

        </div>
    </div>

    </div>


            <div class="outsider"><h4>Reference*</h4>
                <div class="grey">

                    <div class="container-fluid">
                        <br>
                        <div class="row">
                            <h4>Resume&nbsp&nbsp </h4>

                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload" name="submit">

</div>


<div class="row">
    <label><strong>Date Available</strong></label>
    <input  type="text" id="date"  name="date">
</div>
<div class="row">
    <label><strong>Website, Blog or Portfolio</strong></label>
    <input  type="text" id="website"  name="website">
</div>
</div>


</div>


<p><input type="submit" name="submit" value="Submit" /></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="\' . $id . \'" />
</FORM>
';
mysql_close();
include ('./includes/footer.html');
?>

