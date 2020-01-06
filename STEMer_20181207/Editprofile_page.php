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
require_once('mysql_connect.php');
session_start();
$ID=$_SESSION["userID"];
$profileID=$_SESSION["profileID"];
if (isset($_POST['save'])) {

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
    //check for edu_background

    if (empty($_POST['school'])) {
        $errors[] = 'You forgot to enter the school.';
    } else {
        $school = escape_data($_POST['school']);
    }
    if (empty($_POST['degree'])) {
        $errors[] = 'You forgot to enter the degree.';
    } else {
        $degree = escape_data($_POST['degree']);
    }
    if (empty($_POST['major'])) {
        $errors[] = 'You forgot to enter the major.';
    } else {
        $major = escape_data($_POST['major']);
    }
    if (empty($_POST['activity'])) {
        $errors[] = 'You forgot to enter the activity.';
    } else {
        $activity = escape_data($_POST['activity']);
    }
    if (empty($_POST['fromYear'])) {
        $errors[] = 'You forgot to enter the from year.';
    } else {
        $from = escape_data($_POST['fromYear']);
    }
    if (empty($_POST['toYear'])) {
        $errors[] = 'You forgot to enter the to year.';
    } else {
        $to = escape_data($_POST['toYear']);
    }
    if (empty($_POST['description'])) {
        $errors[] = 'You forgot to enter the description.';
    } else {
        $description = escape_data($_POST['description']);
    }

    //check for experience表
    if (empty($_POST['title'])) {
        $errors[] = 'You forgot to enter the title.';
    } else {
        $title = escape_data($_POST['title']);
    }
    if (empty($_POST['company'])) {
        $errors[] = 'You forgot to enter the company.';
    } else {
        $company = escape_data($_POST['company']);
    }
    if (empty($_POST['location'])) {
        $errors[] = 'You forgot to enter the location.';
    } else {
        $location = escape_data($_POST['location']);
    }
    if (empty($_POST['fromDate'])) {
        $errors[] = 'You forgot to enter from date.';
    } else {
        $fromDate = escape_data($_POST['fromDate']);
    }
    if (empty($_POST['toDate'])) {
        $errors[] = 'You forgot to enter to date.';
    } else {
        $toDate = escape_data($_POST['toDate']);
    }
    if (empty($_POST['description2'])) {
        $errors[] = 'You forgot to enter the description.';
    } else {
        $description2 = escape_data($_POST['description2']);
    }

    //check for skills 表
    if (empty($_POST['skills'])) {
        $errors[] = 'You forgot to enter the skills content.';
    } else {
        $skills = escape_data($_POST['skills']);
    }

    if (empty($_POST['summary'])) {
        $errors[] = 'You forgot to enter the summary.';
    } else {
        $summary = escape_data($_POST['summary']);
    }




    if (empty($errors)) { // If everything's OK.



        //插入数据到表格 profile
        $query6 = "UPDATE profile SET firstName='$f',lastName='$l',contactEmail='$e',phone='$phone',address='$addr',city='$city',state='$state',zipcode='$zip',country='$c',summary='$summary' WHERE profileID='$profileID'";
        $result6 = @mysql_query ($query6);
        $row6 = mysql_fetch_row($result6);
        $query7 = "UPDATE edu_background SET university='$school', degree='$degree',major='$major',activity='$activity',fromYear='$from',toYear='$to',description='$description' WHERE profileID='$profileID'";
        $result7 = mysql_query($query7);
        $query8 = "UPDATE experience SET title='$title',company='$company',location='$location',fromDate='$fromDate',toDate='$toDate',description='$description2'  WHERE profileID='$profileID'";
        $result8 = mysql_query($query8);
        $query9 = "UPDATE skills SET skillsContent='$skills' WHERE profileID='$profileID'";
        $result9 = mysql_query($query9);
        $word='Profile saved!';
        echo "<script> alert('{$word}') </script>";
$url = "view_user_profile_userside.php";
echo '<meta http-equiv="refresh" content="1;url='.$url.'">';

        if ($result7 ) { // If it ran OK.

            // Redirect the user to the thanks.php page.
            // Start defining the URL.
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

            // Check for a trailing slash.
            if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) {
                $url = substr ($url, 0, -1); // Chop off the slash.
            }


        } else { // If it did not run OK.
            $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
            if ($result7 == false)
                $errors[] = mysql_error() . '<br /><br />Query: ' . $query7; // Debugging message.

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



include ('./includes/header_after_login.php');

$query = "SELECT firstName, lastName,contactEmail,phone,address,city,state,zipcode,country,summary FROM profile WHERE profileID='$profileID'";
$result = @mysql_query ($query); // Run the query.
$row = mysql_fetch_row($result);
$query2 = "SELECT university, degree,major,activity,fromYear,toYear,description FROM edu_background WHERE profileID='$profileID'";
$result2 = @mysql_query ($query2); // Run the query.
$row2 = mysql_fetch_row($result2);
$query3 = "SELECT title,company,location,fromDate,toDate,description FROM experience WHERE profileID='$profileID'";
$result3 = @mysql_query ($query3); // Run the query.
$row3 = mysql_fetch_row($result3);
$query4 = "SELECT skillsContent FROM skills WHERE profileID='$profileID'";
$result4 = @mysql_query ($query4); // Run the query.
$row4 = mysql_fetch_row($result4);

echo' <FORM method="post" action="Editprofile_page.php?profileID='.$profileID.'">
    <div class="outsider">
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
                <label><strong>Email*</strong></label>
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
    <h3 ><Strong>Education Background</Strong></h3>
    <div class="grey">

        <div class="row">

            <label><strong>School*</strong></label>
            <input  type="text" id="school"  name="school" value=' . $row2[0] .'>
        </div>
        <div class="row">

            <label><strong>Degree*</strong></label>
            <input  type="text" id="degree"  name="degree" value=' . $row2[1] .'>
        </div>
        <div class="row">

            <label><strong>Major*</strong></label>
            <input  type="text" id="major"  name="major" value=' . $row2[2] .'>
        </div>
        <div class="row">

            <label><strong>Activities and societies*</strong></label>
            <input  type="text" id="activity"  name="activity" value=' . $row2[3] .'>
        </div>
        <div class="form-check form-check-inline">
            <div class="form-check">
                <label><strong>From Year*</strong></label>
                <input  type="text" id="fromYear"  name="fromYear" value=' . $row2[4] .'>

            </div>

            <div class="form-check">
                <label><strong>To Year(or expected)*</strong></label>
                <input  type="text" id="toYear"  name="toYear" value=' . $row2[5] .'>

            </div>
        </div>
        <div class="row">

            <label><strong>Description*</strong></label>
            <input  type="text" id="description"  name="description" value=' . $row2[6] .'>
        </div>

    </div>

    <h3 ><Strong>Experience</Strong></h3>

    <div class="grey">

        <div class="row">

            <label><strong>title*</strong></label>
            <input  type="text" id="title"  name="title" value=' . $row3[0] . '>
        </div>
        <div class="row">

            <label><strong>Company*</strong></label>
            <input  type="text" id="company"  name="company" value=' . $row3[1] . '>
        </div>
        <div class="row">

            <label><strong>Location*</strong></label>
            <input  type="text" id="location"  name="location" value=' . $row3[2] . '>
        </div>
        <div class="form-check form-check-inline">
            <div class="form-check">
                <label><strong>From Date*</strong></label>
                <input  type="text" id="fromDate"  name="fromDate" value=' . $row3[3] . '>

            </div>

            <div class="form-check">
                <label><strong>To Date*</strong></label>
                <input  type="text" id="toDate"  name="toDate" value=' . $row3[4] . '>

            </div>
        </div>
        <div class="row">

            <label><strong>Description*</strong></label>
            <input  type="text" id="description2"  name="description2" value=' . $row3[5] . '>
        </div>

    </div>
    <h3 ><Strong>Skills</Strong></h3>

    <div class="grey">

        <div class="row">

            <label><strong>skills*</strong></label>
            <input  type="text" id="skills"  name="skills" value=' . $row4[0] .'>
        </div>
    </div>
    <div class="grey">

        <div class="row">

            <label><strong>summary*</strong></label>
            <input  type="text" id="summary"  name="summary" value=' . $row[9] .'>
        </div>
    </div>
    </div>
        <div class="btn">

            <button class="btn btn-secondary btn-lg btn-block" type="submit" name="save" value="TRUE">Save</button>

        </div>
        </FORM>
';
mysql_close();
include ('./includes/footer.html');
?>

