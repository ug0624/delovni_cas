<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee API Documentation</title>
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

    <h1>Employee API Documentation</h1>

    <h2>1. API Call: Create Employee</h2>
    <p>Endpoint: <code>POST /delovni_cas/api/employee.php?action=create</code></p>
    <p>Description: Creates a new employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>first_name</code> (string): First name of the employee.</li>
        <li><code>last_name</code> (string): Last name of the employee.</li>
        <li><code>position</code> (string): Position of the employee.</li>
        <li><code>email</code> (string): Email address of the employee.</li>
        <li><code>password</code> (string): Password for the employee account.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/employee.php?action=create HTTP/1.1
Content-Type: application/json

{
    "first_name": "John",
    "last_name": "Doe",
    "position": "Developer",
    "email": "john.doe@example.com",
    "password": "securepassword"
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
    "message": "Employee created successfully."
}
        </code>
    </pre>

    <h2>2. API Call: Employee Login</h2>
    <p>Endpoint: <code>POST /delovni_cas/api/employee.php?action=login</code></p>
    <p>Description: Authenticates an employee.</p>
    <p>Parameters:</p>
    <ul>
        <li><code>email</code> (string): Email address of the employee.</li>
        <li><code>password</code> (string): Password for the employee account.</li>
    </ul>
    <p>Example Request:</p>
    <pre>
        <code>
POST /delovni_cas/api/employee.php?action=login HTTP/1.1
Content-Type: application/json

{
    "email": "john.doe@example.com",
    "password": "securepassword"
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
    "message": "Login successful.",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"
}
        </code>
    </pre>

    <!-- Add more API calls as needed -->

</body>
</html>
