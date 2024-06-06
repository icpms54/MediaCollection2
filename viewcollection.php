<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Media Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $("#header").load("header.php");
            $("#footer").load("footer.html");
        });
    </script>
    <style>
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            height: 250px;
        }

        .image-container img {
            width: auto;
            height: 100%;
        }

        .custom-container {
            padding: 2vh;
        }

        .custom-caption {
            padding-top: 3vh;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="header"></div>
    <main class="container mt-5">
        <?php
        // Connect to database and media file
        require_once 'db_connection.php';
        require_once 'media.php';

        // Check if user is logged in
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
            // If not logged in redirect to login screen
            header("Location: login.php");
            exit;
        }

        // Check if collection ID is provided
        if (!isset($_GET["collectionId"])) {
            // If no collection ID redirect
            header("Location: collections.php");
            exit;
        }

        // Get collection ID from URL
        $collectionId = $_GET["collectionId"];

        // Create new media object
        $media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

        // Retrieve media associated with collection
        $mediaList = $media->getMediaByCollectionId($collectionId);

        if ($mediaList) {
            // Display media associated with collection
            echo "<div class='card mt-5'>";
            echo "<div class='card-header'><h2 class='text-center'>Media in this Collection</h2></div>";
            echo "<div class='card-body'>";
            echo "<ul class='list-group'>";
            foreach ($mediaList as $item) {
                echo "<li class='list-group-item'>{$item['Title']} - {$item['Format']}</li>";
            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
        } else {
            // Display message if no media found
            echo "<div class='alert alert-info mt-3' role='alert'>No media found in this collection.</div>";
        }
        ?>

        <div class="text-center mt-4">
            <!-- Button to add media to collection -->
            <a href="addmediatocollection.php?collectionId=<?php echo $collectionId; ?>" class="btn btn-primary">Add
                Media to Collection</a>
            <!-- Button to remove media from collection -->
            <a href="removemediafromcollection.php?collectionId=<?php echo $collectionId; ?>"
                class="btn btn-warning">Remove
                from Collection</a>
            <div class="text-center mt-4">
                <!-- Button to delete collection -->
                <form action="deletecollection.php" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this collection?');">
                    <!-- Pass collection id -->
                    <input type="hidden" name="collectionId" value="<?php echo $collectionId; ?>">
                    <button type="submit" name="deleteCollection" class="btn btn-danger">Delete Collection</button>
                </form>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
</body>

</html>