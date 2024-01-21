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

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: index.php");
    exit();
}
?>

    <h1>Work Time Tracking API Documentation</h1>

    <h2>API Call: Compute Hours Worked</h2>
    <p>Endpoint: <code>POST /delovni_cas/api/compute.php?action=hours</code></p>
    <p>Description: Computes the total hours worked by an employee between a specified start date and end date.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>employee_id</code> (integer): ID of the employee.</li>
        <li><code>start_date</code> (date): Start date in the format "YYYY-MM-DD".</li>
        <li><code>end_date</code> (date): End date in the format "YYYY-MM-DD".</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/compute.php?action=hours HTTP/1.1
Content-Type: application/json

{
    "employee_id": 1,
    "start_date": "2024-01-01",
    "end_date": "2024-01-31"
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
    "message": "Hours computed successfully.",
    "data": {
        "employee_id": 1,
        "start_date": "2024-01-01",
        "end_date": "2024-01-31",
        "total_hours": 80.5
    }
}
        </code>
    </pre>


</body>
</html>
