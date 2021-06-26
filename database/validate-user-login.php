<?php


class Login {

    // Defining associative array for storing errors as static so can access in login.php
    public static $err = ['password' => '', 'email' => '', 'password-error' => '', 'invalid-user' => ''];

    // For storing validated email and password
    private $email;
    private $pwd;
    
    function __construct($data) {

        // checking whether the password is empty or not
        empty($data['password']) ? Login::$err['password'] = 'Password cannot be empty' : null;

        // Assigning validated data to corresponding variables
        $this->email = $this->validateEmail($data['email']);
        $this->pwd = $data['password'];
    }
    
    private function validateEmail($email) {
        if(empty($email)) {
            Login::$err['email'] = 'Email cannot be empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Login::$err['email'] = 'Must be a valid email';
        } else {
            return $email;
        }
    }
    
    // For checking whether the user exists or not and returning specific errors or rediricting if account exists
    public function checkUser() {
        include('config.php');
        
        if($this->email && $this->pwd) {

            // setting cookie for storing email refer:addContact.php
            setcookie ('email', $this->email, time()+100000, '/');
            
            // retrieving data from server
            $result = mysqli_query($connection, 'SELECT email, password FROM users');
            $userInfo = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            // Freeing up and closing connection to server
            mysqli_free_result($result);
            mysqli_close($connection);
            foreach($userInfo as $user) {
                
                if($this->email === $user['email']) {
                    if ($this->pwd === $user['password']) {
                        header("Location: ../main.php");
                    } else {

                        // Because user is valid but password is wrong emptying invalid-user error
                        Login::$err['password-error'] = 'Wrong password';
                    }
                } else {
                    Login::$err['invalid-user'] = 'Account does not exist';
                }
            }   
        }

    }

}


$login = new Login($_POST);
$login->checkUser();

?>