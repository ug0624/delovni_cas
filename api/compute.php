<?php

// Include the database connection file
include 'db_connection.php';

// API response format
$response = array();

$data = json_decode(file_get_contents('php://input'), true);

if (!validateToken($data, $conn)) {
    http_response_code(401);
    $response['success'] = false;
    $response['message'] = 'Invalid or expired token.';
    echo json_encode($response);
    exit;
}


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the action parameter is set to 'hours'
    if (!empty($_GET['action']) && $_GET['action'] === 'hours') {
        compute_hours($data);
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Invalid action parameter.';
        echo json_encode($response);
        exit();
    }
} else {
    http_response_code(405);
    $response['success'] = false;
    $response['message'] = 'Invalid request method. Only POST requests are allowed.';
    echo json_encode($response);
    exit();
}

// Function to validate the token
function validateToken($data, $conn) {
    // Ensure $data has the necessary information
    if (!isset($data['token'], $data['employee_id'])) {
        return false;
    }

    // Sanitize input data
    $token = $conn->real_escape_string($data['token']);
    $employee_id = intval($data['employee_id']);

    // Retrieve token and expiration from the database
    $sql = "SELECT token, token_expiration FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);


    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Debug: Output the retrieved expiration time and current time
            echo 'Token Expiration: ' . $row['token_expiration'] . '<br>';
            echo 'Current Time: ' . time() . '<br>';

            // Before the return statement in validateToken function
            echo "Database Token: " . $row['token'] . "<br>";
            echo "Database Expiration: " . $row['token_expiration'] . "<br>";
            echo "Input Token: " . $token . "<br>";
            echo "Current Time: " . time() . "<br>";


            // Compare token and check expiration
            if ($row['token'] === $token && $row['token_expiration'] >= time()) {
                return true; // Token is valid
            }
        }
    }

    return false; // Token is invalid
}


// Function to compute hours worked
function compute_hours($data)
{
    global $conn;
    global $response;

    // Validate required fields for computing hours
    if (isset($data['employee_id'], $data['start_date'], $data['end_date'])) {
        // Sanitize input data
        $employee_id = $conn->real_escape_string($data['employee_id']);
        $start_date = $conn->real_escape_string($data['start_date']);
        $end_date = $conn->real_escape_string($data['end_date']);

        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT arrival_time, departure_time FROM arrival_times 
                LEFT JOIN departure_times ON arrival_times.employee_id = departure_times.employee_id 
                WHERE arrival_times.employee_id = ? AND arrival_time BETWEEN ? AND ?";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("iss", $employee_id, $start_date, $end_date);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();

        // Process the result
        $hours_worked = 0;
        while ($row = $result->fetch_assoc()) {
            // Process each row, compute hours worked (you'll need to adjust this part based on your data structure)
            $arrival_time = strtotime($row['arrival_time']);
            $departure_time = strtotime($row['departure_time']);
            $hours_worked += ($departure_time - $arrival_time) / 3600; // Convert seconds to hours
        }

        // Set response
        $response['success'] = true;
        $response['message'] = 'Hours computed successfully.';
        $response['data'] = array(
            'employee_id' => $employee_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'hours_worked' => $hours_worked
        );

        // Close the statement
        $stmt->close();
    } else {
        // Missing required parameters for computing hours
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for computing hours.';
    }

    // Return JSON response
    echo json_encode($response);
}


?>
