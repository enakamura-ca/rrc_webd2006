<?php
require 'connect.php';
include("class/Users.php");
session_start();

$error_occured = "";

if ($_POST)
{
  $email = $_POST['email'];
  $password = $_POST['password'];

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

  $user = new Users();

  $result = $user->checkUser($db, $email, $password);

  if (!is_array($result))
  {
    $error_occured = "<br><h2 class=sign-up-title>Account Inactive.</h2>";
  }
  else
  {

    $_SESSION['user'] = $result[0];
    $_SESSION['name'] = $result[1];
    $_SESSION['weight'] = $result[2];
    $_SESSION['usertype'] = $result[3];
    //echo print_r($_SESSION);

    header("Location: http://localhost:31337/site/index.php");
  }
  $db = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Run 4 Fun&mdash; Be Smart, Be Healthy</title>
  <link rel="stylesheet" href="css/login.css">	

</head>
<body> 
  <form class="sign-up" action="login.php" method="post">
    <h1 class="sign-up-title">Welcome back!</h1>
    <input type="text" class="sign-up-input" placeholder="email" name="email" id="email" autofocus>
    <input type="password" class="sign-up-input" placeholder="Password" name="password" id="password">
    <input type="submit" value="Let's do it!" class="sign-up-button">
    <?php echo $error_occured ?>
  </form>
</body>
</html>
