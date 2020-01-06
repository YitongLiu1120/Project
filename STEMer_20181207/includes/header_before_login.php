<?php # Script 3.4 - header_before_login.php
if(isset($_POST['submitted'])) {
	$position= $_POST['position'];
	$url = 'Job_page.php?title='.$position;
	header("Location: $url");
	exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>STEMer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://cdn.bootcss.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-expand-sm navbar-light fixed-top" style="background-color: #1D2731;">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="index.php" >
		<img src="images\logo_STEMer.png" class="float-left" style="width:60px;" alt="avatar">
	</a>
	<div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="index.php" id="navbardrop" data-toggle="dropdown" style="color: white;">
        Home
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="index.php#section1" >Recent Published Positions</a>
        <a class="dropdown-item" href="index.php#section2">Popular Companies</a>
      </div>
    </li> 
      <li class="nav-item">
        <a class="nav-link" href="Login_page.php" style="color: white;">Log in/Sign up</a>
      </li> 
    </ul>
	              
  </div>  
</nav>

<form action="index.php" method="post">
<div class="form-row" style="margin-top:86px;background-color:black;padding:10px;">
     <div class="input-group col-10 ml-5 mt-1 mb-1">
        <input type="text" name="position" class="form-control" placeholder="Search Position" aria-label="Search term" aria-describedby="basic-addon">
     </div>
     
     <div>
		<input type="submit" class="btn btn-dark col-xs-2 mt-1 mb-1 ml-5" value="Search"/>
		<input type="hidden" name="submitted" value="TRUE" />
     </div>
</div>
</form>

