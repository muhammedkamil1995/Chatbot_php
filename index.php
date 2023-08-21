<?php
	session_start();
	require 'dbconfig/config.php';

		
	
		if(isset($_POST['login']))
		{
			$username=$_POST['username'];
			$password=$_POST['password'];
			
			$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			
			$stmt = $db->prepare($sql);
			$stmt->execute();
			if( $stmt->rowCount() > 0)
			{
				// valid
				$_SESSION['username']= $username;
				header('location:homepage.php');
			}
			else
			{
				// invalid
				$_SESSION['error'] = "Incorrect username or password. Please try again.";
				header('location:index.php');
				exit();
			}
			
		}
		
		
		
?>
<!DOCTYPE html>
<html>

<head>


    <title>Login chatbot</title>
    <link rel="stylesheet" href="css/stylex.css">
    -->
    <style>
    body {
        background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20190223/ourmid/pngtree-smart-robot-arm-advertising-background-backgroundrobotblue-backgrounddark-backgroundlightlight-image_68405.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }
    </style>



</head>

<br>
<br>
<br>
<br>
<br>
<br>

<br>
<br>


<!-- <body style="background-color:#bdc3c7"> -->

<div id="main-wrapper">
    <center>
        <h2><strong id="log">Login</strong></h2>
        <div class="imgcontainer">
            <img src="image/bot_avatar.png" class="avatar" />
    </center>

    <?php 

	// Check if the 'error' session variable exists and is set
	if (isset($_SESSION['error'])) {
	// Output the error message
	echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
	// Clear the 'error' session variable (optional, if you want to remove it after displaying the error)
	unset($_SESSION['error']);
	}

	?>

    <form class="myform" action="index.php" method="post">

        <div class="inner_container">

            <label><b id="un">Username:</b></label><br>
            <input name="username" id="us" type="text" class="inputvalues" placeholder="Enter Username here..."
                value="<?php echo (isset($_SESSION['username'])) ? $_SESSION['username'] : '' ?>" required /><br>
            <label><b id="pas">Password:</b></label><br>
            <input name="password" id="pass" type="password" class="inputvalues" placeholder="Your Password..."
                value="<?php echo (isset($_SESSION['password'])) ? $_SESSION['password'] : '' ?>" required /><br>

            <input name="login" type="submit" id="login_btn" value="Login" /><br>


            <a href="register.php"><input type="button" id="register_btn" value="Register" /></a> <br>

            <a href="admin.php"><input type="button" id="admin_btn" value=" Login as Admin" /></a>

        </div>

    </form>


</div>
</body>

</html>