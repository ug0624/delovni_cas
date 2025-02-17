<?php

// Include the database connection file
include 'db_connection.php';

// API response format
$response = array();

// Check if the request method is PUT, POST, GET, or DELETE
$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents('php://input'), true);

if (!validateToken($data, $conn)) {
    http_response_code(401);
    $response['success'] = false;
    $response['message'] = 'Invalid or expired token.';
    echo json_encode($response);
    exit;
}


if ($method === 'PUT' || $method === 'POST' || $method === 'GET' || $method === 'DELETE') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the action parameter is set
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case 'arrival':
                if ($method === 'POST') {
                    record_arrival($data);
                } elseif ($method === 'PUT') {
                    update_arrival($data);
                } elseif ($method === 'GET') {
                    get_arrival($data);
                } elseif ($method === 'DELETE') {
                    delete_arrival($data);
                }
                break;
            case 'departure':
                if ($method === 'POST') {
                    record_departure($data);
                } elseif ($method === 'PUT') {
                    update_departure($data);
                } elseif ($method === 'GET') {
                    get_departure($data);
                } elseif ($method === 'DELETE') {
                    delete_departure($data);
                }
                break;
            case 'lunch':
                if ($method === 'POST') {
                    record_lunch($data);
                } elseif ($method === 'PUT') {
                    update_lunch($data);
                } elseif ($method === 'GET') {
                    get_lunch($data);
                } elseif ($method === 'DELETE') {
                    delete_lunch($data);
                }
                break;
            case 'leave':
                if ($method === 'POST') {
                    record_leave($data);
                } elseif ($method === 'PUT') {
                    update_leave($data);
                } elseif ($method === 'GET') {
                    get_leave($data);
                } elseif ($method === 'DELETE') {
                    delete_leave($data);
                }
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
    $response['message'] = 'Invalid request method. Only PUT, POST, GET, and DELETE requests are allowed.';
}


// Close the database connection (this is usually not necessary as PHP automatically closes it at the end of the script)
$conn->close();

// Echo the final JSON response
echo json_encode($response);


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



#:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
#Funcije za vpis podatkov

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


#:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
#Funcije za posodabljanje podatkov

function update_arrival($data)
{
    global $conn;
    global $response;

    // Validate required fields for updating arrival
    if (isset($data['arrival_id'], $data['arrival_time'])) {
        // Sanitize input data
        $arrival_id = intval($data['arrival_id']);
        $arrival_time = $conn->real_escape_string($data['arrival_time']);

        // Use a prepared statement to prevent SQL injection
        $sql = "UPDATE arrival_times SET arrival_time = ? WHERE arrival_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("si", $arrival_time, $arrival_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Arrival time updated successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error updating arrival time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('SQL Query: ' . $sql);
            error_log('Error updating arrival time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for updating arrival.';
    }
}

function update_departure($data)
{
    global $conn;
    global $response;

    // Validate required fields for updating departure
    if (isset($data['departure_id'], $data['departure_time'])) {
        // Sanitize input data
        $departure_id = intval($data['departure_id']);
        $departure_time = $conn->real_escape_string($data['departure_time']);

        // Use a prepared statement to prevent SQL injection
        $sql = "UPDATE departure_times SET departure_time = ? WHERE departure_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("si", $departure_time, $departure_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Departure time updated successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error updating departure time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error updating departure time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for updating departure.';
    }
}

function update_lunch($data)
{
    global $conn;
    global $response;

    // Validate required fields for updating lunch
    if (isset($data['lunch_id'], $data['lunch_date'])) {
        // Sanitize input data
        $lunch_id = intval($data['lunch_id']);
        $lunch_date = $conn->real_escape_string($data['lunch_date']);

        // Use a prepared statement to prevent SQL injection
        $sql = "UPDATE lunch_records SET lunch_date = ? WHERE lunch_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("si", $lunch_date, $lunch_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Lunch time updated successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error updating lunch time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error updating lunch time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for updating lunch.';
    }
}

function update_leave($data)
{
    global $conn;
    global $response;

    // Validate required fields for updating leave
    if (isset($data['leave_id'], $data['leave_date'], $data['leave_type'])) {
        // Sanitize input data
        $leave_id = intval($data['leave_id']);
        $leave_date = $conn->real_escape_string($data['leave_date']);
        $leave_type = $conn->real_escape_string($data['leave_type']);

        // Use a prepared statement to prevent SQL injection
        $sql = "UPDATE leave_records SET leave_date = ?, leave_type = ? WHERE leave_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssi", $leave_date, $leave_type, $leave_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Leave updated successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error updating leave: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error updating leave: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for updating leave.';
    }
}

#:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
#Funcije za brisanje podatkov


function delete_arrival($data)
{
    global $conn;
    global $response;

    // Validate required fields for deleting arrival
    if (isset($data['arrival_id'])) {
        // Sanitize input data
        $arrival_id = intval($data['arrival_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "DELETE FROM arrival_times WHERE arrival_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $arrival_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Arrival time deleted successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error deleting arrival time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('SQL Query: ' . $sql);
            error_log('Error deleting arrival time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for deleting arrival.';
    }
}

function delete_departure($data)
{
    global $conn;
    global $response;

    // Validate required fields for deleting departure
    if (isset($data['departure_id'])) {
        // Sanitize input data
        $departure_id = intval($data['departure_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "DELETE FROM departure_times WHERE departure_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $departure_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Departure time deleted successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error deleting departure time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('SQL Query: ' . $sql);
            error_log('Error deleting departure time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for deleting departure.';
    }
}

function delete_lunch($data)
{
    global $conn;
    global $response;

    // Validate required fields for deleting lunch
    if (isset($data['lunch_id'])) {
        // Sanitize input data
        $lunch_id = intval($data['lunch_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "DELETE FROM lunch_records WHERE lunch_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $lunch_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Lunch time deleted successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error deleting lunch time: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('SQL Query: ' . $sql);
            error_log('Error deleting lunch time: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for deleting lunch.';
    }
}

function delete_leave($data)
{
    global $conn;
    global $response;

    // Validate required fields for deleting leave
    if (isset($data['leave_id'])) {
        // Sanitize input data
        $leave_id = intval($data['leave_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "DELETE FROM leave_records WHERE leave_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $leave_id);

        // Execute the statement
        if ($stmt->execute()) {
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Leave deleted successfully.';
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error deleting leave: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('SQL Query: ' . $sql);
            error_log('Error deleting leave: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for deleting leave.';
    }
}


#:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
# Funcije za pridobivanje vseh prihodov povezanih z določenim zaposlenim (GET method)

function get_arrival($data)
{
    global $conn;
    global $response;

    // Validate required field for fetching arrival records
    if (isset($data['employee_id'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT arrival_id, arrival_time FROM arrival_times WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $employee_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            // Fetch all records and store them in an array
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }

            // Respond with the fetched records in JSON format
            http_response_code(200);
            $response['success'] = true;
            $response['message'] = 'Arrival records fetched successfully.';
            $response['data'] = $records;
        } else {
            http_response_code(400);
            $response['success'] = false;
            $response['message'] = 'Error fetching arrival records: ' . $stmt->error;
            // Log the actual error for debugging purposes
            error_log('Error fetching arrival records: ' . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameter for fetching arrival records.';
    }
}

function get_departure($data)
{
    global $conn;
    global $response;

    // Validate required fields for fetching departure records
    if (isset($data['employee_id'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT * FROM departure_times WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $employee_id);

        // Execute the statement
        $stmt->execute();

        // Get the result set from the query
        $result = $stmt->get_result();

        // Fetch data as an associative array
        $records = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Prepare response
        $response['success'] = true;
        $response['message'] = 'Departure records fetched successfully.';
        $response['data'] = $records;
    } else {
        // Missing required parameters
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for fetching departure records.';
    }
}

function get_lunch($data)
{
    global $conn;
    global $response;

    // Validate required fields for fetching lunch records
    if (isset($data['employee_id'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT * FROM lunch_records WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $employee_id);

        // Execute the statement
        $stmt->execute();

        // Get the result set from the query
        $result = $stmt->get_result();

        // Fetch data as an associative array
        $records = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Prepare response
        $response['success'] = true;
        $response['message'] = 'Lunch records fetched successfully.';
        $response['data'] = $records;
    } else {
        // Missing required parameters
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for fetching lunch records.';
    }
}

function get_leave($data)
{
    global $conn;
    global $response;

    // Validate required fields for fetching leave records
    if (isset($data['employee_id'])) {
        // Sanitize input data
        $employee_id = intval($data['employee_id']);

        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT * FROM leave_records WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $employee_id);

        // Execute the statement
        $stmt->execute();

        // Get the result set from the query
        $result = $stmt->get_result();

        // Fetch data as an associative array
        $records = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Prepare response
        $response['success'] = true;
        $response['message'] = 'Leave records fetched successfully.';
        $response['data'] = $records;
    } else {
        // Missing required parameters
        http_response_code(400);
        $response['success'] = false;
        $response['message'] = 'Missing required parameters for fetching leave records.';
    }
}



?>
