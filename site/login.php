<?php
require 'connect.php';
session_start();

$error_occured = "";

if ($_POST)
{
  $email = $_POST['email'];
  $password = $_POST['password'];

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

  $query = "SELECT * FROM users WHERE email = :email";
  $statement = $db->prepare($query);
  $statement->bindValue(':email', $email,PDO::PARAM_STR);
  $statement->execute();

  $rowcount = $statement->rowCount(); 
  if ($rowcount > 0)
  {
    $record = $statement->fetch();
    if ($record['password'] !== $password)
    {
      $error_occured = "<br><h2 class=sign-up-title>Hmm, something wrong with your password. Try again.</h2>";
    }
    else
    {
      $_SESSION['user'] = $record['userId'];
      $_SESSION['name'] = $record['firstName'];
      $_SESSION['weight'] = $record['weight'];
      $_SESSION['usertype'] = $record['userType'];
      //echo print_r($_SESSION);

      header("Location: http://localhost:31337/site/index.php");
    }
  }
  else 
  {
    $error_occured = "<br><h2 class=sign-up-titl>Hmm, something wrong with your email. Try again.</h2>";
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
