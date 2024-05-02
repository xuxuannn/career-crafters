<?php
// Include database configuration
include("conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="register.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
<!-- CSS to format webpage -->
    <style>
        .container {
            margin-top: 50px;
            margin-left: 400px;
            margin-right: 100px;
            margin-bottom: 50px;
        }

        button{
            padding-left: 50px;
            padding-right: 50px;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            background-color: lightpink;
            border-width: 0px;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>User Registration</h2>
    <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (!empty($message)) : ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="register.php">
        

        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button onclick="myFunction()">Register</button>
<script>
function myFunction() {
  alert("You are registered!!");
}
</script>
<br>
        <p>Already have an account? <a href="login.php">Login</a></p>
        <p>Admin Log In <a href="admin_login.html">Login</a></p>
    </div>
    </form>
</body>
</html>
<?php
// Include database configuration
include("conn.php");

// Initialize variables
$fullname = "";
$email = "";
$username = "";
$password = "";
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $fullname = filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate input
    if (empty($fullname)) {
      $error = "Please enter your full name";
    } elseif (empty($email)) {
      $error = "Please enter a valid email address";
    } elseif (empty($username)) {
      $error = "Please enter a username";
   } elseif (empty($password)) {
      $error = "Please enter a password";
    } else {
      // Hash the password
      $hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the query
        $sql = "INSERT INTO users (fullname , email , username , password) VALUES ('$fullname','$email','$username', '$hash')";
        try{
            mysqli_query($conn, $sql);
            header("location: login.php");
            exit;
        }
        catch(mysqli_sql_exception){
            echo"That username is taken";
        }
    }
}
?>
