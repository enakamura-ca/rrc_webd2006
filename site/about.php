<?php
session_start();

if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$name = $_SESSION['name'];
}
else 
{
	$user = "";
	$name = "";	
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

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
		
	<div class="fh5co-loader"></div>
	
	<div id="page">
	<nav class="fh5co-nav" role="navigation">
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-2">
						<div id="fh5co-logo"><a href="index.php">Run4Fun<span>.</span></a></div>
					</div>
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

	<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url(images/img_bg_2.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="display-t">
						<div class="display-tc animate-box" data-animate-effect="fadeIn">
							<h1>About Us</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<div id="fh5co-about">
		<div class="container">
			<div class="about-content">
				<div class="row animate-box">
					<div class="col-md-6 col-md-push-6">
						<img class="img-responsive" src="images/img_bg_1.jpg" alt="about">
					</div>
					<div class="col-md-6 col-md-pull-6">
						<div class="desc">
							<h3>Company</h3>
							<p>Thinking about the increasing number of people looking for a healthy life, we founded the Run For Fun to help people to get access to tools used by athletes with a nice interface and usability</p>
							<p>Running an activity very popular, cheaper and accessible to mostly of people. Our company saw an opportunity to enter into this marketing creating an application to track the performance of the workouts easily and providing reports using a motivational approach.</p>
						</div>
						<div class="desc">
							<h3>Mission &amp; Vission</h3>
							<p>Make the sport accessible to everyone.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<h2>Meet Our Team</h2>
					<p>Edgar Nakamura - CEO and Finance Diretor</p>
					<p>Joca Silvestein - IT Diretor</p>
					<p>Stella Nice - Marketing Diretor</p>
					<p>Lady Murphy - Customer Service Manager</p>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-started">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<h2>Lets Get Started</h2>
					<p>Click Sign Up and tell us a little about you.</p>
				</div>
			</div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center">
					<p><a href="signup.html" class="btn btn-default btn-lg">Sign Up</a></p>
				</div>
			</div>
		</div>
	</div>
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

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
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

