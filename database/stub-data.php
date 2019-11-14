<?php
$servername = "localhost:3307";
$username = "modules";
$password = "secret";
$dbname = "modules";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = 'CREATE TABLE employees (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL
)';

if ($conn->query($sql) === TRUE) {
    echo "Table Employees created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
