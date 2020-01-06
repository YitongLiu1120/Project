<?php
/**
 * Created by PhpStorm.
 * User: yitongliu
 * Date: 11/26/18
 * Time: 6:03 PM
 */
$page_title = 'Schedule the interview';
if ( (isset($_GET['applicationID']))  ) {
    $applicationid = $_GET['applicationID'];
}
require_once ('./mysql_connect.php'); // Connect to the db.
?>
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
  echo '<FORM method="post" action="Scheduleinterview_rejected.php?applicationID='.$applicationid.'"> ';
?>


    <br>
    <div class="outsider"><h4>Schedule an Interview</h4>
        <div class="grey">
            <div class="container-fluid">
                <br>
                <div class="row">
                    <label><strong>Comments</strong></label>
                    <input  type="text" id="comments"  name="comments">
                </div>
            </div>
        </div>
        <div class="btn">

            <button class="btn btn-secondary btn-lg btn-block" type="submit" name="submitted">SAVE</button>
        </div>

    </div>
</FORM>
<?php

$result='Rejected';
$status='Decided';
if(isset($_POST["submitted"])){
    if (empty($_POST['comments'])) {
        $errors[] = 'You forgot to enter the comments.';
    } else {
        $comments = escape_data($_POST['comments']);
    }

    if(empty($errors)){

        $query4 = "INSERT INTO feedback (applicationID,result,comments) VALUES ('$applicationid','$result','$comments')";
        $result4 = @mysql_query ($query4);
        $queryFeed = "UPDATE application SET status = '$status' WHERE applicationID = '$applicationid'";
        $resultFeed =  @mysql_query ($queryFeed);
        if ($result4 == false) {
            echo $errors[] = mysql_error() . '<br /><br />Query: ' . $query4; // Debugging message.
        }else echo"Insert successfully";
    }
    else{
        echo '<h1 id="mainhead">Error!</h1>
	         <p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p>';}

}

?>

