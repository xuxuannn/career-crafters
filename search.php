<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Skillfolio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .portfolio {
            background-color: #fff;
            border: 1px solid #ccc;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .portfolio h2,
        .portfolio h3,
        .portfolio p {
            margin: 0; /* Remove default margin to ensure text displays properly */
        }

        .portfolio h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .portfolio h3 {
            font-size: 16px;
            margin-top: 15px;
        }

        .portfolio p {
            font-size: 14px;
            margin-top: 5px;
        }

        nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            color: #333;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #ccc;
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
    <div class="container">
    <header>
        <h1>Search Results</h1>
    </header>

    <?php
    // Include database connection file
    include 'conn.php';

    // Retrieve search query from URL parameters
    $searchQuery = $_GET['q'];

    // Prepare a select statement
    $sql = "SELECT users.username, users.fullname, portfolios.introduction, portfolios.aboutMe, portfolios.skills, portfolios.contactDetails, portfolios.workexperience 
            FROM users 
            JOIN portfolios ON users.username = portfolios.username 
            WHERE users.username LIKE ? OR users.fullname LIKE ?";

    $stmt = $conn->prepare($sql);
    $searchParam = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchParam, $searchParam);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the results
    while ($row = $result->fetch_assoc()) {
        echo "<div class='portfolio'>";
        echo "<h2>" . htmlspecialchars($row['fullname']) . " (" . htmlspecialchars($row['username']) . ")</h2>";
        echo "<h3>Introduction</h3>";
        echo "<p>" . htmlspecialchars($row['introduction']) . "</p>";
        echo "<h3>About Me</h3>";
        echo "<p>" . htmlspecialchars($row['aboutMe']) . "</p>";
        echo "<h3>Skills</h3>";
        echo "<p>" . htmlspecialchars($row['skills']) . "</p>";
        echo "<h3>Contact Details</h3>";
        echo "<p>" . htmlspecialchars($row['contactDetails']) . "</p>";
        echo "<h3>Work Experience</h3>";
        echo "<p>" . htmlspecialchars($row['workexperience']) . "</p>";
        echo "</div>";
    }

    $stmt->close();
    ?>
    
    <nav>
        <!-- Redirect back to userpage.php -->
        <a href="Portfolio.php">Back to Portfolio Page</a>
    </nav>
</div>
</body>
</html>
