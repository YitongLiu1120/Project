<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

    .grey {
        background-color: #E4E4E4;
        margin-left: 30%;
        margin-right: 30%;
        margin-top: 15%;
        margin-bottom: 20%;
    }
    .header{
        padding-top: 40px;
        margin-left: 40%;
        font-size: 30px;
        font-family: Arial;

    }
    .row{
        padding-left: 100px;
        padding-right: 100px;
        padding-top: 30px;

    }
    #Email{
        font-size: 20px;
        font-family: Helvetica;

    }
    #Password{
        font-size: 20px;
        font-family: Helvetica;

    }
    .form-check-inline{
        margin-left: 70px;
        padding-right:10px;
        padding-top: 30px;
        font-size: 20px;
        font-family: Arial;

    }
    .pull-right{
        margin-left: 260px;
        padding-top: 20px;
    }
    .btn-secondary{
        margin-bottom:20px;
        margin-top:15px;
    }

    h5{
        text-align: center;
    }
</style>
<?php
session_start();
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
    if (empty($_POST['password'])) {
        $errors[] = 'You forgot to enter your password';
    } else {
        $p = escape_data($_POST['password']);
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



    if (empty($errors)) { // If everything's OK.

        // Register the user in the database.

        // Check for previous registration.
        $query1 = "SELECT userID FROM user_account WHERE email='$e' ";
        $result1 = mysql_query($query1);
        $id=mysql_fetch_row($result1);
        $ID=$id[0];



        if (mysql_num_rows($result1) != 0) { // Email address  exists.
            // Make the query.
            $query2 = "SELECT password FROM user_account  WHERE email='$e' ";

            $result2 = @mysql_query ($query2); // Run the query2, return TRUE if success, FALSE if failed.
            $password=mysql_fetch_row($result2);
            echo $password[0];
            if($password[0]!=$p){
                echo '<h1 id="mainhead">Wrong Password</h1>';
            }
            $query3 = "SELECT accountType FROM user_account  WHERE email='$e' ";
            $result3 = @mysql_query ($query3); // Run the query2, return TRUE if success, FALSE if failed.
            $accounttype=mysql_fetch_row($result3);
            echo $accounttype[0];
            if($accounttype[0]!=$type){
                echo '<h1 id="mainhead">Wrong Account Type</h1>';

            }

            if($password[0]==SHA('$p')) {
                if ($accounttype[0] == $type) {
                    echo '<h1 id="mainhead">Log In Successfully</h1>';
                    $query4 = "SELECT profileID FROM profile WHERE userID=$ID ";
                    $result4 = mysql_query($query4);
                    $profile=mysql_fetch_row($result4);
                    $profileID=$profile[0];
                    $query5 = "SELECT companyID FROM company WHERE accountID=$ID ";
                    $result5 = mysql_query($query5);
                    $company=mysql_fetch_row($result5);
                    $companyID=$company[0];
                    if($type=="Individual"){
                    $_SESSION["userID"] = $ID;
                    $_SESSION["profileID"] =$profileID;
                        echo "Session variables are set.";
                        echo $profileID;
                        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';}
                    if($type=="Company"){
                        $_SESSION["userID"] = $ID;
                        $_SESSION["companyID"] =$companyID;
                        echo "Session variables are set.";
                        echo $companyID;
                        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=list_positions_companyside.php">';

                    }




                }
            }
//            $query4 = "SELECT * FROM profile  WHERE userID='$ID'";
//            $result4 = mysql_query($query4);
//            $number=mysql_num_rows($result4);
//            if($number == 0)
//            {
//
//                $query5="INSERT INTO profile (userID) VALUES ('$ID' ) ";
//                $result5 = mysql_query($query5);
//                if($result5==true){
//                    echo '<h1 id="mainhead">Insert Successfully</h1>';
//                    echo '<h1 id="mainhead">Null</h1>';
//
//                }
//                else $errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
//
//
//            }

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
            $errors[] = 'This email address has not been registered.';
            echo '<p>Please sign up.</p>';
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

<FORM method="post" action="Login_page.php">
<div class="grey">
    <h1 class="header"><Strong>Sign In</Strong></h1>
    <div class="row">
        <label class="mr-sm-2 mb-0 sr-only" for="Email">Email Address</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="Email" name="email" placeholder="Email Address">
    </div>
    <div class="row">
        <label class="mr-sm-2 mb-0 sr-only" for="Password">Password</label>
        <input type="password" class="form-control mr-sm-2 mb-2 mb-sm-0" id="Password" name="password" placeholder="Password">
    </div>
    <div class="container-fluid">

        <!-- Checkboxes -->
        <div class="form-check form-check-inline">

            <input class="form-check-input" type="checkbox" id="IndividualCheckbox" value="Individual" name="Individual">
            <label class="form-check-label"><strong>Individual</strong></label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="CompanyCheckbox" value="Company" name="Company">
            <label class="form-check-label"><strong>Company</strong></label>

        </div>

        <span class="pull-right"> <a href="#">Forgot Password?</a></span>
        <button class="btn btn-secondary btn-lg btn-block" type="submit" name="submitted" value="TRUE">Log In</button>
        <h5> OR</h5>
        <a type="button" class="btn btn-secondary btn-lg btn-block"  href="Signup_page.php">Sign Up</a>
<!--            <a type="button" class="btn btn-outline-danger" href="Signup_page.php ">Sign up</a >-->
        <br>


    </div>
</div>
</FORM>