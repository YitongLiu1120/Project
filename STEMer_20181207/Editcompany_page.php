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
$companyAccountID=$_SESSION["companyID"];
if (isset($_POST['submitted'])) {

     // Connect to the db.

    $errors = array(); // Initialize error array.

    if (empty($_POST['name'])) {
        $errors[] = 'You forgot to enter the name.';
    } else {
        $name = escape_data($_POST['name']);
    }

    if (empty($_POST['address'])) {
        $errors[] = 'You forgot to enter the address.';
    } else {
        $address = escape_data($_POST['address']);
    }
    if (empty($_POST['city'])) {
        $errors[] = 'You forgot to enter the city.';
    } else {
        $city = escape_data($_POST['city']);
    }
    if (empty($_POST['state'])) {
        $errors[] = 'You forgot to enter the states.';
    } else {
        $state = escape_data($_POST['state']);
    }
    if (empty($_POST['country'])) {
        $errors[] = 'You forgot to enter the country.';
    } else {
        $country = escape_data($_POST['country']);
    }
    if (empty($_POST['zipcode'])) {
        $errors[] = 'You forgot to enter the zip code.';
    } else {
        $zipcode = escape_data($_POST['zipcode']);
    }
    if (empty($_POST['year'])) {
        $errors[] = 'You forgot to enter the founded year.';
    } else {
        $year = escape_data($_POST['year']);
    }
    if (empty($_POST['industry'])) {
        $errors[] = 'You forgot to enter the industry.';
    } else {
        $industry = escape_data($_POST['industry']);
    }
    if (empty($_POST['des'])) {
        $errors[] = 'You forgot to enter the description.';
    } else {
        $des = escape_data($_POST['des']);
    }
    if (empty($_POST['website'])) {
        $errors[] = 'You forgot to enter the website.';
    } else {
        $website = escape_data($_POST['website']);
    }





    if (empty($errors)) { // If everything's OK.



        //插入数据到表格 profile
        $query2 = "UPDATE company SET name='$name',address='$address',city='$city',state='$state',zipcode='$zipcode',country='$country',foundYear='$year',industry='$industry',description='$des',websiteAddr='$website' where companyID='$companyAccountID'";
        $result2 = @mysql_query ($query2); // Run the query2, return TRUE if success, FALSE if failed.
        $word='Information saved!';
        echo "<script> alert('{$word}') </script>";
        $url = "view_company_companyside.php";
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

$query="SELECT name,address,city,state,zipcode,country,foundYear,industry,description,websiteAddr FROM company WHERE companyID='$companyAccountID'";
$result = @mysql_query ($query); // Run the query.
$row = mysql_fetch_row($result);

echo'
<FORM method="post" action="Editcompany_page.php">
    <div class="outsider">
        <h4 ><Strong>Company Information</Strong></h4>

        <div class="grey">
            <h1> <br></h1>
            <div class="row">
                <label><strong>Name*</strong></label>
                <input  type="text" id="name"  name="name" value=' . $row[0] . '>
            </div>
            <div class="row">
                <label><strong>Address*</strong></label>
                <input  type="text" id="address"  name="address" value=' . $row[1] . '>
            </div>
            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>City*</strong></label>
                    <input  type="text" id="city"  name="city" value=' . $row[2] . '>

                </div>

                <div class="form-check">
                    <label><strong>State*</strong></label>
                    <input  type="text" id="state"  name="state" value=' . $row[3] . '>

                </div>
            </div>
            <div class="form-check form-check-inline">
                <div class="form-check">
                    <label><strong>Country*</strong></label>
                    <input  type="text" id="country"  name="country" value=' . $row[5] . '>

                </div>

                <div class="form-check">
                    <label><strong>Zip Code*</strong></label>
                    <input  type="text" id="zipcode"  name="zipcode" value=' . $row[4] . '>

                </div>
            </div>
            <div class="row">
                <label><strong>Founded Year*</strong></label>
                <input  type="text" id="year"  name="year" value=' . $row[6] . '>
            </div>
            <div class="row">
                <label><strong>Industry*</strong></label>
                <input  type="text" id="industry"  name="industry" value=' . $row[7] . '>
            </div>
            <div class="row">
                <label><strong>Description*</strong></label>
                <input  type="text" id="des"  name="des" value=' . $row[8] . '>
            </div>
            <div class="row">
                <label><strong>Website Address*</strong></label>
                <input  type="text" id="website"  name="website" value=' . $row[9] . '>
            </div>

        </div>
    </div>
    <div class="btn">

        <button class="btn btn-secondary btn-lg btn-block" type="submit" name="submitted">Save</button>
    </div>
</FORM>
';
mysql_close();
include ('./includes/footer.html');
?>

