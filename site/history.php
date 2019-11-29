<?php
session_start();

require 'connect.php';

$error_occured = "";

if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$name = $_SESSION['name'];

	if (isset($_POST['sort']))
	{
		if ($_POST['sort'] == 'date')
		{
			$query = "SELECT * FROM workouts WHERE userid = :user ORDER BY dateCreated DESC";
			$sort = "Date";
		}
		if ($_POST['sort'] == 'distance')
		{
			$query = "SELECT * FROM workouts WHERE userid = :user ORDER BY distance DESC";
			$sort = "Distance";
		}
		if ($_POST['sort'] == 'duration')
		{
			$query = "SELECT * FROM workouts WHERE userid = :user ORDER BY duration DESC";
			$sort = "Duration";
		}
	}
	else
	{
		$query = "SELECT * FROM workouts WHERE userid = :user ORDER BY dateCreated";
		$sort = "Date";
	}

	$statement = $db->prepare($query);
	$statement->bindValue(':user', $user,PDO::PARAM_STR);
	$statement->execute();

	$rowcount = $statement->rowCount(); 
	if ($rowcount > 0)
	{
		$record = $statement->fetchAll();
	}
	else 
	{
		$error_occured = "<br><h2 class=sign-up-titl>Hmm, something wrong happened. Please try again.</h2>";
		$db = null;	  
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
	<link rel="stylesheet" href="css/table.css">

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
		<header id="fh5co-header" class="fh5co-cover2" role="banner" style="background-image:url(images/img_bg_1.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		</header>
		<br><br>
		<h2>Your workout</h2>
		<h2>Sorting by <?= $sort ?></h2>
		<div class="table-wrapper">
			<table class="fl-table">
				<thead>
				<tr>
					<th><a href="#" onclick="sort('date');">Date</a></th>
					<th><a href="#" onclick="sort('distance');">Distance</a></th>
					<th><a href="#" onclick="sort('duration');">Duration</a></th>
					<th>Calories</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<form name="workout" action="work.php" method="post">
				<?php
				if ($error_occured == "")
					{
						foreach($record as $workout)
						{
							echo "<tr>";		
							echo "<td>".$workout['dateCreated']."</td>";
							echo "<td>".$workout['distance']."</td>";
							echo "<td>".$workout['duration']."</td>";
							echo "<td>".$workout['calories']."</td>"; 
							echo "<td><input type=button onclick=submitEdit('" . $workout['workoutId'] . "') value=Edit></td>"; 
							echo "<td><input type=button onclick=submitDelete('" . $workout['workoutId'] . "') value=Delete></td>"; 
							echo "</tr>";
						}
						$db = null;	  
					}
					else
					{
						echo $error_occured;
					}
					?>
				<input type="hidden" name="command" id="command">
				<input type="hidden" name="sort" id="sort">
				<input type="hidden" name="workoutid" id="workoutid">
				</form>
				<tbody>
			</table>
		</div>
<script>
	function submitDelete(id)
	{
		document.getElementById("command").value = "Delete";
		document.getElementById("workoutid").value = id;
		document.workout.action = "process_post.php";
		document.workout.submit();
	};

	function submitEdit(id)
	{
		document.getElementById("command").value = "Edit";
		document.getElementById("workoutid").value = id;
		document.workout.action = "work.php";
		document.workout.submit();
	};

	function sort(field)
	{
		document.getElementById("sort").value = field;
		document.workout.action = "history.php";
		document.workout.submit();
	}

</script>
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

