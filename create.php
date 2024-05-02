<!DOCTYPE html>
<html>
<head>
    <title>User Page - Skillfolio</title> 
    <link rel="stylesheet" href="create.css">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }

        .navbar button {
            background-color: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar button:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .search-bar {
            margin-right: 20px;
        }

        .search-bar input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .search-bar input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .search-bar input[type="submit"]:hover {
            background-color: #45a049;
        }

        .portfolios {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .portfolios h3 {
            margin-top: 20px;
        }

        .portfolios textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .portfolios button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .portfolios button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .portfolios button:not(:disabled):hover {
            background-color: #0056b3;
        }

        .container {
            margin-top: 50px;
            margin-left: 100px;
            margin-right: 100px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
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

    // Prepare a select statement to retrieve the portfolio based on the username
    $sql = "SELECT introduction, aboutme, skills, contactdetails, workexperience FROM portfolios WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    $portfolio = $result->fetch_assoc();

    $stmt->close();
    ?>
    <div class="container">
    <div class="navbar">
        <button onclick="location.href='login.php'">Logout</button>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="get" action="search.php">
                <input type="text" id="searchQuery" name="q" placeholder="Search portfolios...">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
    <form id="portfolioForm" method="post" action="savePortfolio.php">
        <h2>Your Portfolio</h2>
        <div class="portfolios" id="portfolios">
            <h3>Introduction</h3>
            <textarea name="introduction" id="introduction" disabled><?php echo $portfolio ? htmlspecialchars($portfolio['introduction']) : ''; ?></textarea>
            <h3>About Me</h3>
            <textarea name="aboutme" id="aboutme" disabled><?php echo $portfolio ? htmlspecialchars($portfolio['aboutme']) : ''; ?></textarea>
            <h3>Contact Details</h3>
            <textarea name="contactdetails" id="contactdetails" disabled><?php echo $portfolio ? htmlspecialchars($portfolio['contactdetails']) : ''; ?></textarea>
            <h3>Skills</h3>
            <textarea name="skills" id="skills" disabled><?php echo $portfolio ? htmlspecialchars($portfolio['skills']) : ''; ?></textarea>
            <h3>Work Experience</h3>
            <textarea name="workexperience" id="workexperience" disabled><?php echo $portfolio ? htmlspecialchars($portfolio['workexperience']) : ''; ?></textarea>
        </div>
        <button type="button" class="edit-btn" onclick="editPortfolio()">Edit</button>
        <button type="submit" class="save-btn" onclick="savePortfolio()" disabled>Save</button>
        <button type="button" class="delete-btn" onclick="deletePortfolio()">Delete</button>
        <button type="button" class="view-all-btn" onclick="window.location.href='portfolio.php'">View All Portfolios</button>

    </form>
    <!-- Search Results -->
    <div id="searchResults"></div>

    <script>
    function editPortfolio() {
        // Enable all textareas in the portfolio
        var textareas = document.querySelectorAll('#portfolios textarea');
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].disabled = false;
        }

        // Enable the save button and disable the edit button
        document.querySelector('.save-btn').disabled = false;
        document.querySelector('.edit-btn').disabled = true;
    }

    function savePortfolio() {
        // Enable all textareas in the portfolio
        var textareas = document.querySelectorAll('#portfolios textarea');
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].disabled = false; // Textareas should be enabled before submitting the form
        }

        // Disable the save button and enable the edit button
        document.querySelector('.save-btn').disabled = true;
        document.querySelector('.edit-btn').disabled = false;

        // Submit the form
        document.querySelector('#portfolioForm').submit();

        return true; // Ensure the form gets submitted
    }

    function deletePortfolio() {
        if (confirm('Are you sure you want to delete your portfolio? This action cannot be undone.')) {
            // User clicked 'OK'
            window.location.href = 'deletePortfolio.php';
        }
    }
    </script>
    </div>
</body>
</html>
