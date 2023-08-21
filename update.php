<?php
	session_start();
    require_once 'dbconfig/config.php';

    // Check if values are present in the URL
    if (isset($_GET['rn']) && isset($_GET['ques']) && isset($_GET['rep'])) {
        $rn = $_GET['rn'];
        $ques = $_GET['ques'];
        $rep = $_GET['rep'];

	} else {
        echo "Missing parameters in the URL.";
    }
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
        width: 125px;
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

<form action="update.php" method="GET">
    <table border="0" bgcolor="black" align="center" cellspacing="50">
        <div id="main-wrapper">
            <center>

                <div class="imgcontainer">
                    <img src="image/bot_avatar.png" class="avatar" />
            </center>
        </div>

        <tr>
            <td>Id</td>
            <td><input type="text" value="<?php echo "$rn" ?>" name="id" required></td>

        </tr>
        <tr>
            <td>Question</td>
            <td><input type="text" value="<?php echo "$ques" ?>" name="question" required></td>

        </tr>

        <tr>
            <td>Reply</td>
            <td><input type="text" value="<?php echo "$rep" ?>" name="reply" required></td>

        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" id=button name="submit" value="Update Details" /></td>
        </tr>


    </table>
</form>


</body>

</html>
<?php
if (isset($_GET['submit'])) {
    $id = $_GET['id'];
    $question = $_GET['question'];
    $reply = $_GET['reply'];

    // Assuming you have a valid database connection stored in $db
    $sql = "UPDATE CHATBOT_HINTS SET question=:question, reply=:reply WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $rn);
    $stmt->bindParam(':question', $ques);
    $stmt->bindParam(':reply', $rep);

	if ($stmt->execute()) {
        $_SESSION['message'] = "Record Updated successfully"; // Store a message in the session
    } else {
        $_SESSION['message'] = "Failed To Update Record";
    }
	

// Display the session message
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']); // Clear the session message
}

}
?>