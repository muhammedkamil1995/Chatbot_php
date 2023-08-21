<?php
require_once 'dbconfig/config.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update</title>
    <style>
    input {
        font-size: 1vw;
    }

    table {
        color: white;
        border-radius: 19px;

        background: linear-gradient(blue, black, blue);
    }

    #button {
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        height: 32px;
        width: 145px;
        border-radius: 25px;
        font-size: 16px;
    }

    body {
        background: linear-gradient(black, black);

        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;


    }
    </style>


</head>
<br><br><br><br><br><br>
<br>
<br>
<form action="invalidans.php" method="POST">




    <table border="0" bgcolor="black" align="center" cellspacing="50">
        <div id="main-wrapper">
            <center>

                <div class="imgcontainer">
                    <img src="image/bot_avatar.png" class="avatar" />
            </center>
        </div>

        <?php

	if (isset($_SESSION['error_message'])) {
	echo '<div style="color: red;">' . $_SESSION['error_message'] . '</div>';
	unset($_SESSION['error_message']); // Clear the 'error' session variable
	}
	if (isset($_SESSION['success_message'])) {
	echo '<div style="color: green;">' . $_SESSION['success_message'] . '</div>';
	unset($_SESSION['success_message']); // Clear the 'success' session variable
	}
    ?>

        <tr>
            <td>Invalid Response</td>
            <td><input type="text" value="" name="messages" placeholder="Type your query here..." required></td>

        </tr>

        </tr>
        <tr>
            <td colspan="3" align="center"><input type="submit" id="button" name="submit" value="Report as Invalid" />
            </td>
        </tr>


    </table>
</form>


</body>

</html>


<?php

// Start a session (if not already started)
session_start();

// Assuming $db is your database connection object

if(isset($_POST['submit']))
{
	// $id = $_POST['id'];
	$messages = $_POST['messages'];

	try {
		$sql = "INSERT INTO invalid() VALUES(NULL, '$messages')";
		$stmt = $db->prepare($sql);
		if ( $stmt->execute() ){
			$_SESSION['success_message'] = "Success!";
			header("Location: invalidans.php"); // Redirect to a success page
			exit();
		} else {
			$_SESSION['error_message'] = "An error occurred.";
			header("Location: invalidans.php"); // Redirect to an error page
			exit();
		}
	} catch (PDOException $e) {
		$_SESSION['error_message'] = "Database error: " . $e->getMessage();
		header("Location: invalidans.php"); // Redirect to an error page
		exit();
	}
}
?>