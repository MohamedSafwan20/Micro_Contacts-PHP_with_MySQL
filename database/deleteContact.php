<?php

class DeleteContact {
    
    private $contactToDelete;
    
    function __construct($data) {

        // Storing data passed through query string to $contactToDelete as an associative array
        parse_str($data, $this->contactToDelete);

        // Using reset method to get the first element key name
        $this->contactToDelete = reset($this->contactToDelete);
    }
    
    // Function for deleting data from database
    public function deleteFromDb() {

        // calling configuration of database
        include('database/config.php');

        // Accessing cookie stored in validate-user-login.php
        $email = $_COOKIE['email'];

        // Removing data by using json_remove function
        $result = mysqli_query($connection, "UPDATE users SET contact=json_remove(contact, '$.{$this->contactToDelete}') WHERE email='$email'");

        // Refreshing page by redirecting
        header("Location: main.php#");
    }
}

// Passing query-string to constructor
$deleteContact = new DeleteContact($_SERVER['QUERY_STRING']);

$deleteContact -> deleteFromDb();

?>