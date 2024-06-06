<?php
// Connect to database and rating page
require_once 'db_connection.php';
require_once 'ratingreview.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}

// Check if media id is present
if (isset($_POST['mediaId'])) {
    $mediaId = $_POST['mediaId'];

    // Create new RatingReview object
    $ratingReview = new RatingReview(null, null, null, null, null, $conn);

    // Check if the user has a review for this media
    $userReviewDetails = $ratingReview->getRatingReviewByMediaId($mediaId, $profileId, $conn);

    // If user has a review delete it
    if ($userReviewDetails['Rating'] !== null && $userReviewDetails['Review'] !== null) {
        $success = $ratingReview->deleteRatingReview($mediaId, $profileId, $conn);
        if ($success) {
            // Redirect if successful
            header("Location: viewmedia.php?mediaId=$mediaId");
            exit;
        } else {
            echo "Failed to delete review.";
        }
    } else {
        // If the user does not have a review, display a message
        echo "No review to delete.";
    }
} else {
    // Handle the case where mediaId is not provided
    echo "Media ID not provided.";
}
?>