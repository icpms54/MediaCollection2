<?php
// Connect to dataabse and collection page
require_once 'db_connection.php';
require_once 'collection.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}
// Create new collection object
$collection = new Collection(null, null, null, null, $conn);
// Retrieve collection by profile id
$collections = $collection->getCollectionsByProfileId($profileId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Media Collection</title>
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
        <h1 class="text-center mb-3"></h1>
        <div class="card mt-5">
            <div class="card-header">
                <h2 class="text-center">My Collections</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    // Check if there are any collections and display them
                    if ($collections) {
                        foreach ($collections as $collection) {
                            echo "<li class='list-group-item'>Name: {$collection['Name']} | Description: {$collection['Description']} 
                            <a href='viewcollection.php?collectionId={$collection['CollectionID']}' class='btn btn-primary'>View Collection</a> 
                            <a href='editcollection.php?collectionId={$collection['CollectionID']}' class='btn btn-secondary'>Edit Collection</a></li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No collections found.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
</body>

</html>