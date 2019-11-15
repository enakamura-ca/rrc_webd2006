<?php
session_start();
include("class/Users.php");
require 'connect.php';

$readonly = " ";
if (isset($_POST['command']))
{
  if ($_POST['command'] = "Edit")
  {
    $userid = $_POST['userid'];

    $user = new Users();
    $record = $user->list($db,$userid);

    $useredit = false;    

    foreach($record as $userrecord)
    {
      $firstname = $userrecord['firstName'];
      $lastname = $userrecord['lastName'];
      $genre = $userrecord['genre'];
      $birthdate = $userrecord['birthdate'];
      $password = $userrecord['password'];
      $weight = $userrecord['weight'];
      $height = $userrecord['height'];
      $email = $userrecord['email'];
      if ($userrecord['genre'] == "m")
      {
        $maleselected = "selected";
        $femaleselected = "";
        $otherselected = "";
      }
      elseif ($userrecord['genre'] == "f")
      {
        $maleselected = "";
        $femaleselected = "selected";
        $otherselected = "";
      }
      else
      {
        $maleselected = "";
        $femaleselected = "";
        $otherselected = "selected";
      }
      if ($userrecord['userType'] == "U")
        $readonly = "readonly";

    }
    $db = null;
  }
  
}
else
{
  $user = new Users();
  $record = $user->list($db,($_SESSION['usertype'] == 'U')? $_SESSION['user'] : null);

  $useredit = true;
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
		<h2>Edit User</h2>
    <form action="edituser.php" method="post" name="edituser">
    <input type="hidden" name="command" id="command"> 
    <input type="hidden" name="userid" id="userid"> 

  <?php if ($useredit) : ?>
      <div class="table-wrapper">
        <table class="fl-table">
          <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Genre</th>
            <th>Birthdate</th>
            <th>Weight</th>
            <th>Height</th>
            <th>Email</th>
            <th>Password</th>
            <th></th>
            <?php if ($_SESSION['usertype'] == "A") : ?>
              <th></th>
            <?php endif ?>
          </tr>
          </thead>
          <tbody>
          <?php
              foreach($record as $userrecord)
              {
                echo "<tr>";		
                echo "<td>".$userrecord['firstName']."</td>";
                echo "<td>".$userrecord['lastName']."</td>";
                echo "<td>".$userrecord['genre']."</td>";
                echo "<td>".$userrecord['birthdate']."</td>"; 
                echo "<td>".$userrecord['weight']."</td>"; 
                echo "<td>".$userrecord['height']."</td>"; 
                echo "<td>".$userrecord['email']."</td>"; 
                echo "<td>".$userrecord['password']."</td>"; 
                echo "<td><input type=button onclick=submitEdit('" . $userrecord['userId'] . "') value=Edit></td>"; 
                if ($_SESSION['usertype'] == "A")
                {
                  echo "<td><input type=button onclick=submitDelete('" . $userrecord['userId'] . "') value=Delete></td>"; 
                }
                echo "</tr>";
              }
              $db = null;
            ?>
          <tbody>
        </table>
      </div>
  <?php else : ?>
   <div class="sign-up">
        <input type="text" class="sign-up-input" name="firstName" id="firstName" value=<?php echo $firstname ?>>
        <input type="text" class="sign-up-input" name="lastName" id="lastName" value=<?php echo $lastname ?>>
        <select class="sign-up-input" name="genre" id="genre">
          <option value="genre">Genre</option>
          <option value="male" <?php echo $maleselected ?>>Male</option>
          <option value="female" <?php echo $femaleselected ?>>Female</option>
          <option value="other" <?php echo $otherselected ?>>Other</option>
        </select>
        <input type="text" class="sign-up-input" required pattern="\d{1,2}/\d{1,2}/\d{4}" name="birthdate" id="birthdate" value=<?php echo $birthdate . " " . $readonly ?>>
        <input type="text" class="sign-up-input" name="weight" id="weight" value=<?php echo $weight ?>>
        <input type="text" class="sign-up-input" name="height" id="height" value=<?php echo $height ?>>
        <input type="text" class="sign-up-input" name="email" id="email" value=<?php echo $email . " " . $readonly?>>
        <input type="password" class="sign-up-input" name="password" id="password" value=<?php echo $password ?>>
        <input type="button" name="command" value="Update!" class="sign-up-button" onclick="submitform(' <?php echo $userid ?> ')">
    </div>
  <?php endif ?>
  </form>
<script>
  function submitform(id)
  {
		document.getElementById("userid").value = id;
		document.getElementById("command").value = 'Updateuser';
		document.edituser.action = "process_post.php";
		document.edituser.submit();
  }

  function submitDelete(id)
	{
		document.getElementById("command").value = "Deleteuser";
		document.getElementById("userid").value = id;
		document.edituser.action = "process_post.php";
		document.edituser.submit();
	};

	function submitEdit(id)
	{
		document.getElementById("command").value = "Edit";
		document.getElementById("userid").value = id;
		document.edituser.action = "edituser.php";
		document.edituser.submit();
	};


  </script>
</body>
</html>
