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
                    weight = :weight, height = :height, email = :email, password = :password WHERE userid = :userid ";
        $statement = $db->prepare($query);

        $bind_values = ['firstName' => $firstName,'lastName' => $lastName, 'genre' => $genre, 'birthdate' => $birthdate,
        'weight' => $weight, 'height' => $height, 'email' => $email, 'password' => $password, 'userid' => $userid];

        $statement->execute($bind_values);

        return true;
    }

    public function delete($db, $userid) {

        $query  = "UPDATE users SET active = 'N' WHERE userid = :userid";
        $statement = $db->prepare($query);

        $bind_values = ['userid' => $userid];
        $statement->execute($bind_values);

        return true;
    }

    public function list($db, $userType, $userid = null) {
        if ($userType == "A")
            $query = "SELECT * FROM users" . (isset($userid)? " WHERE userid = " . $userid : " ");
        else
            $query = "SELECT * FROM users" . (isset($userid)? " WHERE userid = " . $userid . " AND ": " WHERE ") . " active = 'Y'";
        $statement = $db->prepare($query);
        $statement->execute();
        $record = $statement->fetchAll();
        
        return $record;
    }
 
    public function checkUser($db, $email, $password = null) {

        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email,PDO::PARAM_STR);

        $statement->execute();      

        $rowcount = $statement->rowCount(); 
        if ($rowcount > 0)
        {
            $record = $statement->fetch();
            if ($record['active'] == "N")
                return "inactive";

            if ($record['password'] !== $password)
                return "wrong";
            else {
                $userArray = array($record['userId'], $record['firstName'], $record['weight'], $record['userType']);
                return $userArray;
            }
        }
        else
            return "new";    
          
    }

    public function listPermissions($db, $userid) {
        $query = "SELECT * ";
        $query = $query . "FROM user_permission u,";
        $query = $query . "object_permissions p ";
        $query = $query . "WHERE u.idObjectPermission = p.id ";
        $query = $query . "AND u.idUser = " . $userid;

        $statement = $db->prepare($query);
        $statement->execute();
        $record = $statement->fetchAll();
        
        return $record;
    }
 
}

?>