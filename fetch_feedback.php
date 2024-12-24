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

// Query to fetch feedback records
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

$feedback = [];

// Fetch data if the query was successful
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
}

// Return feedback as JSON
header('Content-Type: application/json');
echo json_encode($feedback);

// Close the connection
$conn->close();
?>
