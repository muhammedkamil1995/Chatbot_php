<?php
session_start(); // Start or resume the session

$id = $_GET['rn'];

// Replace with your actual database connection details
$host = '127.0.0.1';
$dbname = 'chatbot';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM CHATBOT_HINTS WHERE ID = :id";  // Using a named parameter
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);  // Bind the parameter value

    if ($stmt->execute()) {
        $_SESSION['message'] = "Record Deleted from database"; // Store a message in the session
    } else {
        $_SESSION['message'] = "Failed to delete from db!";
    }

    // Redirect back to the form page or any other desired page
    header("Location: qna.php");
    exit();

	} catch (PDOException $e) {
		throw new PDOException($e->getMessage());
	}

	// Display the session message
	if (isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']); // Clear the session message
	}
?>