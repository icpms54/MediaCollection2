<?php
// Connect to database
require_once 'db_connection.php';

// User Class
class User
{
    private $profileId;
    private $username;
    private $email;
    private $password;
    private $conn;

    // Constructor
    public function __construct($profileId, $username, $email, $password, $conn)
    {
        $this->userId = $profileId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->conn = $conn;
    }

    // Login method
    public function login($inputUsername, $inputPassword)
    {
        // Validate input
        if (empty($inputUsername) || empty($inputPassword)) {
            echo "Username and password are required.";
        } else {
            // Query to check for user
            $sql = "SELECT * FROM profile WHERE Username = ?";

            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("s", $inputUsername);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {

                    // If user is found
                    $row = $result->fetch_assoc();
                    if (password_verify($inputPassword, $row["Password"])) {
                        // If password is correct set session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["Username"] = $inputUsername;
                        $_SESSION["ProfileID"] = $row["ProfileID"];
                        // Redirect to welcome page
                        header("Location: welcome.php");
                        exit;
                    } else {
                        echo "Invalid password.";
                    }
                } else {
                    echo "Invalid username.";
                }
                $stmt->close();
            } else {
                echo "Error executing database query.";
            }
        }
        $this->conn->close();
    }

    // Method to create a new profile
    function createProfile($username, $email, $password, $firstName, $lastName, $dob, $conn)
    {
        // Check for and validate input
        if (empty($username) || empty($email) || empty($password) || empty($firstName) || empty($lastName) || empty($dob)) {
            return "All fields are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }

        // Check if username or email already exist in database
        $checkQuery = "SELECT * FROM profile WHERE username = ? OR email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            return "Username or email already exists.";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into database
        $insertQuery = "INSERT INTO profile (username, email, password, firstName, lastName, dob) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssssss", $username, $email, $hashedPassword, $firstName, $lastName, $dob);

        if ($insertStmt->execute()) {
            // Redirect to have user login with new account
            header("Location: login.php");
            exit;
        } else {
            return "Error registering user: " . $conn->error;
        }
    }


    // Method to logout
    public function logout()
    {
        // Unset session variables
        session_unset();
        // Destroy the session
        session_destroy();

        // Redirect to homepage
        header("Location: index.php");
        exit;
    }

    //method to edit profile. Work in progress
    public function editProfile($profileId, $newFirstName, $newLastName, $newDOB, $conn)
    {
        // Query to update profile info
        $query = "UPDATE profile SET FirstName = ?, LastName = ?, DOB = ? WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $newFirstName, $newLastName, $newDOB, $profileId);

        $success = $stmt->execute();

        // Return if successful
        return $success;
    }

    // Method to change password
    public function changePassword($profileId, $currentPassword, $newPassword, $conn)
    {
        // Query to retrieve password
        $query = "SELECT Password FROM profile WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        // If found store password
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $currentHashedPassword = $row['Password'];

            // Check that password matches password in database
            if (password_verify($currentPassword, $currentHashedPassword)) {
                // Hash new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // Query to update password
                $updateQuery = "UPDATE profile SET Password = ? WHERE ProfileID = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $newHashedPassword, $profileId);

                if ($updateStmt->execute()) {
                    // Password updated successfully
                    return true;
                } else {
                    // Error occurred while updating the password
                    return false;
                }
            } else {
                // Current password is incorrect
                return false;
            }
        } else {
            // Profile not found
            return false;
        }
    }

    // Method to delete account
    public function deleteAccount($profileId, $conn)
    {
        // Delete data from mediatocollection table
        $deleteMediaToCollectionQuery = "DELETE FROM MediaToCollection WHERE CollectionID IN 
                                    (SELECT CollectionID FROM Collection WHERE ProfileID = ?)";
        $deleteMediaToCollectionStmt = $conn->prepare($deleteMediaToCollectionQuery);
        $deleteMediaToCollectionStmt->bind_param("i", $profileId);
        $deleteMediaToCollectionStmt->execute();

        // Delete data from collection table
        $deleteCollectionQuery = "DELETE FROM collection WHERE ProfileID = ?";
        $deleteCollectionStmt = $conn->prepare($deleteCollectionQuery);
        $deleteCollectionStmt->bind_param("i", $profileId);
        $deleteCollectionStmt->execute();

        // Delete data from ownership table
        $deleteOwnershipQuery = "DELETE FROM ownership WHERE ProfileID = ?";
        $deleteOwnershipStmt = $conn->prepare($deleteOwnershipQuery);
        $deleteOwnershipStmt->bind_param("i", $profileId);
        $deleteOwnershipStmt->execute();

        // Delete data from ratingreview table
        $deleteRatingReviewQuery = "DELETE FROM RatingReview WHERE ProfileID = ?";
        $deleteRatingReviewStmt = $conn->prepare($deleteRatingReviewQuery);
        $deleteRatingReviewStmt->bind_param("i", $profileId);
        $deleteRatingReviewStmt->execute();

        // Delete the profile itself from profile table
        $deleteProfileQuery = "DELETE FROM Profile WHERE ProfileID = ?";
        $deleteProfileStmt = $conn->prepare($deleteProfileQuery);
        $deleteProfileStmt->bind_param("i", $profileId);
        $deleteProfileStmt->execute();

        // Check if deletion was successful
        if ($deleteProfileStmt->affected_rows > 0) {
            // Deletion successful destroy session
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;
        } else {
            // Deletion failed
            return false;
        }
    }

    // Getter for first name
    public function getFirstName($profileId, $conn)
    {
        // Query to retrieve first name
        $query = "SELECT FirstName FROM profile WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if name is found
        if ($result->num_rows > 0) {
            // Return first name
            $firstName = $result->fetch_assoc()['FirstName'];
            return $firstName;
        } else {
            return null;
        }
    }

    // Getter for last name
    public function getLastName($profileId, $conn)
    {
        // Query to retrieve last name
        $query = "SELECT LastName FROM profile WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if name is found
        if ($result->num_rows > 0) {
            // Return last name
            $lastName = $result->fetch_assoc()['LastName'];
            return $lastName;
        } else {
            return null;
        }
    }

    // Getter for date of birth
    public function getDOB($profileId, $conn)
    {
        // Query to retrieve DOB
        $query = "SELECT DOB FROM profile WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if dob is found
        if ($result->num_rows > 0) {
            // Return dob
            $dob = $result->fetch_assoc()['DOB'];
            return $dob;
        } else {
            return null;
        }
    }

    // Getter for username
    public function getUsername($profileId, $conn)
    {
        // Query to retrieve username
        $query = "SELECT Username FROM profile WHERE ProfileID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profileId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if username is found
        if ($result->num_rows > 0) {
            // Return username
            $username = $result->fetch_assoc()['Username'];
            return $username;
        } else {
            return null;
        }
    }
}