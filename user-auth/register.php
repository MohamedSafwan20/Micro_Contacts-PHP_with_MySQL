<?php

// calling for validation
if(isset($_POST['submit'])) {

    include('../database/validate-user-registeration.php');

    //using static variable for passing errors from Validate class
    $errors = Validate::$err;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- materialize css -->
    <link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">

    <!-- main css -->
    <link rel="stylesheet" href="../assets/css/register-styles.css">

</head>

<body class="grey darken-3">
    <nav class="nav-wrapper grey darken-4">
        <a href="#" class="brand-logo center">MicroContacts</a>
    </nav>
    <div class="container">
        <div class="row">
            <h2 class="blue-text center">Sign up</h2>
        </div>
        <div class="form">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-field">
                    <label for="username">Username</label>

                    <!-- Persisting data in input field using value -->
                    <input type="text" name="username" 
                    value="<?php echo htmlspecialchars($_POST['username'] ?? "") ?>"
                    >

                    <!-- showing errors -->
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['username'] : ''; ?>
                    </span>
                </div>
                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="text" name="email" 
                    value="<?php echo htmlspecialchars($_POST['email'] ?? "") ?>"
                    >
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['email'] : ''; ?>
                    </span>
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" 
                    value="<?php echo htmlspecialchars($_POST['password'] ?? "") ?>"
                    >
                    <span class="red-text">
                        <?php echo !empty($errors) ? $errors['password'] : ''; ?>
                    </span>
                </div>
                <select name="gender">
                    <option value="default" selected>Choose gender:</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <span class="red-text">
                        <?php echo !empty($errors) ? $errors['gender'] : ''; ?>
                    </span>
                <div class="center-align submit-btn">
                <button type="submit" class="btn blue waves-effect" name="submit">Register</button>
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

    // For activating select box
    $(document).ready(function () {
        $('select').formSelect();
    });

</script>

</html>