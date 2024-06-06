<?php
// Connect to database
require_once 'db_connection.php';

// Media class
class Media
{
    private $mediaId;
    private $title;
    private $format;
    private $releaseYear;
    private $author_Artist;
    private $isbn_Upc;
    private $runtime_Duration;
    private $genre;
    private $language;
    private $publisher_Label;
    private $conn;

    // Constructor
    public function __construct($mediaId, $title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label, $conn)
    {
        $this->mediaId = $mediaId;
        $this->title = $title;
        $this->format = $format;
        $this->releaseYear = $releaseYear;
        $this->author_Artist = $author_Artist;
        $this->isbn_Upc = $isbn_Upc;
        $this->runtime_Duration = $runtime_Duration;
        $this->genre = $genre;
        $this->language = $language;
        $this->publisher_Label = $publisher_Label;
        $this->conn = $conn;
    }


    // Method to add new media
    public function createMedia($title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label, $conn)
    {
        // Query to insert media into database
        $sql = "INSERT INTO media (Title, Format, ReleaseYear, Author_Artist, ISBN_UPC, Runtime_Duration, Genre, Language, Publisher_Label) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssissssss", $title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label);
            if ($stmt->execute()) {
                // Return MediaID
                return $stmt->insert_id;
            } else {
                $stmt->close();
                return "Error adding media: " . $stmt->error;
            }
        } else {
            return "Error executing database query.";
        }
    }

    // Method to edit media
    public function editMedia($mediaid, $title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label, $conn)
    {
        // Prepare query
        $sql = "UPDATE media SET Title=?, Format=?, ReleaseYear=?, Author_Artist=?, ISBN_UPC=?, Runtime_Duration=?, Genre=?, Language=?, Publisher_Label=? WHERE MediaID=?";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissssssi", $title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label, $mediaid);
        $success = $stmt->execute();
        $stmt->close();

        // Add echo statements to check success
        if ($success) {
            echo "Media updated successfully!";
        } else {
            echo "Failed to update media.";
        }
        return $success;
    }

    // Method to delete media
    public function deleteMedia($mediaId)
    {
        // Prepare SQL statement to delete media from media table and associated entries from mediatocollection, ownership, and rating review tables
        $sql = "DELETE FROM ownership WHERE MediaID = ?";
        $sql2 = "DELETE FROM mediatocollection WHERE MediaID = ?";
        $sql3 = "DELETE FROM ratingreview WHERE MediaID = ?";
        $sql4 = "DELETE FROM media WHERE MediaID = ?";


        // Prepare and execute statements
        $stmt = $this->conn->prepare($sql);
        $stmt2 = $this->conn->prepare($sql2);
        $stmt3 = $this->conn->prepare($sql3);
        $stmt4 = $this->conn->prepare($sql4);
        $stmt->bind_param("i", $mediaId);
        $stmt2->bind_param("i", $mediaId);
        $stmt3->bind_param("i", $mediaId);
        $stmt4->bind_param("i", $mediaId);

        // Execute statements
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();

        // Check if deletion was successful
        if ($stmt->affected_rows > 0 && $stmt2->affected_rows > 0 && $stmt3->affected_rows > 0 && $stmt4->affected_rows > 0) {
            return true; // Deletion successful
        } else {
            $stmt->close();
            $stmt2->close();
            $stmt3->close();
            $stmt4->close();
            return false; // Deletion failed
        }
    }



    // Method to retrieve media by profile ownership
    public function getMediaByOwnership($profileId, $conn)
    {
        // Query to select media by ownership
        $sql = "SELECT m.* FROM media m INNER JOIN ownership o ON m.MediaID = o.MediaID WHERE o.ProfileID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $profileId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $media = [];
                while ($row = $result->fetch_assoc()) {
                    $media[] = $row;
                }
                // Return result
                return $media;
            } else {
                $stmt->close();
                return "Error retrieving media by ownership: " . $stmt->error;
            }
        } else {
            return "Error executing database query.";
        }
    }

    // Method to get media by ID
    public function getMediaById($mediaId, $conn)
    {
        // Prepare SQL statement to retrieve media by id
        $sql = "SELECT * FROM media WHERE MediaID = ?";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $mediaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $media = $result->fetch_assoc();
        $stmt->close();

        // Return result
        return $media;
    }


    // Method to get media based on collection id
    public function getMediaByCollectionId($collectionId)
    {
        // Prepare SQL statement to retrieve media associated with collection id
        $sql = "SELECT m.* FROM media m
                INNER JOIN mediatocollection mc ON m.MediaID = mc.MediaID
                WHERE mc.CollectionID = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            // If fails return null
            return null;
        }

        // Bind the collection id to the statement
        $stmt->bind_param("i", $collectionId);

        // Execute statement
        if (!$stmt->execute()) {
            // If fails return null
            return null;
        }

        // Get result set
        $result = $stmt->get_result();

        // Fetch media records from result set
        $mediaList = [];
        while ($row = $result->fetch_assoc()) {
            $mediaList[] = $row;
        }

        $stmt->close();

        // Return list of media associated with collection ID
        return $mediaList;
    }
}