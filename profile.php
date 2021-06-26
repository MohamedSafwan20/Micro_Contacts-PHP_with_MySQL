<?php

// calling configuration of database
include('database/config.php');

// Accessing cookie stored in validate-user-login.php
$email = $_COOKIE['email'];

// Retrieving currently logged in user's data from database
$result = mysqli_query($connection, "SELECT username, email, password FROM users WHERE email='$email'");
$data = mysqli_fetch_assoc($result);

// Calling editUser.php only when form is submitted
if(isset($_POST['submit'])) {
    include('database/editUser.php');
    $errors = EditUser::$err;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- materialize css -->
    <link rel="stylesheet" href="assets/materialize/css/materialize.min.css">

    <link rel="stylesheet" href="assets/css/global.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="assets/font-awesome/css/all.css">
    <script src="assets/font-awesome/js/all.js"></script>

    <!-- main css -->
    <link rel="stylesheet" href="assets/css/profile-styles.css">

</head>

<body class="grey darken-3">
    <nav class="nav-wrapper grey darken-4">
        <a href="main.php" class="brand-logo center">MicroContacts</a>
    </nav>
    <div class="container">
        <div class="row">
            <h2 class="blue-text center">Profile</h2>

            <!-- Showing errors starting -->
            <ul class="errors center">
                <li class="red-text">
                    <?php echo !empty($errors) ? $errors['oldPassword'] : ''; ?>
                </li>
                <li class="red-text">
                    <?php echo !empty($errors) ? $errors['username'] : ''; ?>
                </li>
                <li class="red-text">
                    <?php echo !empty($errors) ? $errors['newPassword'] : ''; ?>
                </li>
            </ul>
             <!-- Showing errors ending -->

        </div>

        <!-- Profile details starting -->
        <div class="list center">
            <i class="fas fa-address-card fa-2x"></i>
            <ul style="margin-bottom: 0;">
                <li>
                    <span>Username:</span>
                    <?php echo "<span>{$data['username']}</span>" ?>
                </li>
                <li>
                    <span>Email:</span>
                    <?php echo "<span>{$data['email']}</span>" ?>
                </li>
                <li>
                    <span>Password:</span>
                    <span>********</span>
                </li>
                <li style="justify-content: center;">
                    <button class="btn transparent waves-effect modal-trigger" data-target="form-modal">
                        <span>Edit</span>
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </li>
            </ul>
        </div>
        <!-- Profile details ending -->

        <!-- Modal with form for changing user's data starting -->
        <div class="modal" id="form-modal" style="top: 40vh !important;">

            <!-- Modal close button with font-awesome close icon -->
            <div class="right-align modal-close" id="close">
                <i class="fas fa-times" style="color: white;"></i>
            </div>
            <div class="modal-content">
                <h3 class="blue-text center-align">Edit Profile</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="input-field">
                        <label for="oldPassword">Old Password</label>
                        <input type="password" name="oldPassword">
                    </div>
                    <div class="input-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="<?php echo $data['username'] ?>">
                    </div>
                    <div class="input-field">
                        <label for="newPassword">New Password</label>
                        <input type="password" name="newPassword">
                    </div>
                    <div class="center-align">
                        <button class="btn blue waves-effect" type="submit" name="submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal with form for changing user's data ending -->
        
    </div>
</body>

<!-- jquery -->
<script src="assets/jquery/jquery.js"></script>

<!-- materialize js -->
<script src="assets/materialize/js/materialize.min.js"></script>
<script>

    // Activating modal in materialize
    $(document).ready(function () {
        $('.modal').modal();
    });

</script>

</html>