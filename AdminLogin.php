<?php
session_start(); // Start the session

require_once("connect.php"); // Assuming "connect.php" contains the database connection code

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    // Prepare and execute the SQL query to check if the username and password exist in the table
    $sql = "SELECT * FROM admin WHERE Username = '$Username' AND Password = '$Password'";
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Username and password are correct, store the username in the session
        $_SESSION['Username'] = $Username;
        $_SESSION['LoggedIn'] = true;
        $_SESSION['LastActivity'] = time(); // Set the last activity timestamp
        header("Location: AdminHome.html?Username=" . urlencode($Username));
        exit(); // Stop further execution of the script
    } else {
        // Username or password is incorrect, display an error message
        echo "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>

