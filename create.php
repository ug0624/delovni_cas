<?php
// Include the database connection file
include 'db_connection.php';

// Function to create a new user
function createUser($username, $password) {
    global $conn;

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert a new user
    $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

    if (mysqli_query($conn, $insertQuery)) {
        return true;
    } else {
        return 'Error creating user: ' . mysqli_error($conn);
    }
}

// Example: Call the function to create a user
$username = 'urban';
$password = 'Urban1350';

$result = createUser($username, $password);

if ($result === true) {
    echo 'User created successfully.';
} else {
    echo $result;
}

// Close the database connection
$conn->close();
?>
