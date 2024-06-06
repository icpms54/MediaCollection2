<?php
// Connect to database
require_once 'db_connection.php';

// RatingReview class
class RatingReview
{
    private $ratingId;
    private $profileId;
    private $mediaId;
    private $rating;
    private $review;
    private $conn;


    // Constructor
    public function __construct($ratingId, $profileId, $mediaId, $rating, $review, $conn)
    {
        $this->ratingId = $ratingId;
        $this->profileId = $profileId;
        $this->mediaId = $mediaId;
        $this->rating = $rating;
        $this->review = $review;
        $this->conn = $conn;
    }

    // Method for adding a review of a piece of media
    public function addRatingReview($mediaId, $profileId, $rating, $review, $conn)
    {
        // Prepare query
        $sql = "INSERT INTO ratingreview (MediaID, ProfileID, Rating, Review) VALUES (?, ?, ?, ?)";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $mediaId, $profileId, $rating, $review);
        $success = $stmt->execute();
        $stmt->close();

        // Return if successful
        return $success;
    }

    // Method for editing a review of a piece of media
    public function editRatingReview($mediaId, $profileId, $rating, $review, $conn)
    {
        // Prepare query
        $sql = "UPDATE ratingreview SET Rating = ?, Review = ? WHERE MediaID = ? AND ProfileID = ?";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issi", $rating, $review, $mediaId, $profileId);
        $success = $stmt->execute();

        // Return if successful
        return $success;
    }

    // Method for deleting a review of a piece of media
    public function deleteRatingReview($mediaId, $profileId, $conn)
    {
        // Check if both rating and review are filled
        $query = "SELECT Rating, Review FROM RatingReview WHERE MediaID = ? AND ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $mediaId, $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Delete review if both rating and review are filled
            $row = $result->fetch_assoc();
            $rating = $row['Rating'];
            $review = $row['Review'];

            if (!empty($rating) && !empty($review)) {
                $deleteQuery = "DELETE FROM RatingReview WHERE MediaID = ? AND ProfileID = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("ii", $mediaId, $profileId);
                $deleteStmt->execute();

                // Check if the review is successfully deleted
                if ($deleteStmt->affected_rows > 0) {
                    return true; // Review deleted successfully
                } else {
                    return false; // Failed to delete review
                }
            }
        }
        // If rating and review are not both filled, do nothing
        return true;
    }

    // Method to retrieve ratings and reviews by associated media id
    public function getRatingReviewByMediaId($mediaId, $profileId, $conn)
    {
        // Query
        $sql = "SELECT * FROM ratingreview WHERE MediaID = ? AND ProfileID = ?";
        // Prepare and execute
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $mediaId, $profileId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        // return
        return $row;
    }
}
?>