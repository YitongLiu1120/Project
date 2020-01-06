<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

    .grey {
        background-color: #E4E4E4;
        margin-left: 20%;
        margin-right: 20%;
        margin-top: 15%;
        margin-bottom: 20%;
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
    p{
        font-size: 20px;
        font-family: Helvetica;
        padding-left: 30px;
    }
    .row{
        padding-left: 100px;
        padding-right: 100px;
        padding-top: 10px;


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
        padding-top: 30px;
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

if (isset($_POST['submitted'])) {

    require_once ('mysql_connect.php'); // Connect to the db.

    $errors = array(); // Initialize error array.

    // Check for a first name.
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email.';
    } else {
        $e = escape_data($_POST['email']);
    }

    // Check for a last name.
    if (!empty($_POST['password1'])) {
        if ($_POST['password1'] != $_POST['password2']) {
            $errors[] = 'Your password did not match the confirmed password.';
        } else {
            $p = escape_data($_POST['password1']);
        }
    } else {
        $errors[] = 'You forgot to enter your password.';
    }


    // Check for an email address.
    if (empty($_POST['Individual'])&&empty($_POST['Company'])) {
        $errors[] = 'You forgot to select your account type.';
    } else {
        if($_POST['Individual'])
            $type = escape_data($_POST['Individual']);
        else if($_POST['Company'])
            $type = escape_data($_POST['Company']);
    }
    if(empty($_POST['agreement'])){
        $errors[] = 'You need to agree to our policy';

    }



    if (empty($errors)) { // If everything's OK.

        // Register the user in the database.

        // Check for previous registration.

        $query1 = "SELECT userID FROM user_account WHERE email='$e' ";
        $result1 = mysql_query($query1);

        if (!$result1 or mysql_num_rows($result1) == 0) { // Email address doesn't exist.
            //User can register
            // Make the query.
            $query2 = "INSERT INTO user_account (email,password,accountType) VALUES ('$e', SHA('$p'), '$type' )";
            $result2 = @mysql_query ($query2); // Run the query2, return TRUE if success, FALSE if failed.
            $query4 = "SELECT accountType FROM user_account WHERE email='$e' ";
            $result4 = mysql_query($query4);
            $accountType=mysql_fetch_row($result4);
            if($accountType[0]=='Individual') {
                $query3 = "SELECT userID FROM user_account WHERE email='$e' ";
                $result3 = mysql_query($query3);
                $id = mysql_fetch_row($result3);
                $ID = $id[0];
                $path="images/portrait_user.png";
                $query5 = "INSERT INTO profile (userID,portraitPath) VALUES ('$ID' ,'$path') ";
                $result5 = mysql_query($query5);
                if ($result5 == true) {
                    echo '<h1 id="mainhead">Insert Successfully</h1>';
                    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=Login_page.php">';

                } else $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
            }
            if($accountType[0]=='Company'){
                $query6 = "SELECT userID FROM user_account WHERE email='$e' ";
                $result6 = mysql_query($query6);
                $id = mysql_fetch_row($result6);
                $ID = $id[0];
                $path="images/company_logo1.png";
                $query7 = "INSERT INTO company(accountID,logoPath) VALUES ('$ID','$path') ";
                $result7= mysql_query($query7);
                if ($result7 == true) {
                    echo '<h1 id="mainhead">Insert Successfully</h1>';
                    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=Login_page.php">';

                } else $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
            }





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

        } else { // Email address is already taken.
            $errors[] = 'The email address has already been registered.';
        }

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

<FORM method="post" action="Signup_page.php">
    <div class="grey">
        <h1> <br></h1>
        <div class="white">
            <h2 class="header1">Find your own definition of success with help from professional STEM community</h2>
        </div>

        <h1 class="header2"><Strong>Get started with your account</Strong></h1>
        <div class="container-fluid">

            <!-- Checkboxes -->
            <div class="form-check form-check-inline">
            <p>Please select your account type:</p>
            </div>
            <div class="form-check form-check-inline">

                <input class="form-check-input" type="checkbox" id="IndividualCheckbox" value="Individual" name="Individual">
                <label class="form-check-label"><strong>Individual</strong></label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="CompanyCheckbox" value="Company" name="Company">
                <label class="form-check-label"><strong>Company</strong></label>

            </div>
        <div class="row">
            <label class="mr-sm-2 mb-0" for="Email"><strong>Email Address:</strong></label>
            <input type="email" class="form-control mr-sm-2 mb-2 mb-sm-0" id="Email" name="email" placeholder="Email Address">
        </div>
        <div class="row">
            <label class="mr-sm-2 mb-0" for="Password1"><strong>Password:</strong></label>
            <input type="password" class="form-control mr-sm-2 mb-2 mb-sm-0" id="Password1" name="password1" placeholder="Password">
        </div>
            <div class="row">
                <label class="mr-sm-2 mb-0" for="Password2"><strong>Confirmed Password:</strong></label>
                <input type="password" class="form-control mr-sm-2 mb-2 mb-sm-0" id="Password2" name="password2" placeholder="Confirmed Password">
            </div>
        <input  class="agreement" type="checkbox" id="agreement" name="agreement">
            <label ><strong>I agree to STEMer <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</strong></label>
            <div class="btn">

                <button class="btn btn-secondary btn-lg btn-block" type="submit" name="submitted">Sign Up</button>
            </div>

        </div>
    </div>
</FORM>