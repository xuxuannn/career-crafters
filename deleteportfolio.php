<?php
// Include database connection file
include 'conn.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header('Location: login.html');
    exit;
}

// Retrieve username from session
$username = $_SESSION['username'];

// Prepare a delete statement
$sql = "DELETE FROM portfolios WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to user.html
    header('Location: create.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
?>
