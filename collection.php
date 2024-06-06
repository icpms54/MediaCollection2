<?php
// Connect to database
require_once 'db_connection.php';

// Collection class
class Collection
{
    private $collectionId;
    private $profileId;
    private $name;
    private $description;
    private $conn;

    // Constructor
    public function __construct($collectionId, $profileId, $name, $description, $conn)
    {
        $this->collectionId = $collectionId;
        $this->profileId = $profileId;
        $this->name = $name;
        $this->description = $description;
        $this->conn = $conn;
    }

    // Method for creating collection
    public function createCollection($name, $description, $conn)
    {
        // If logged in
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["ProfileID"])) {
            $profileId = $_SESSION["ProfileID"];
            // Query to create new collection
            $sql = "INSERT INTO collection (profileid, name, description) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iss", $profileId, $name, $description);
                if ($stmt->execute()) {
                    header("Location: collectionselectionpage.php");
                    exit;
                } else {
                    return "Error adding collection: " . $stmt->error;
                }
                $stmt->close();
            } else {
                return "Error executing database query.";
            }
        } else {
            return "User not logged in.";
        }
    }

    // Method for editing collection
    public function editCollection($collectionId, $name, $description, $conn)
    {
        // Prepare SQL statement to update collection
        $sql = "UPDATE collection SET Name=?, Description=? WHERE CollectionID=?";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $description, $collectionId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Method for deleting collection
    public function deleteCollection($collectionId, $conn)
    {
        // Start a transaction
        $conn->begin_transaction();

        // Remove associated media from mediatocollection table
        $stmt = $conn->prepare("DELETE FROM mediatocollection WHERE CollectionID = ?");
        $stmt->bind_param("i", $collectionId);
        $mediaRemoved = $stmt->execute();
        $stmt->close();

        // If successful delete the collection
        if ($mediaRemoved) {
            $stmt = $conn->prepare("DELETE FROM collection WHERE CollectionID = ?");
            $stmt->bind_param("i", $collectionId);
            $collectionDeleted = $stmt->execute();
            $stmt->close();

            if ($collectionDeleted) {
                // If both were successful, commit the transaction
                $conn->commit();
                return true;
            } else {
                // If collection deletion failed, rollback the transaction
                $conn->rollback();
                return false;
            }
        } else {
            // If media removal failed, rollback the transaction
            $conn->rollback();
            return false;
        }
    }

    // Method for adding media to collection
    public function addMediaToCollection($collectionId, $mediaIds)
    {
        // Prepare SQL statement to insert media into collection
        $sql = "INSERT INTO mediatocollection (MediaID, CollectionID) VALUES (?, ?)";

        // Prepare and execute statement for each media id
        foreach ($mediaIds as $mediaId) {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $mediaId, $collectionId);
            $stmt->execute();
            $stmt->close();
        }
        // Check if all media were successfully added
        return true;
    }

    // Method for removing media from collection
    public function removeMediaFromCollection($collectionId, $mediaIds)
    {
        // Prepare SQL statement to delete media from collection
        $sql = "DELETE FROM mediatocollection WHERE CollectionID = ? AND MediaID IN (";
        $placeholders = rtrim(str_repeat('?, ', count($mediaIds)), ', ');
        $sql .= $placeholders . ")";

        // Bind collection id and media id to parameters
        $params = array_merge([$collectionId], $mediaIds);

        // Execute prepared statement
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($params);

        // Check if deletion was successful
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // Getter for collection by profile id
    public function getCollectionsByProfileId($profileId)
    {
        // Query for collection
        $sql = "SELECT * FROM collection WHERE profileid = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $profileId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $collections = [];
                while ($row = $result->fetch_assoc()) {
                    $collections[] = $row;
                }
                // Result
                return $collections;
            } else {
                return "Error retrieving collections: " . $stmt->error;
            }
            $stmt->close();
        } else {
            return "Error executing database query.";
        }
    }
}