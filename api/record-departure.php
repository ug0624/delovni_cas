<?php

// Include the database connection file
include 'db_connection.php';

// API response format
$response = array();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (isset($data['employee_id']) && isset($data['departure_time'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);
        $departure_time = $conn->real_escape_string($data['departure_time']);

        // Use a prepared statement to prevent SQL injection
        $sql = "INSERT INTO departure_times (employee_id, departure_time) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("is", $employee_id, $departure_time);

        // Execute the statement
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Departure time recorded successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error recording departure time: ' . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['message'] = 'Missing required parameters.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method. Only POST requests are allowed.';
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection (this is usually not necessary as PHP automatically closes it at the end of the script)
$conn->close();

?>
