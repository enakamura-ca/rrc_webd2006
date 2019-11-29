<?php
    session_start();
	require 'connect.php';
    include("class/Users.php");

    $usingclass = false;

    if (!isset($_SESSION['user']) or ($_POST['command'] != "Register"))
    {
        header("Location: http://localhost:31337/site/login.php");
    }

	if ($_POST)
	{
        try {
            if (($_POST['command'] == "Deleteuser"))
            {
                $user = new Users();

                $result = $user->delete($db, $_POST['userid']);

                $usingclass = true;
            }
            elseif (($_POST['command'] == "Register"))
            {
                $user = new Users();
                $result = $user->create($db,
                    filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    $_POST['genre'],
                    filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT),
                    filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT),
                    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    $_POST['birthdate'],
                    $password = $_POST['password'],
                    $userType = $_POST['userType']);
                
                $usingclass = true;
            }
            if (($_POST['command'] == "Updateuser"))
            {
                $user = new Users();

                $result = $user->save($db, filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    $_POST['genre'],
                    $_POST['birthdate'],
                    filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT),
                    filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT),
                    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    $_POST['password'],
                    $_POST['userid']);

                $usingclass = true;
            }
            if (!$usingclass)
                $statement->execute($bind_values);

        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die(); // Force execution to stop on errors.
        }
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0; URL=success.html"/>
</head>
<body>
</body>
</html>
