<?php
session_start();
include("class/Workout.php");
require 'connect.php';

$workout = new Workout();
$workoutid = "";
$dateCreated = "";
$duration = "";
$distance = "";
$imageFileName = "";
$button_value = "Awesome!";

if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$name = $_SESSION['name'];
	if (isset($_POST['workoutid']))
	{
		$workoutid = $_POST['workoutid'];
		$record = $workout->list($db,$workoutid);
 
		if (isset($record))
		{
			foreach($record as $workoutreg)
			{
				$dateCreated = $workoutreg['dateCreated'];
				$distance = $workoutreg['distance'];
				$duration = $workoutreg['duration'];
				$calories = $workoutreg['calories'];
				$imageFileName = $workoutreg['image'];
				$imageFileName = substr($imageFileName,21);
			}
		}
		else 
		{
			$error_occured = "<br><h2 class=sign-up-titl>Hmm, something wrong happened. Please try again.</h2>";
		}
		$button_value = "Fix it!";	
	}
	if (isset($_POST['command']))
	{
		if ($_POST['command'] != 'Edit') {
			$userid = $_SESSION['user'];
			$weight = $_SESSION['weight'];
	
			$dateCreated = preg_replace("([^0-9/])", "", $_POST['dateCreated']);
			$dateCreated = date("Y-m-d", strtotime($dateCreated));
			$duration = $_POST['duration'];
			$distance = filter_input(INPUT_POST, 'distance', FILTER_SANITIZE_NUMBER_INT);
			$workoutid = $_POST['workoutid'];

			$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
			if ($image_upload_detected)
			{
				$imageFileName = $workout->uploadFile($_FILES);
			}
			else {
				$imageFileName = "noimage";
			}
	
			if ($_POST['command'] == 'Awesome!')
			{	
				$result = $workout->create($db,$userid,$dateCreated,$duration,$distance,$weight,$imageFileName);	
			}
			elseif ($_POST['command'] == 'Fix')
			{
				$result = $workout->save($db,$workoutid,$userid,$dateCreated,$duration,$distance,$weight,$imageFileName);	
			}
			else if (($_POST['command'] == "Delete"))
            {
				$result = $workout->delete($db,$workoutid);
            }
			header("Location: http://localhost:31337/site/index.php");
		}
	}
}
else 
{
	header("Location: http://localhost:31337/site/login.php");
}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Run 4 Fun&mdash; Be Smart, Be Healthy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/login.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>

	</head>
	<body>
		
		<div class="fh5co-loader"></div>
		<div id="page">
			<nav class="fh5co-nav" role="navigation">
				<div class="top-menu">
					<div class="container">
						<div class="row">
							<div class="col-xs-2"><div id="fh5co-logo"><a href="index.php">Run4Fun<span>.</span></a></div></div>
							<div class="col-xs-10 text-right menu-1">
								<ul>
									<!-- <li class="active"><a href="index.html">Home</a></li> -->
									<li><a href="about.php">About</a></li>
									<li class="has-dropdown">
										<a href="#">Workouts</a>
										<ul class="dropdown">
											<li><a href="work.php">Log Workout</a></li>
											<li><a href="history.php">History</a></li>
											<li><a href="#">Milestones</a></li>
										</ul>
									</li>
									<li><a href="contact.php">Contact</a></li>
									<?php if ($user === "") : ?> 
										<li class=btn-cta><a href=login.php><span>Login</span></a></li>
										<li class=btn-cta><a href=signup.html><span>Sign Up</span></a></li>
									<?php else : ?>
										<li class=btn-cta><span>Hi! <?= $name ?> </span></li>
										<li class=btn-cta><a href=logout.php><span>Log out</span></a></li>
									<?php endif ?>
								</ul>
							</div>
						</div>
						
					</div>
				</div>
			</nav>
			<header id="fh5co-header" class="fh5co-cover" role="banner" style="background-image:url(images/img_bg_1.jpg);" data-stellar-background-ratio="0.5">
				<div class="overlay"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="display-t2">
								<form class="sign-up" action="work.php" method="post" enctype="multipart/form-data">
									<h1 class="sign-up-text">Yay!! Let's record your workout!</h1>
									<input type="hidden" name="workoutid" id="workoutid" value=<?= $workoutid ?>>
									<label>Date:</label><input type="date" class="sign-up-input" placeholder="date" name="dateCreated" id="dateCreated" value=<?= $dateCreated ?>>
									<label>Duration:</label><input type="text" class="sign-up-input" placeholder="hh:mm" name="duration" id="duration" value=<?= $duration ?>>
									<label>Distance:</label><input type="text" class="sign-up-input" placeholder="kilometers" name="distance" id="distance" value=<?= $distance ?>>
									<?php if ($imageFileName != '') : ?>
										<img src=<?php echo $imageFileName; ?> name=imageview id=imageview height=200 width=200/><br>
										<label>Delete Image:</label><input type="checkbox" name="deleteImage" id="deleteImage"><br>
									<?php endif ?>
									<label>Selfie:</label><input type="file" class="sign-up-input" name="image" id="image">
									<input type="submit" name="command" value=<?php echo $button_value; ?> class="sign-up-button">
								</form>
							</div>
						</div>
					</div>
				</div>
			</header>			
			<footer id="fh5co-footer" role="contentinfo">
				<div class="container">
					<div class="row copyright">
						<div class="col-md-12 text-center">
							<p>
								<small class="block">Designed by Run4Fun.</small>
							</p>
							<p>
								<ul class="fh5co-social-icons">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-facebook"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-dribbble"></i></a></li>
								</ul>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<div class="gototop js-top"><a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a></div>
		
		<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<!-- jQuery Easing -->
		<script src="js/jquery.easing.1.3.js"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Waypoints -->
		<script src="js/jquery.waypoints.min.js"></script>
		<!-- Stellar Parallax -->
		<script src="js/jquery.stellar.min.js"></script>
		<!-- Carousel -->
		<script src="js/owl.carousel.min.js"></script>
		<!-- Main -->
		<script src="js/main.js"></script>
	</body>
</html>

