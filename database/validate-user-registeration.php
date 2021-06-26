<?php


class Validate {

    // For storing validated data
    private $validUsername;
    private $validEmail;
    private $validPassword;
    private $validGender;

    // For storing errors and initializing for more UE and defining static for accessing variable in register.php
    public static $err = ['username' => '', 'password' => '', 'email' => '', 'gender' => ''];
    
    function __construct($data) {

        //methods return genuine data based on conditions
        $this->validUsername = $this->validateUsername($data['username']);
        $this->validEmail = $this->validateEmail($data['email']);
        $this->validPassword = $this->validatePassword($data['password']);
        $this->validGender = $this->validateGender($data['gender']);

    }

    private function validateUsername($username) {
        if(empty($username)) {
            Validate::$err['username'] = 'Username cannot be empty';
        } elseif (strlen($username) < 3) {
            Validate::$err['username'] = 'Username needs to be 3 chars long';
        } else {
            return $username;
            }
    }

    private function validateEmail($email) {
        if(empty($email)) {
            Validate::$err['email'] = 'Email cannot be empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Validate::$err['email'] = 'Must be a valid email';
        } else {
            return $email;
        }
    }

    private function validatePassword($pwd) {
        if(empty($pwd)) {
            Validate::$err['password'] = 'Password cannot be empty';
        } elseif (strlen($pwd) < 8) {
            Validate::$err['password'] = 'Password needs to be 8 chars long';
        } else {
            return $pwd;
        }
    }

    private function validateGender($gender) {
        if($gender === "default") {
            Validate::$err['gender'] = 'Please select your gender';
        } else {
            return $gender;
        }
    }

    // Function for sending validated data to database
    function sendToDb() {

    //checking everything is valid
    if($this->validUsername && $this->validEmail && $this->validPassword && $this->validGender ) {

        //calling configuration of mysql
        include('config.php');

        // storing data to server
        $result = mysqli_query($connection, "INSERT INTO users(username, email, password, gender) VALUES('{$this->validUsername}', '{$this->validEmail}', '{$this->validPassword}', '{$this->validGender}')");

        // redirecting user to login.php if everything is valid
        ($result) ? header("Location: ../user-auth/login.php") : null;

     }
  }
 
}
    

// Instantiaiting for calling constructor and passing array returned by POST
$validate = new Validate($_POST);

//Calling sendToDb() for sending data
$validate->sendToDb();

?>