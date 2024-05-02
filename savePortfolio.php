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

// Retrieve portfolio data from the form submission
$introduction = $_POST['introduction'];
$aboutme = $_POST['aboutme'];
$skills = $_POST['skills'];
$contactdetails = $_POST['contactdetails'];
$workexperience = $_POST['workexperience'];

// Check if the portfolio already exists for the user
$sql = "SELECT * FROM portfolios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Portfolio exists, update the existing record
    $sql = "UPDATE portfolios SET introduction = ?, aboutme = ?, skills = ?, contactdetails = ?, workexperience = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $introduction, $aboutme, $skills, $contactdetails, $workexperience, $username);
} else {
    // Portfolio doesn't exist, insert a new record
    $sql = "INSERT INTO portfolios (username, introduction, aboutme, skills, contactdetails, workexperience) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $introduction, $aboutme, $skills, $contactdetails, $workexperience);
}

if ($stmt->execute()) {
    // Redirect back to the user page after saving
    header('Location: create.php');
    exit;
} else {
    // Error occurred
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
