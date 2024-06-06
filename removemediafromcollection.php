<?php
// Connect to database, collection, and media pages
require_once 'db_connection.php';
require_once 'collection.php';
require_once 'media.php';

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // Redirect to login page if not logged in
    header("location: login.php");
    exit;
}

// Check if collection id is set
if (isset($_GET['collectionId'])) {
    $collectionId = $_GET['collectionId'];
}

// Create new collection and media objects
$collection = new Collection(null, null, null, null, $conn);
$media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

// If posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if media id is selected
    if (isset($_POST['mediaId'])) {
        $mediaIds = $_POST['mediaId'];

        // Access method to remove media from collection
        $result = $collection->removeMediaFromCollection($collectionId, $mediaIds);

        if ($result) {
            // Redirect if successful
            header("Location: viewcollection.php?collectionId=$collectionId");
            exit;
        } else {
            // Handle error
            echo "Error removing media from collection.";
        }
    } else {
        // No media selected
        echo "Please select at least one media item.";
    }
}

// Retrieve media associated with collection
$mediaList = $media->getMediaByCollectionId($collectionId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Media Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Media in Collection</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="mediaSelect" class="form-label">Media in Collection:</label>
                <ul class="list-group">
                    <!-- List media in collection -->
                    <?php foreach ($mediaList as $mediaItem) { ?>
                        <li class="list-group-item">
                            <?php echo $mediaItem['Title']; ?>
                            <!-- Remove media from collection -->
                            <button type="submit" name="mediaId[]" value="<?php echo $mediaItem['MediaID']; ?>"
                                class="btn btn-danger btn-sm float-end">Remove</button>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Pass collection id -->
            <input type="hidden" name="collectionId" value="<?php echo $collectionId; ?>">
            <a href="mycollection.php" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</body>

</html>