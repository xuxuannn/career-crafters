<!DOCTYPE html>
<html>
<head>
    <title>All Portfolios - Skillfolio</title> 
    <link rel="stylesheet" href="create.css">
    <style>
        /* Your CSS styles here */
        .portfolio {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px; /* Add margin between each portfolio */
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
    <div class="navbar">
    <button onclick="location.href='create.php'">My Profile</button>
        <button onclick="location.href='login.php'">Logout</button>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="get" action="search.php">
                <input type="text" id="searchQuery" name="q" placeholder="Search portfolios...">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <div class="portfolios">
        <h2>All Portfolios</h2>
        <?php
        // Include database connection file
        include 'conn.php';

        // Retrieve all portfolios from the database
        $sql = "SELECT username, introduction, aboutme, skills, contactdetails, workexperience FROM portfolios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='portfolio'>";
                echo "<h3>Username: " . $row["username"] . "</h3>";
                echo "<p><strong>Introduction:</strong> " . $row["introduction"] . "</p>";
                echo "<p><strong>About Me:</strong> " . $row["aboutme"] . "</p>";
                echo "<p><strong>Skills:</strong> " . $row["skills"] . "</p>";
                echo "<p><strong>Contact Details:</strong> " . $row["contactdetails"] . "</p>";
                echo "<p><strong>Work Experience:</strong> " . $row["workexperience"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No portfolios found.";
        }
        $conn->close();
        ?>
    </div>
    </div>
</body>
</html>
