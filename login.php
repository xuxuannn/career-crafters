<?php
// Include database configuration
include("conn.php");

// Initialize variables
$username = "";
$password = "";
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate input
    if (empty($username)) {
      $error = "Please enter your username";
    } elseif (empty($password)) {
      $error = "Please enter your password";
    } else {
        // Prepare and execute the query
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct, start a session
                session_start();
                // Store data in session variables
                $_SESSION["username"] = $username;
                // Redirect user to home page or any other page you want after login
                header("location: portfolio.php");
                exit();
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "Username not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h2>User Login</h2>
    <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
