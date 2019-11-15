<?php

class Users
{
    private $firstName;
    private $lastName;
    private $weight;
    private $height;
    private $email;
    private $birthdate;
    private $password;
    private $userid;
    private $usertype;
    private $genre;

    public function __construct() {
        $test = null;
    }

    private function getfirstName() {
        return $this->firstname;
    }

    private function setfirstName($firstName) {
        $this->firstname = $firstName;
    }

    private function getlastName() {
        return $this->lastname;
    }

    private function setlastName($lastName) {
        $this->lastname = $lastName;
    }

    private function getweight() {
        return $this->weight;
    }

    private function setWeight($weight) {
        $this->weight = $weight;
    }

    private function getheight() {
        return $this->height;
    }

    private function setHeight($height) {
        $this->height = $height;
    }

    private function getemail() {
        return $this->email;
    }

    private function setEmail($email) {
        $this->email = $email;
    }

    private function getbirthdate() {
        return $this->birthdate;
    }

    private function setBirthdate($birthdate) {
        $workdate = preg_replace("([^0-9/])", "", $birthdate);
        $this->birthdate =  date("Y-m-d", strtotime($workdate));
    }

    private function getpassword() {
        return $this->password;
    }

    private function setPassword($password) {
        $this->password = $password;
    }

    private function getuserid() {
        return $this->userid;
    }

    private function setuserid($userid) {
        $this->userid = $userid;
    }

        public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    public function create($db, $firstName, $lastName, $genre, $weight, $height, $email, $birthdate, $password, $usertype) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->weight = $weight;
        $this->height = $height;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->usertype = $usertype;
        $this->genre = $genre;

        $query  = "INSERT INTO users (firstName, lastName, genre, birthdate, weight, height, email, password, userType) values (:firstName, :lastName, :genre, :birthdate, :weight, :height, :email, :password, :userType)";
        $statement = $db->prepare($query);

        $bind_values = ['firstName' => $firstName,'lastName' => $lastName, 'genre' => $genre, 'birthdate' => $birthdate,'weight' => $weight, 'height' => $height, 'email' => $email, 'password' => $password, 'userType' => $usertype];

        print_r($statement);
        $statement->execute($bind_values);


        return true;
    }

    public function save($db, $firstName, $lastName, $genre, $birthdate, $weight, $height, $email, $password, $userid) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->weight = $weight;
        $this->height = $height;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->userid = $userid;
        $this->genre = $genre;

        $query  = "UPDATE users SET firstName = :firstName, lastName = :lastName, genre = :genre, birthdate = :birthdate,
                    weight = :weight, height = :height, email = :email, password = :password WHERE userid = :userid";
        $statement = $db->prepare($query);

        $bind_values = ['firstName' => $firstName,'lastName' => $lastName, 'genre' => $genre, 'birthdate' => $birthdate,
        'weight' => $weight, 'height' => $height, 'email' => $email, 'password' => $password, 'userid' => $userid];

        $statement->execute($bind_values);

        return true;
    }

    public function delete($db, $userid) {
        $query  = "DELETE FROM users WHERE userid = :userid";
        $statement = $db->prepare($query);

        $bind_values = ['userid' => $userid];
        $statement->execute($bind_values);

        return true;
    }

    public function list($db, $userid = null) {
        $query = "SELECT * FROM users" . (isset($userid)? " WHERE userid = " . $userid : " ");
        $statement = $db->prepare($query);
        $statement->execute();
        $record = $statement->fetchAll();
        
        return $record;
    }
 
}

?>