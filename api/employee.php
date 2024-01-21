<?php

// Include the database connection file
include 'db_connection.php';

// API response format
$response = array();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the action parameter is set to 'create'
    if (!empty($_GET['action']) && $_GET['action'] === 'create') {
        create_employee($data);
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Invalid action parameter.';
    }
} else {
    http_response_code(405);
    $response['success'] = false;
    $response['message'] = 'Invalid request method. Only POST requests are allowed.';
}

// Close the database connection
$conn->close();

// Echo the final JSON response
echo json_encode($response);

// Function to create a new employee
function create_employee($data)
{
    global $conn;
    global $response;

    // Validate required fields
    if (isset($data['first_name'], $data['last_name'], $data['position'], $data['email'], $data['password'])) {
        // Sanitize input data
        $first_name = $conn->real_escape_string($data['first_name']);
        $last_name = $conn->real_escape_string($data['last_name']);
        $position = $conn->real_escape_string($data['position']);
        $email = $conn->real_escape_string($data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password

        // Use a prepared statement to prevent SQL injection
        $sql = "INSERT INTO employees (first_name, last_name, position, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssss", $first_name, $last_name, $position, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(201);
            $response['success'] = true;
            $response['message'] = 'Employee created successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error creating employee: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error creating employee: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for creating employee.';
    }
}

?>
