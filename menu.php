<?php
// Start the session
session_start();

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="data/time.ico" type="image/x-icon">
</head>
<body>
    <div class="menu-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>!</h2>
        <h2>API documentation</h2>
        <ul class="menu-list">
            <li><a href="records.php">📄 Records</a></li>
            <li><a href="employees.php">👥 Employees</a></li>
            <li><a href="compute.php">🖩 Compute</a></li>
            <li><a href="logout.php" class="logout-btn">🚪 Logout</a></li>
        </ul>
    </div>
</body>
</html>
