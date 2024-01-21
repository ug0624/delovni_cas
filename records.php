<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Time Tracking API Documentation</title>
    <link rel="icon" href="data/time.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2 {
            color: #333;
        }

        code {
            background-color: #f4f4f4;
            padding: 6px;
            border: 1px solid #ddd;
            display: block;
            margin: 10px 0;
        }

        pre {
            white-space: pre-wrap;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <?php
    // Start the session
    session_start();
    
    // Check if the user is not logged in, redirect to login page
    if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
        header("Location: index.php");
        exit();
    }
    ?>


    <h1>Work Time Tracking API Documentation</h1>

    <h2>1. API Calls for Recording Time Events</h2>

    <h3>1.1 Record Arrival Time</h3>
    <p>Endpoint: <code>POST /delovni_cas/api/record.php?action=arrival</code></p>
    <p>Description: Records the arrival time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
        <li><code>arrival_time</code> (datetime): Arrival time in the format "YYYY-MM-DD HH:MM:SS".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/record.php?action=arrival HTTP/1.1
Content-Type: application/json

{
    "employee_id": 1,
    "arrival_time": "2024-01-19 09:00:00"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 201 Created
Content-Type: application/json

{
    "success": true,
    "message": "Arrival time recorded successfully."
}
        </code>
    </pre>

    <h3>1.2 Record Departure Time</h3>
    <p>Endpoint: <code>POST /delovni_cas/api/record.php?action=departure</code></p>
    <p>Description: Records the departure time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
        <li><code>departure_time</code> (datetime): Departure time in the format "YYYY-MM-DD HH:MM:SS".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/record.php?action=departure HTTP/1.1
Content-Type: application/json

{
    "employee_id": 1,
    "departure_time": "2024-01-19 17:00:00"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 201 Created
Content-Type: application/json

{
    "success": true,
    "message": "Departure time recorded successfully."
}
        </code>
    </pre>

    <h3>1.3 Record Lunch Time</h3>
    <p>Endpoint: <code>POST /delovni_cas/api/record.php?action=lunch</code></p>
    <p>Description: Records the lunch time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
        <li><code>lunch_date</code> (date): Lunch date in the format "YYYY-MM-DD".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/record.php?action=lunch HTTP/1.1
Content-Type: application/json

{
    "employee_id": 1,
    "lunch_date": "2024-01-19"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 201 Created
Content-Type: application/json

{
    "success": true,
    "message": "Lunch time recorded successfully."
}
        </code>
    </pre>

    <h3>1.4 Record Leave</h3>
    <p>Endpoint: <code>POST /delovni_cas/api/record.php?action=leave</code></p>
    <p>Description: Records the leave of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
        <li><code>leave_date</code> (date): Leave date in the format "YYYY-MM-DD".</li>
        <li><code>leave_type</code> (string): Type of leave (e.g., "vacation", "sick leave").</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/record.php?action=leave HTTP/1.1
Content-Type: application/json

{
    "employee_id": 1,
    "leave_date": "2024-01-20",
    "leave_type": "vacation"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 201 Created
Content-Type: application/json

{
    "success": true,
    "message": "Leave recorded successfully."
}
        </code>
    </pre>

    <h2>2. API Calls for Updating Time Events</h2>

    <h3>2.1 Update Arrival Time</h3>
    <p>Endpoint: <code>PUT /delovni_cas/api/record.php?action=update_arrival</code></p>
    <p>Description: Updates the arrival time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>arrival_id</code> (integer): ID of the arrival record.</li>
        <li><code>arrival_time</code> (datetime): New arrival time in the format "YYYY-MM-DD HH:MM:SS".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
PUT /delovni_cas/api/record.php?action=update_arrival HTTP/1.1
Content-Type: application/json

{
    "arrival_id": 1,
    "arrival_time": "2024-01-19 10:00:00"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Arrival time updated successfully."
}
        </code>
    </pre>

    <h3>2.2 Update Departure Time</h3>
    <p>Endpoint: <code>PUT /delovni_cas/api/record.php?action=update_departure</code></p>
    <p>Description: Updates the departure time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>departure_id</code> (integer): ID of the departure record.</li>
        <li><code>departure_time</code> (datetime): New departure time in the format "YYYY-MM-DD HH:MM:SS".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
PUT /delovni_cas/api/record.php?action=update_departure HTTP/1.1
Content-Type: application/json

{
    "departure_id": 1,
    "departure_time": "2024-01-19 18:00:00"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Departure time updated successfully."
}
        </code>
    </pre>

    <h3>2.3 Update Lunch Time</h3>
    <p>Endpoint: <code>PUT /delovni_cas/api/record.php?action=update_lunch</code></p>
    <p>Description: Updates the lunch time of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>lunch_id</code> (integer): ID of the lunch record.</li>
        <li><code>lunch_date</code> (date): New lunch date in the format "YYYY-MM-DD".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
PUT /delovni_cas/api/record.php?action=update_lunch HTTP/1.1
Content-Type: application/json

{
    "lunch_id": 1,
    "lunch_date": "2024-01-19"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Lunch time updated successfully."
}
        </code>
    </pre>

    <h3>2.4 Update Leave</h3>
    <p>Endpoint: <code>PUT /delovni_cas/api/record.php?action=update_leave</code></p>
    <p>Description: Updates the leave record of an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>leave_id</code> (integer): ID of the leave record.</li>
        <li><code>leave_date</code> (date): New leave date in the format "YYYY-MM-DD".</li>
        <li><code>leave_type</code> (string): New type of leave (e.g., "vacation", "sick leave").</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
PUT /delovni_cas/api/record.php?action=update_leave HTTP/1.1
Content-Type: application/json

{
    "leave_id": 1,
    "leave_date": "2024-01-21",
    "leave_type": "sick leave"
}
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Leave updated successfully."
}
        </code>
    </pre>

    <!-- ... (previous HTML code) ... -->

<h2>3. API Calls for Retrieving Time Events</h2>


<h3>3.1 Get Arrival Records by Employee ID</h3>
    <p>Endpoint: <code>GET /delovni_cas/api/record.php?action=get_arrival</code></p>
    <p>Description: Retrieves arrival records associated with a specific employee ID.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
GET /delovni_cas/api/record.php?action=get_arrival&employee_id=1 HTTP/1.1
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Arrival records fetched successfully.",
    "data": [...]
}
        </code>
    </pre>



    <h3>3.2 Get Departure Records by Employee ID</h3>
    <p>Endpoint: <code>GET /delovni_cas/api/record.php?action=get_departure</code></p>
    <p>Description: Retrieves departure records associated with a specific employee ID.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
GET /delovni_cas/api/record.php?action=get_departure&employee_id=1 HTTP/1.1
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Departure records fetched successfully.",
    "data": [...]
}
        </code>
    </pre>

    <h3>3.3 Get Lunch Records by Employee ID</h3>
    <p>Endpoint: <code>GET /delovni_cas/api/record.php?action=get_lunch</code></p>
    <p>Description: Retrieves lunch records associated with a specific employee ID.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
GET /delovni_cas/api/record.php?action=get_lunch&employee_id=1 HTTP/1.1
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Lunch records fetched successfully.",
    "data": [...]
}
        </code>
    </pre>

    <h3>3.4 Get Leave Records by Employee ID</h3>
    <p>Endpoint: <code>GET /delovni_cas/api/record.php?action=get_leave</code></p>
    <p>Description: Retrieves leave records associated with a specific employee ID.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
GET /delovni_cas/api/record.php?action=get_leave&employee_id=1 HTTP/1.1
        </code>
    </pre>
    <p>Example Response:</p>
    <pre>
        <code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "success": true,
    "message": "Leave records fetched successfully.",
    "data": [...]
}
        </code>
    </pre>


</body>
</html>
