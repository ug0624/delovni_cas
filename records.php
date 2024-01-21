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

    <h2>1. API Call: Record Arrival Time</h2>
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

    <h2>2. API Call: Record Departure Time</h2>
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

    <h2>3. API Call: Record Lunch Time</h2>
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

    <!-- Add more API calls as needed -->

</body>
</html>
