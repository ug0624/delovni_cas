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
    if (isset($data['employee_id']) && isset($data['arrival_time'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);
        $arrival_time = $conn->real_escape_string($data['arrival_time']);

        // Insert arrival record into the database
        $sql = "INSERT INTO arrival_times (employee_id, arrival_time) VALUES ($employee_id, '$arrival_time')";

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Arrival time recorded successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error recording arrival time: ' . $conn->error;
        }
    } else {
        $response['received_data'] = $data;
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
