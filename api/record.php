<?php

// Include the database connection file
include 'db_connection.php';

// API response format
$response = array();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the action parameter is set
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case 'arrival':
                record_arrival($data);
                break;
            case 'departure':
                record_departure($data);
                break;
            case 'lunch':
                record_lunch($data);
                break;
            case 'leave':
                record_leave($data);
                break;
            default:
                http_response_code(400);
                $response['success'] = false;
                $response['message'] = 'Invalid action parameter.';
                break;
        }
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing action parameter.';
    }
} else {
    http_response_code(405);
    $response['success'] = false;
    $response['message'] = 'Invalid request method. Only POST requests are allowed.';
}

// Close the database connection (this is usually not necessary as PHP automatically closes it at the end of the script)
$conn->close();

// Echo the final JSON response
echo json_encode($response);

function record_arrival($data)
{
    global $conn;
    global $response;

    // Validate required fields for arrival
    if (isset($data['employee_id'], $data['arrival_time'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);
        $arrival_time = $conn->real_escape_string($data['arrival_time']);

        // Use a prepared statement to prevent SQL injection
        $sql = "INSERT INTO arrival_times (employee_id, arrival_time) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("is", $employee_id, $arrival_time);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(201);
            $response['success'] = true;
            $response['message'] = 'Arrival time recorded successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error recording arrival time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error recording arrival time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for arrival.';
    }
}

function record_departure($data)
{
    global $conn;
    global $response;

    // Validate required fields for departure
    if (isset($data['employee_id'], $data['departure_time'])) {
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
            http_response_code(201);
            $response['success'] = true;
            $response['message'] = 'Departure time recorded successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error recording departure time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error recording departure time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for departure.';
    }
}

function record_lunch($data)
{
    global $conn;
    global $response;

    // Validate required fields for lunch
    if (isset($data['employee_id'], $data['lunch_date'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);
        $lunch_date = $conn->real_escape_string($data['lunch_date']);

        // Insert lunch record into the database
        $sql = "INSERT INTO lunch_records (employee_id, lunch_date) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("is", $employee_id, $lunch_date);

        if ($stmt->execute()) {
            http_response_code(201);
            $response['success'] = true;
            $response['message'] = 'Lunch time recorded successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error recording lunch time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error recording lunch time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for lunch.';
    }
}

function record_leave($data)
{
    global $conn;
    global $response;

    // Validate required fields for leave
    if (isset($data['employee_id'], $data['leave_date'], $data['leave_type'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);
        $leave_date = $conn->real_escape_string($data['leave_date']);
        $leave_type = $conn->real_escape_string($data['leave_type']);

        // Insert leave record into the database
        $sql = "INSERT INTO leave_records (employee_id, leave_date, leave_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("iss", $employee_id, $leave_date, $leave_type);

        if ($stmt->execute()) {
            http_response_code(201);
            $response['success'] = true;
            $response['message'] = 'Leave recorded successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error recording leave: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error recording leave: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for leave.';
    }
}

?>
