<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db"; // Replace with the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read and decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate received data
if (!isset($data['name'], $data['email'], $data['rating'], $data['feedback'])) {
    http_response_code(400); // Bad Request
    echo "Invalid input data.";
    $conn->close();
    exit;
}

// Sanitize and prepare data
$name = $conn->real_escape_string(trim($data['name']));
$email = $conn->real_escape_string(trim($data['email']));
$rating = (int)$data['rating'];
$message = $conn->real_escape_string(trim($data['feedback']));

// Validate rating range
if ($rating < 1 || $rating > 5) {
    http_response_code(400); // Bad Request
    echo "Invalid rating. Please provide a value between 1 and 5.";
    $conn->close();
    exit;
}

// Insert feedback into the database
$sql = "INSERT INTO feedback (name, email, rating, message) VALUES ('$name', '$email', $rating, '$message')";
if ($conn->query($sql) === TRUE) {
    echo "Thank you for your feedback!";
} else {
    http_response_code(500); // Internal Server Error
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
