<?php

// calling configuration of database
include('database/config.php');

// Accessing cookie stored in validate-user-login.php
$email = $_COOKIE['email'];

// Retrieving existing contacts from database
$result = mysqli_query($connection, "SELECT contact, username, id FROM users WHERE email='$email'");
$data = mysqli_fetch_assoc($result);

// Converting JSON data to associative array
$existingContacts = json_decode($data['contact'], true);

// Calling deleteContact.php only if data passed as query-string and then can avoid too-many-redirect error
if($_SERVER['QUERY_STRING'] !== '') {
    include('database/deleteContact.php');
}

// Calling addContact.php if modal-form is submitted
if(isset($_POST['submit'])) {
    include('database/addContact.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MicroContacts</title>

    <!-- materialize css -->
    <link rel="stylesheet" href="assets/materialize/css/materialize.min.css">

    <link rel="stylesheet" href="assets/css/global.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="assets/font-awesome/css/all.css">
    <script src="assets/font-awesome/js/all.js"></script>

    <!-- main css -->
    <link rel="stylesheet" href="assets/css/main-styles.css">

</head>

<body class="grey darken-3">
    <nav class="nav-wrapper grey darken-4">

        <!-- Sidenav-bar for mobile screens starting -->
        <ul class="sidenav grey darken-4 center" id="sidenav">
            <li>

                <!-- For getting user space at sidenav-bar starting -->
                <div class="user-view">
                    <div class="background">
                        <img src="assets/images/user-background.jpg" alt="bg-image" class="image">
                    </div>

                    <!-- Font-awesome user icon -->
                    <p><i class="fas fa-user-circle fa-3x" style="color: #2196f3;"></i></p>

                    <!-- Displaying currently logged in user's username -->
                    <a href="profile.php" class="profile">
                        <?php echo "{$data['username']}"; ?>
                    </a>

                    <!-- Font-awesom edit icon -->
                    <i class="far fa-edit"></i>
                </div>
                <!-- For getting user space at sidenav-bar ending -->

            </li>
        </ul>
        <!-- Sidenav-bar for mobile screens ending -->

        <div class="container">

            <!-- Button for triggering sidenav-bar with font-awesome menu icon -->
            <a href="#" data-target="sidenav" class="sidenav-trigger"><i class="fas fa-bars"></i></a>

            <a href="#" class="brand-logo center">MicroContacts</a>

            <ul class="right">
                <li>
                    <a href="profile.php" class="profile">
                        <?php echo "Hello {$data['username']}"; ?>
                    </a>
                </li>
                <li><i class="fas fa-user-circle" style="font-size: 18px;"></i></li>
            </ul>

        </div>


    </nav>
    <div class="container">
        <div class="row">
            <h2 class="blue-text center">Contacts</h2>
        </div>
        <div class="row">
            <ul class="collection white-text width">

                <!-- Printing existing contacts  -->
                <?php

                    // To avoid no input in screen and to print no-contact message
                    if(!empty($existingContacts)) {

                        // For getting the index[contactName] and the value[contact]
                        foreach($existingContacts as $key=>$value) {

                            // Avoiding initial null value of key at databse
                            if(!empty($key)) {
                                echo "<li class='collection-item avatar'>";
                                echo '<img src="assets/images/avatar.png" alt="contact-img" class="responsive-img circle" />';
                                echo "<p>$key</p>";

                                if(is_array($value)) {
                                    foreach($value as $item) {
                                        echo "<h6>$item</h6>";
                                    }
                                } else {
                                    echo "<h6>$value</h6>";
                                }


                                // Passing current data's contactName as query-string
                                echo "<a href='?contactName=$key' class='secondary-content red-text'><i class='fas fa-trash'></i></a>";

                                echo "</li>";
                            } else {
                                echo '<h3 class="center-align">No contacts yet.</h3>';
                            }
                        }
                    } else {
                        echo '<h3 class="center-align">No contacts yet.</h3>';
                    }
                    
                    ?>

            </ul>
        </div>

        <!-- Button for triggering modal -->
        <button class="btn btn-floating blue waves-effect modal-trigger btn-large" data-target="form-modal" id="button">

            <!-- Font-awesome add icon -->
            <i class="fas fa-plus"></i>
        </button>

        <!-- Modal with form for adding contacts starting -->
        <div class="modal" id="form-modal" style="top: 40vh !important;">

            <!-- Modal close button with font-awesome close icon -->
            <div class="right-align modal-close" id="close">
                <i class="fas fa-times" style="color: white;"></i>
            </div>
            <div class="modal-content">
                <h3 class="blue-text center-align">Add Contact</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="input-field">
                        <label for="contactName">Name</label>
                        <input type="text" name="contactName">
                    </div>
                    <div class="input-field">
                        <label for="contact">Contact number</label>
                        <input type="tel" name="contact" value="+91">
                    </div>
                    <div class="center-align">
                        <button class="btn blue waves-effect" type="submit" name="submit">add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal with form for adding contacts ending -->

    </div>
</body>

<!-- jquery -->
<script src="assets/jquery/jquery.js"></script>

<!-- materialize js -->
<script src="assets/materialize/js/materialize.min.js"></script>
<script>

    // Activating sidenav in materialize
    $(document).ready(function () {
        $('.sidenav').sidenav();
    });

    // Activating modal in materialize
    $(document).ready(function () {
        $('.modal').modal();
    });

</script>

</html>