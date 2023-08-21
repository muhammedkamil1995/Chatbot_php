<?php

session_start();
require 'dbconfig/config.php';

if (isset($_POST['submit_btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    
    // Validate username
    if (empty($username)) {
        $_SESSION['error'] = 'Username is required';
    } elseif (!preg_match("/^[a-zA-Z']*$/", $username)) {
        $_SESSION['error'] = 'Username must contain only letters';
    } elseif (strlen($username) > 20) {
        $_SESSION['error'] = 'Username cannot be more than 20 characters';
    } elseif (strlen($username) < 3) {
        $_SESSION['error'] = 'Username cannot be less than 3 characters';
    }

    // Validate email
    elseif (empty($email)) {
        $_SESSION['error'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
    }

    // Validate password
    elseif (empty($password)) {
        $_SESSION['error'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long';
    } elseif ($password !== $password2) {
        $_SESSION['error'] = 'Passwords do not match';
    }

    if (empty($_SESSION['error'])) {
        $sql = "SELECT * FROM users WHERE username=:username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "User already exists. Try another username.";
        } else {
            $sql = "INSERT INTO users VALUES(NULL, :username, :email, :password)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                $_SESSION['success'] = "User registered successfully. Go to login page to log in.";
            } else {
                $_SESSION['error'] = "An error occurred while registering the user.";
            }
        }
    }

    header("Location: register.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>


    <style>
    body {
        background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20190223/ourmid/pngtree-smart-robot-arm-advertising-background-backgroundrobotblue-backgrounddark-backgroundlightlight-image_68405.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }
    </style>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <title>Registration Page</title>
    <link rel="stylesheet" href="css/stylex.css">
</head>
<!--<body style="background-color:#bdc3c7"> -->

<div id="main-wrapper">
    <center>
        <h2><strong id="regis">Sign Up</strong></h2>
        <img src="image/user_avatar.png" class="avatar" />
    </center>



    <form method="POST" class="myform" action="register.php">



        ?>
        <!--	<label><b>Full Name:</b></label><br>
			<input name="fullname" type="text" class="inputvalues" placeholder="Type your Full Name" required/><br>
			<label><b>Gender:</b></label>
			<input type="radio" class="radiobtns" name="gender" value="male" checked required> Male
			<input type="radio" class="radiobtns" name="gender" value="male" required> Female<br>
			<label><b>Educational Qualification</b></label>
			<select class="qualification" name="qualification">
			  <option value="BScIT">BScIT</option>
			  <option value="BMS">BMS</option>
			  <option value="BE.IT">BE.IT</option>
			  <option value="MCA">MCA</option>
			</select><br> -->

        <div class="inner_container">

            <?php
		if (isset($_SESSION['error'])) {
    	echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
    	unset($_SESSION['error']); // Clear the 'error' session variable
		}
		if (isset($_SESSION['success'])) {
    	echo '<div style="color: green;">' . $_SESSION['success'] . '</div>';
    	unset($_SESSION['success']); // Clear the 'success' session variable
		}
		?>


            <label><b id="run">Username:</b></label><br>
            <input name="username" type="text" id="ruser" class="inputvalues" placeholder="Username"
                value="<?php echo (isset($_SESSION['username'])) ? $_SESSION['username'] : '' ?>" required>
            <br><br>
            <label><b id="mail">Email:</b></label><br>
            <input name="email" type="email" id="email" class="inputvalues" placeholder="Email"
                value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" required>
            <br><br>
            <label><b id="pass2">Password:</b></label><br>
            <input name="password" type="password" id="password" class="inputvalues" placeholder="password"
                value="<?php echo (isset($_SESSION['password'])) ? $_SESSION['password'] : '' ?>" required>
            <br><br>
            <label><b id="pass2">Confirm Password:</b></label><br>
            <input name="password2" type="password" id="password2" class="inputvalues" placeholder="Confirm password"
                value="<?php echo (isset($_SESSION['password2'])) ? $_SESSION['password2'] : '' ?>" required>
            <br><br>
            <input name="submit_btn" type="submit" id="signup_btn" value="Sign Up" /><br>
            <a href="index.php"><input type="button" id="back_btn" value="Back" /></a>

        </div>

    </form>


</div>
</body>

</html>