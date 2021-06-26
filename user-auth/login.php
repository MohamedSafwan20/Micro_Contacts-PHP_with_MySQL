<?php

if(isset($_POST['submit'])) {
    include('../database/validate-user-login.php');

    // Defining variable to handle errors passed from validate-user-login.php
    $errors = Login::$err;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- materialize css -->
    <link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="../assets/font-awesome/css/all.css">
    <script src="../assets/font-awesome/js/all.js"></script>

    <!-- main css -->
    <link rel="stylesheet" href="../assets/css/login-styles.css">

</head>

<body class="grey darken-3">
    <nav class="nav-wrapper grey darken-4">
        <a href="#" class="brand-logo center">MicroContacts</a>
    </nav>
    <div class="container">
        <div class="row">
            <h2 class="blue-text center">Log in</h2>
        </div>
        <div class="form">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <span class="red-text">

                    <!-- showing error for non-existent user and using '@' for removing warning from DOM -->
                    <?php echo empty($errors['password-error']) ? @$errors['invalid-user'] : '' ?>
                </span>
                <div class="input-field">
                    <label for="email">Email</label>

                    <!-- Persisting data in input field using value -->
                    <input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? "") ?>">

                    <!-- showing errors -->
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['email'] : ''; ?>
                    </span>
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <!-- Persisting data in input field using value -->
                    <input type="password" name="password">

                    <!-- showing an error if password field is empty -->
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['password'] : ''; ?>
                    </span>

                    <!-- showing an error if password is wrong -->
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['password-error'] : ''; ?>
                    </span>
                </div>

                <!-- font-awesome icon -->
                <i class="far fa-question-circle"></i>

                <a href="#" class="grey-text forgot-pwd">forgot password?</a>
                <div class="center-align submit-btn">
                    <button type="submit" class="btn blue waves-effect" name="submit">Log in</button>
                </div>
            </form>
        </div>
    </div>
</body>

<!-- jquery -->
<script src="../assets/jquery/jquery.js"></script>

<!-- materialize js -->
<script src="../assets/materialize/js/materialize.min.js"></script>
<script>


</script>

</html>