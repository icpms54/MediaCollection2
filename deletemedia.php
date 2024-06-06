<?php
// Connect to database, media, and collection pages
require_once 'db_connection.php';
require_once 'media.php';
require_once 'collection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input for media deletion
    $mediaId = $_POST["mediaId"];

    // Create new media object
    $media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

    // Call deleteMedia method with media id
    $success = $media->deleteMedia($mediaId);

    if ($success) {
        // Redirect
        header("Location: mediaselectionpage.php");
        exit;
    } else {
        header("Location: mediaselectionpage.php");
    }
}