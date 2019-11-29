<?php
require('function\functions.php');
require('function\checkfile.php');
require('function\upload.php');
require('function\ImageResize.php');
require('function\ImageResizeException.php');
use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

class Workout
{
    private $userid;
    private $workoutid;
    private $weight;
    private $dateCreated;
    private $duration;
    private $distance;
    private $calorie;
    private $image;

    /**
     * Get the value of distance
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set the value of distance
     *
     * @return  self
     */ 
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get the value of duration
     */ 
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @return  self
     */ 
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of dateCreated
     */ 
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @return  self
     */ 
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get the value of weight
     */ 
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */ 
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of userid
     */ 
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set the value of userid
     *
     * @return  self
     */ 
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    public function __construct() {
        $test = null;
    }

    private function calculateCalories($duration, $weight) {
        $MET = 10;
        $minutes_decimals = (substr($duration, 0, 2)/100) * 60;
        $duration_decimals = intval(substr($duration, 0, -2)) + $minutes_decimals;
        $total_duration = $duration_decimals / 60;
        if ($total_duration > 0)
            $calories = ($MET * $weight) / $total_duration;
        else
            $calories = 0;

        return $calories;
    }

    public function uploadFile($FileObject)
    {
		$image_filename       = $_FILES['image']['name'];
		$temporary_image_path = $_FILES['image']['tmp_name'];
		$new_image_path       = file_upload_path($image_filename);

		if (file_is_an_image($_FILES['image']['tmp_name'], $new_image_path)) {
			$resize = new ImageResize($_FILES['image']['tmp_name']);
			$resize->resizeToLongSide(100);
			$strNewFileName = str_replace(left($new_image_path, strlen($new_image_path) -4),
				left($new_image_path, strlen($new_image_path) -4) . '_medium' . right($new_image_path, 4), $new_image_path);
			$resize->save($strNewFileName);

			$resize->resizeToShortSide(50);
			$strNewFileName = str_replace(left($new_image_path, strlen($new_image_path) -4),
				left($new_image_path, strlen($new_image_path) -4) . '_thumbnail' . right($new_image_path, 4), $new_image_path);
			$resize->save($strNewFileName);

			move_uploaded_file($temporary_image_path, $new_image_path);
			$file_not_update = '';
		}
		else if ($_FILES['image']['type'] == 'application/pdf') {
			move_uploaded_file($temporary_image_path, $new_image_path);
		}
        return $new_image_path;
    }

    public function create($db, $userid, $dateCreated, $duration, $distance, $weight, $image) {

        $this->userid = $userid;
        $this->dateCreated = $dateCreated;
        $this->duration = $duration;
        $this->distance = $distance;
        $calories = $this->calculateCalories($duration, $weight);
        $this->calorie = $calories;
        $this->image = $image;

        $query  = "INSERT INTO  workouts (userid, dateCreated, duration, distance, calories, image) 
                        VALUES (:userid, :dateCreated, :duration, :distance, :calories, :image)";
        $statement = $db->prepare($query);

        $bind_values = ['userid' => $userid, 'dateCreated' => $dateCreated, 'duration' => $duration, 
                'distance' => $distance, 'calories' => $calories, 'image' => $image];

        $statement->execute($bind_values);

        return true;
    }

    public function save($db, $workoutid, $userid, $dateCreated, $duration, $distance, $weight, $image) {
        $this->workoutid = $workoutid;
        $this->userid = $userid;
        $this->dateCreated = $dateCreated;
        $this->duration = $duration;
        $this->distance = $distance;
        $calories = $this->calculateCalories($duration, $weight);
        $this->calorie = $calories;
        if ($image == "noimage")
        {
            $image = null;
            $this->image = $image;
        }

        $query  = "UPDATE workouts SET dateCreated = :dateCreated, duration = :duration, distance = :distance, calories = :calories, image = :image WHERE workoutid = " . $workoutid;
        $statement = $db->prepare($query);

        $bind_values = ['dateCreated' => $dateCreated, 'duration' => $duration,'distance' => $distance, 'calories' => $calories, 'image' => $image];

        print_r($bind_values);

        $statement->execute($bind_values);

        return true;
    }

    public function list($db, $workoutid=null) {
        $query = "SELECT * FROM workouts " . (isset($workoutid)? " WHERE workoutid = " . $workoutid : " ") . " ORDER BY dateCreated";
        
        $statement = $db->prepare($query);
        $statement->execute();
        $record = $statement->fetchAll();
        
        return $record;
    }

    public function delete($db, $workoutid) {
        $query  = "DELETE FROM workouts WHERE workoutid = " . $workoutid;
        $statement = $db->prepare($query);
        $statement->execute($bind_values);

        return true;
    }
    /**
     * Get the value of calorie
     */ 
    public function getCalorie()
    {
        return $this->calorie;
    }

    /**
     * Set the value of calorie
     *
     * @return  self
     */ 
    public function setCalorie($calorie)
    {
        $this->calorie = $calorie;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}