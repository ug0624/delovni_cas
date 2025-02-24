<?php
// Include the database connection file
include 'db_connection.php';

// Initialize the session
session_start();

// Check if the user is already logged in, redirect to menu if true
if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true) {
    header("Location: menu.php");
    exit();
}

// API response format
$response = array();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepared statement to prevent SQL injection
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_id"] = $row['id'];
            $_SESSION["admin_username"] = $row['username'];

            // Redirect to menu page after successful login
            header("Location: menu.php");
            exit();
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'User not found.';
    }

    $stmt->close();
} else {
    // Display login form if the request method is not POST
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="data/time.ico" type="image/x-icon">
    </head>
    <body>
        <div class="login-container">
            <h2>API Documentation Login</h2>
            <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
    </html>

    <?php
    exit();
}

// Echo the final JSON response
echo json_encode($response);

// Close the database connection
$conn->close();
?>
