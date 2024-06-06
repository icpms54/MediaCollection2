<?php
// Ownershipp class
class Ownership
{
    public $UserMediaID;
    public $ProfileID;
    public $MediaID;
    public $PurchaseDate;
    public $PurchasePrice;
    public $ItemCondition;
    public $Notes;
    private $conn;

    // Constructor
    public function __construct($UserMediaID, $ProfileID, $MediaID, $PurchaseDate, $PurchasePrice, $ItemCondition, $Notes, $conn)
    {
        $this->UserMediaID = $UserMediaID;
        $this->ProfileID = $ProfileID;
        $this->MediaID = $MediaID;
        $this->PurchaseDate = $PurchaseDate;
        $this->PurchasePrice = $PurchasePrice;
        $this->ItemCondition = $ItemCondition;
        $this->Notes = $Notes;
        $this->conn = $conn;
    }

    // Method to assign ownership of a piece of media to a profile
    public function assignOwnership($profileId, $mediaId, $purchaseDate, $purchasePrice, $itemCondition, $notes, $conn)
    {
        // Query to insert ownership data into database
        $query = "INSERT INTO ownership (ProfileID, MediaID, PurchaseDate, PurchasePrice, ItemCondition, Notes) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissds", $profileId, $mediaId, $purchaseDate, $purchasePrice, $itemCondition, $notes);

        if ($stmt->execute()) {
            // Ownership assigned successfully
            return true;
        } else {
            // Error occurred while assigning ownership
            return false;
        }
    }

    // Method to edit ownership details
    public function editOwnership($purchaseDate, $purchasePrice, $itemCondition, $notes, $mediaId, $conn)
    {
        // Prepare SQL statement to update ownership details
        $sql = "UPDATE ownership SET PurchaseDate=?, PurchasePrice=?, ItemCondition=?, Notes=? WHERE MediaID=?";

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $purchaseDate, $purchasePrice, $itemCondition, $notes, $mediaId);
        $success = $stmt->execute();
        $stmt->close();

        // Echo statements to check success
        if ($success) {
            echo "Ownership details updated successfully!";
        } else {
            echo "Failed to update ownership details.";
        }

        return $success;
    }

}