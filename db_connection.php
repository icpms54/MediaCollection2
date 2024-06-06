<?php
/*
// Start session
session_start();

// Configure database
$host = 'localhost'; // host
$dbUsername = 'root'; // username (default)
$dbPassword = ''; // password (empty)
$dbName = 'mymediacollection'; // name

// Create new MySQLi instance for database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/




// Start session
session_start();

// Configure database
$host = 'mysql'; // host
$dbUsername = 'root'; // username (default)
$dbPassword = ''; // password (empty)
$dbName = 'mymediacollection'; // name
$dbPort = 3306; // port

// Create new MySQLi instance for database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName, $dbPort);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>