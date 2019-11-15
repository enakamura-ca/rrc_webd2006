<?php
    session_start();
	require 'connect.php';
    include("class/Users.php");

    $usingclass = false;

    if (!isset($_SESSION['user']) and ($_POST['command'] != "Register"))
    {
        header("Location: http://localhost:31337/site/login.php");
    }

	if ($_POST)
	{
        try {
            if (($_POST['command'] == "Fix"))
            {
                $userid = $_SESSION['user'];
                $weight = $_SESSION['weight'];
                $workoutid = $_POST['workoutid'];
                $dateCreated = preg_replace("([^0-9/])", "", $_POST['dateCreated']);
                $dateCreated = date("Y-m-d", strtotime($dateCreated));
                $duration = $_POST['duration'];
                $distance = filter_input(INPUT_POST, 'distance', FILTER_SANITIZE_NUMBER_INT);

                //Calories calculation
                $MET = 10;
                $minutes_decimals = (substr($duration, 0, 2)/100) * 60;
                $duration_decimals = intval(substr($duration, 0, -2)) + $minutes_decimals;
                $total_duration = $duration_decimals / 60;
                if ($total_duration == 0)
                {
                    $calories = 0;
                }   
                else
                {
                    $calories = ($MET * $weight) / $total_duration;
                } 
                
                $query  = "UPDATE workouts SET dateCreated = :dateCreated, duration = :duration, distance = :distance, calories = :calories WHERE workoutid = :workoutid";
                $statement = $db->prepare($query);
                
                $bind_values = ['dateCreated' => $dateCreated, 'duration' => $duration, 
                    'distance' => $distance, 'calories' => $calories, 'workoutid' => $workoutid];

                }
            elseif (($_POST['command'] == "Delete"))
            {
                $workoutid = $_POST['workoutid'];

                $query  = "DELETE FROM workouts WHERE workoutid = :workoutid";
                $statement = $db->prepare($query);

                $bind_values = ['workoutid' => $workoutid];
            }
            elseif (($_POST['command'] == "Deleteuser"))
            {
                $user = new Users();

                $result = $user->delete($db, $_POST['userid']);

                $usingclass = true;
            }
            elseif (($_POST['command'] == "Awesome!"))
            {

                $userid = $_SESSION['user'];
                $weight = $_SESSION['weight'];
                $dateCreated = preg_replace("([^0-9/])", "", $_POST['dateCreated']);
                $dateCreated = date("Y-m-d", strtotime($dateCreated));
                $duration = $_POST['duration'];
                $distance = filter_input(INPUT_POST, 'distance', FILTER_SANITIZE_NUMBER_INT);

                //Calories calculation
                $MET = 10;
                $minutes_decimals = (substr($duration, 0, 2)/100) * 60;
                $duration_decimals = intval(substr($duration, 0, -2)) + $minutes_decimals;
                $total_duration = $duration_decimals / 60;
                $calories = ($MET * $weight) / $total_duration;

                $query  = "INSERT INTO  workouts (userid, dateCreated, duration, distance, calories) 
                    VALUES (:userid, :dateCreated, :duration, :distance, :calories)";

                $statement = $db->prepare($query);
                
                $bind_values = ['userid' => $userid, 'dateCreated' => $dateCreated, 'duration' => $duration, 
                    'distance' => $distance, 'calories' => $calories];
            }
            elseif (($_POST['command'] == "Register"))
            {
                $user = new Users();

                $result = $user->create($db,
                    filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT),
                    filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT),
                    $_POST['genre'],
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
