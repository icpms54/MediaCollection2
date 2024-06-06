<?php
// Connect to database and profile page
require_once 'db_connection.php';
require_once 'profile.php';

// Create new user object
$user = new User(null, null, null, null, $conn);

// Call the logout method
$user->logout();