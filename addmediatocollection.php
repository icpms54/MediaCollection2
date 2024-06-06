<?php
// Connect to database, collection, and media pages
require_once 'db_connection.php';
require_once 'collection.php';
require_once 'media.php';


// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}

// Check if collection id is set
if (isset($_GET['collectionId'])) {
    $collectionId = $_GET['collectionId'];
}

// create new collection object
$collection = new Collection(null, null, null, null, $conn);
// create new media object
$media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

// Method to add media to collection
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if media id is selected
    if (isset($_POST['mediaId'])) {
        $mediaIds = $_POST['mediaId'];

        // Add media to collection
        $result = $collection->addMediaToCollection($collectionId, $mediaIds);

        if ($result) {
            // Redirect
            header("Location: viewcollection.php?collectionId=$collectionId");
            exit;
        } else {
            // Handle error
            echo "Error adding media to collection.";
        }
    } else {
        // No media selected
        echo "Please select at least one media item.";
    }
}
// Retrieve list of media associated with user
$mediaList = $media->getMediaByOwnership($profileId, $conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Media to Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Media to Collection</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="mediaSelect" class="form-label">Select Media to Add:</label>
                <!-- List media options -->
                <select class="form-select" id="mediaSelect" name="mediaId[]" multiple required>
                    <?php foreach ($mediaList as $mediaItem) { ?>
                        <option value="<?php echo $mediaItem['MediaID']; ?>"><?php echo $mediaItem['Title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- Pass collection id -->
            <input type="hidden" name="collectionId" value="<?php echo $collectionId; ?>">
            <button type="submit" class="btn btn-primary">Add Selected Media</button>
            <a href="mycollection.php" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</body>

</html>