<?php
//Author: Edgar Nakamura
session_start();
include("class/Site.php");
require 'connect.php';

if (isset($_POST['command']))
{
  if ($_POST['command'] = "Update")
  {
    $siteActive = $_POST['siteActive'];

    $site = new Site();
    $record = $site->ActivateDeactivate($db,$siteActive);
    if (!$record)
        echo "Processing error";
  }
}
else
{
  $site = new Site();
  $record = $site->checkSiteActive($db);
  $siteActive = $record;
  //print_r($record);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Run 4 Fun&mdash; Be Smart, Be Healthy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
	
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/table.css">
	<link rel="stylesheet" href="css/login.css">

	</head>
<body>
<div class="fh5co-loader"></div>
<div id="page">
		<header id="fh5co-header" class="fh5co-cover2" role="banner" style="background-image:url(images/img_bg_1.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		</header>
		<br><br>
		<h2>Site Configuration</h2>
    <form action="configsite.php" method="post" name="configsite">
    <div class="sign-up">
    <table class="fl-table">
        <thead>
        <tr>
            <th>Site Active</th>
        </tr>
        </thead>
        <tbody>
        <tr>		
            <td>
                <input type="text" class="sign-up-input" name="siteActive" id="siteActive" value=<?php echo $siteActive ?>>
            </td>
        </tr>
        <tbody>
    </table>
    <input type="submit" name="command" value="Update" class="sign-up-button">
    <br>
    <br>
    <a href="http://localhost:31337/site/index.php">Return to Index</a>
    </div>
  </form>
</body>
</html>
