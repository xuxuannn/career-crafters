<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Skillfolio</title> 
    <link rel="stylesheet" href="admin.css">
    <style>
        .container {
            margin-top: 50px;
            margin-left: 200px;
            margin-right: 100px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="navbar">
    <button onclick="location.href='create.php'">My Profile</button>
        <button onclick="location.href='admin_login.html'">Logout</button>
        <div class="search-bar">
            <form method="get" action="searchAdmin.php">
                <input type="text" id="searchQuery" name="q" placeholder="Search portfolios...">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <?php
        include 'conn.php';
        session_start();

        $sql = "SELECT username, introduction, aboutMe, skills, contactDetails, workexperience FROM portfolios";
        $result = $conn->query($sql);

        while ($portfolio = $result->fetch_assoc()) {
            echo '<div class="portfolio">';
            echo '<h2>' . htmlspecialchars($portfolio['username']) . '\'s Portfolio</h2>';
            echo '<form id="' . $portfolio['username'] . '" method="post" action="savePortfolioAdmin.php">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($portfolio['username']) . '">';
            echo '<p><strong>Introduction:</strong> <textarea name="introduction">' . htmlspecialchars($portfolio['introduction']) . '</textarea></p>';
            echo '<p><strong>About Me:</strong> <textarea name="aboutMe">' . htmlspecialchars($portfolio['aboutMe']) . '</textarea></p>';
            echo '<p><strong>Skills:</strong> <textarea name="skills">' . htmlspecialchars($portfolio['skills']) . '</textarea></p>';
            echo '<p><strong>Contact Details:</strong> <textarea name="contactDetails">' . htmlspecialchars($portfolio['contactDetails']) . '</textarea></p>';
            echo '<p><strong>workexperience:</strong> <textarea name="workexperience">' . htmlspecialchars($portfolio['workexperience']) . '</textarea></p>';
            echo '<button type="button" onclick="editPortfolio(\'' . $portfolio['username'] . '\')">Edit</button>';
            echo '<button type="submit" onclick="savePortfolio(\'' . $portfolio['username'] . '\')">Save</button>';
            echo '</form>';
            echo '<button onclick="deletePortfolio(\'' . $portfolio['username'] . '\')">Delete</button>';
            echo '</div>';
        }
    ?>

    <script>
        function editPortfolio(username) {
            var textareas = document.querySelectorAll('#' + username + ' textarea');
            for (var i = 0; i < textareas.length; i++) {
                textareas[i].disabled = false;
            }
        }

        function savePortfolio(username) {
            var textareas = document.querySelectorAll('#' + username + ' textarea');
            for (var i = 0; i < textareas.length; i++) {
                textareas[i].disabled = true;
            }
            document.getElementById(username).submit();
        }

        function deletePortfolio(username) {
            if (confirm('Are you sure you want to delete this portfolio? This action cannot be undone.')) {
                window.location.href = 'deletePortfolioAdmin.php?username=' + encodeURIComponent(username);
            }
        }
    </script>
    </div>
</body>
</html>
