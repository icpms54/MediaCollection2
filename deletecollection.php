<?php
// Connect to database and collection class
require_once 'db_connection.php';
require_once 'collection.php';

// Create new collection object
$collection = new Collection(null, null, null, null, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // If form is submitted
    if (isset($_POST['deleteCollection'])) {
        // Set variable
        $collectionId = $_POST['collectionId'];

        // Call deleteCollection method
        $success = $collection->deleteCollection($collectionId, $conn);

        if ($success) {
            // Redirect user to collections page
            header("Location: mycollection.php");
            exit;
        } else {
            echo "Failed to delete collection.";
        }
    }
}
?>