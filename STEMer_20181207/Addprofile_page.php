
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
            padding-top: 15px;
            font-size: 20px;
            font-family: Helvetica;

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

$page_title = 'Add the profile';


$ID=$_SESSION["userID"] ;
$profileID=$_SESSION["profileID"];



if (isset($_POST['save'])) {
    require_once ('mysql_connect.php'); // Connect to the db.

    $errors = array(); // Initialize error array.

    // Check for profile表
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
    //check for summary table
    if (empty($_POST['summary'])) {
        $errors[] = 'You forgot to enter the summary content.';
    } else {
        $summary = escape_data($_POST['summary']);
    }






    if (empty($errors)) { // If everything's OK.

        // Register the user in the database.

        // Check for previous registration.
//        $query1 = "SELECT userID FROM user_account WHERE email='$e' ";
//        $result1 = mysql_query($query1);
//        if (mysql_num_rows($result1) == 0)
        { // Email address doesn't exist.
            // Make the query.



            echo "<script> alert('{$ID}') </script>";
            //插入数据到表格 profile
            $query2 = "UPDATE profile SET firstName='$f',lastName='$l',contactEmail='$e',phone='$phone',address='$addr',city='$city',state='$state',zipcode='$zip',country='$c',summary='$summary' WHERE profileID='$profileID'";
            $result2 = @mysql_query ($query2); // Run the query2, return TRUE if success, FALSE if failed.
            //插入数据到表格 edu_background
            $query4 = "INSERT INTO edu_background (profileID,university,degree,major,activity,fromYear,toYear,description) VALUES ('$profileID', '$school', '$degree', '$major', '$activity', '$from', '$to', '$description')";
            $result4 = @mysql_query ($query4); // Run the query2, return TRUE if success, FALSE if failed.

            //插入数据到表格 experience
            $query5 = "INSERT INTO experience (profileID,title,company,location,fromDate,toDate,description) VALUES ('$profileID', '$title', '$company', '$location', '$fromDate', '$toDate','$description2')";
            $result5 = @mysql_query ($query5); // Run the query2, return TRUE if success, FALSE if failed.

            //插入数据到表格 skills
            $query6 = "INSERT INTO skills (profileID,skillsContent) VALUES ('$profileID', '$skills')";
            $result6 = @mysql_query ($query6); // Run the query2, return TRUE if success, FALSE if failed.

            $word='Profile saved!';
            echo "<script> alert('{$word}') </script>";
            $url = "view_user_profile_userside.php";
            echo '<meta http-equiv="refresh" content="1;url='.$url.'">';
            if ($result5 ) { // If it ran OK.

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
                if ($result5 == false)
                    $errors[] = mysql_error() . '<br /><br />Query: ' . $query5; // Debugging message.

            }

        }
//        else { // Email address is already taken.
//            $errors[] = 'The email address has already been registered.';
//        }

    } // End of if (empty($errors)) IF.

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


    <FORM method="post" action="Addprofile_page.php">
        <h1 class="header2"><Strong>Add Profile</Strong></h1>

        <div class="grey">
            <h1> <br></h1>




            <div class="container-fluid">
                <div class="form-check form-check-inline">
                    <div class="form-check">
                        <label><strong>First Name*</strong></label>
                        <input  type="text" id="first_name"  name="first_name">

                    </div>

                    <div class="form-check">
                        <label><strong>Last Name*</strong></label>
                        <input  type="text" id="last_name"  name="last_name">

                    </div>
                </div>
                <div class="row">
                    <label><strong>Email*</strong></label>
                    <input  type="text" id="email"  name="email">
                </div>
                <div class="row">
                    <label><strong>Phone*</strong></label>
                    <input  type="text" id="last_name"  name="phone">
                </div>
                <div class="row">
                    <label><strong>Address*</strong></label>
                    <input  type="text" id="address"  name="address">
                </div>

                <div class="form-check form-check-inline">
                    <div class="form-check">
                        <label><strong>City*</strong></label>
                        <input  type="text" id="city"  name="city">

                    </div>

                    <div class="form-check">
                        <label><strong>State*</strong></label>
                        <input  type="text" id="state"  name="state"></div>
                    <div class="form-check">
                        <label><strong>Zip Code*</strong></label>
                        <input  type="text" id="zipcode"  name="zipcode">


                    </div>
                </div>
                <div class="row">
                    <label><strong>Country*</strong></label>
                    <input  type="text" id="country"  name="country">
                </div>






            </div>
        </div>
        <h3 ><Strong>Education Background</Strong></h3>
        <div class="grey">

            <div class="row">

                <label><strong>School*</strong></label>
                <input  type="text" id="school"  name="school">
            </div>
            <div class="row">

                <label><strong>Degree*</strong></label>
                <input  type="text" id="degree"  name="degree">
            </div>
            <div class="row">

                <label><strong>Major*</strong></label>
                <input  type="text" id="major"  name="major">
            </div>
            <div class="row">

                <label><strong>Activities and societies*</strong></label>
                <input  type="text" id="activity"  name="activity">
            </div>
            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>From Year*</strong></label>
                    <input  type="text" id="fromYear"  name="fromYear">

                </div>

                <div class="form-check">
                    <label><strong>To Year(or expected)*</strong></label>
                    <input  type="text" id="toYear"  name="toYear">

                </div>
            </div>
            <div class="row">

                <label><strong>Description*</strong></label>
                <input  type="text" id="description"  name="description">
            </div>

        </div>

        <h3 ><Strong>Experience</Strong></h3>

        <div class="grey">

            <div class="row">

                <label><strong>title*</strong></label>
                <input  type="text" id="title"  name="title">
            </div>
            <div class="row">

                <label><strong>Company*</strong></label>
                <input  type="text" id="company"  name="company">
            </div>
            <div class="row">

                <label><strong>Location*</strong></label>
                <input  type="text" id="location"  name="location">
            </div>
            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>From Date*</strong></label>
                    <input  type="text" id="fromDate"  name="fromDate">

                </div>

                <div class="form-check">
                    <label><strong>To Date*</strong></label>
                    <input  type="text" id="toDate"  name="toDate">

                </div>
            </div>
            <div class="row">

                <label><strong>Description*</strong></label>
                <input  type="text" id="description2"  name="description2">
            </div>

        </div>
        <h3 ><Strong>Skills</Strong></h3>

        <div class="grey">

            <div class="row">

                <label><strong>skills*</strong></label>
                <input  type="text" id="skills"  name="skills">
            </div>

        </div>
        <div class="grey">
            <div class="row">

                <label><strong>summary*</strong></label>
                <input  type="text" id="summary"  name="summary">
            </div>
        </div>
        <div class="btn">

            <button class="btn btn-secondary btn-lg btn-block" type="submit" name="save">Submit</button>
        </div>

    </FORM>
<!--    <div class="grey">-->
<!--        <form action="uploadHandler.php" method="post" enctype="multipart/form-data">-->
<!--            Upload Img:<input type="file" name="img"/>-->
<!--            <input type="submit" value="Upload"/>-->
<!--        </form>-->
<!--    </div>-->
<?php
include ('./includes/footer.html');
?>