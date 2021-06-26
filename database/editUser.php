<?php

class EditUser {

    // For storing validated data
    private $validOldPassword;
    private $validUsername;
    private $validNewPassword;

    // For storing errors and initializing for more UE and defining static for accessing variable in profile.php
    public static $err = ['username' => '', 'newPassword' => ''];
    
    function __construct($data) {

        //methods return genuine data based on conditions
        $this->validOldPassword = $this->checkOldPassword($data['oldPassword']);
        $this->validUsername = $this->validateUsername($data['username']);
        $this->validNewPassword = $this->validatePassword($data['newPassword']);

    }

    private function checkOldPassword($oldPwd) {
        if(empty($oldPwd)) {
            EditUser::$err['oldPassword'] = 'Old Password cannot be empty';
        } else {
            include('config.php');
            $email = $_COOKIE['email'];
            $result = mysqli_query($connection, "SELECT password FROM users WHERE email='$email'");
            $data = mysqli_fetch_assoc($result);

            // Checking if entered password is same as password in database
            if($oldPwd === $data['password']) {
                return $oldPwd;
            } else {
                EditUser::$err['oldPassword'] = 'OldPassword is wrong';
            }
        }
    }

    private function validateUsername($username) {
        if(empty($username)) {
            EditUser::$err['username'] = 'Username cannot be empty';
        } elseif (strlen($username) < 3) {
            EditUser::$err['username'] = 'Username needs to be 3 chars long';
        } else {
            return $username;
            }
    }

    private function validatePassword($pwd) {
        if(empty($pwd)) {
            EditUser::$err['newPassword'] = 'New Password cannot be empty';
        } elseif (strlen($pwd) < 8) {
            EditUser::$err['newPassword'] = 'New Password needs to be 8 chars long';
        } else {
            return $pwd;
        }
    }

    // Function for updating validated data in database
    function updateDataInDb() {

    //checking everything is valid
    if($this->validOldPassword && $this->validUsername && $this->validNewPassword ) {

        //calling configuration of mysql
        include('config.php');

        $email = $_COOKIE['email'];
        
        // updating data in server
        $result = mysqli_query($connection, "UPDATE users SET username='{$this->validUsername}', password='{$this->validNewPassword}' WHERE email='$email'");
        
        // Refreshing current page by using redirection
        header("Location: profile.php");

     }
  }
 
}

// Sending $_POST from profile.php to constructor
$editUser = new EditUser($_POST);
$editUser -> updateDataInDb();

?>