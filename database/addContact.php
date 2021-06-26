<?php


class AddContact {

    // For storing errors and declaring as static to use at main.php
    private static $err = ['contactName' => '', 'contact' => ''];

    // For storing validated contact[number] and contactname
    private $contact;
    private $contactName;
        
    function __construct($data) {

        // checking whether input fields are empty or not, if not calling validating functions
        empty($data['contactName']) ? self::$err['contactName'] = 'Contact name cannot be empty' : $this->contactName = $this->validateContactName($data['contactName']);

        empty($data['contact']) ? self::$err['contact'] = 'Contact number cannot be empty' : $this->contact = $this->validateContact($data['contact']);
        
    }
    
    private function validateContactName($contactName) {
        if(strlen($contactName) <3) {
            self::$err['contactName'] = 'Must be 3 chars long';
        } else {
            return $contactName;
        } 
    }

    private function validateContact($contact) {
        if(is_numeric($contact)) {
            return $contact;
        } else {
            self::$err['contact'] = 'Must be a number';
        }
    }
    
    // For storing new inputted contacts to database
    public function storingToDb() {
        
        // ensuring whether everything is valid
        if($this->contact && $this->contactName) {

            // calling database configuration
            include('config.php');

            // Accessing cookie stored in validate-user-login.php
            $email = $_COOKIE['email'];

            // Retrieving existing contacts in database
            $result = mysqli_query($connection, "SELECT contact FROM users WHERE email='$email'");
            $data = mysqli_fetch_assoc($result);

            // Converting JSON data to associative array
            $existingContacts = json_decode($data['contact'], true);

            // Creating an associative array for new inputted contacts
            $newContacts = array($_POST['contactName'] => $_POST['contact']);

            // Finally merging the two arrays using array_merge_recursive function so can avoid overwriting keys with same values but if $existingContacts is not an array then merging the new contacts with an empty array
            is_array($existingContacts) ? $contacts = array_merge_recursive($existingContacts, $newContacts) : $contacts = array_merge_recursive(['' => ''], $newContacts);

            // Converting to JSON
            $data = json_encode($contacts);

            // Updating contact in database
            mysqli_query($connection, "UPDATE users SET contact='$data' WHERE email='$email'");

            // Refreshing page by redirecting
            header('Location:main.php#');

        }
    }    
    }
    
    // Passing $_POST array to constructor
    $addContact = new AddContact($_POST);
    
    $existingContacts = $addContact->storingToDb();
    
?>