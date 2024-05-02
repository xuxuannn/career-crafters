<?php
// Include database connection file
include 'conn.php';

// Retrieve user input from form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement
$sql = "SELECT * FROM admin WHERE username = ?";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "s", $username);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if the username exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the user data
    $user = mysqli_fetch_assoc($result);

    // Check if the password matches
    if ($password === $user['password']) {
        // Start the session and store the username
        session_start();
        $_SESSION['username'] = $username;

        // Redirect to admin dashboard
        header('Location: admin.php');
        exit;
    } else {
        echo "Invalid password";
    }
} else {
    echo "Invalid username";
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($conn);
?>
