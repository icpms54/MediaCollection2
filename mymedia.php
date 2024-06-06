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
                <h2 class="text-center">My Media</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    // Connect to database and media page
                    require_once 'db_connection.php';
                    require_once 'media.php';

                    // Retrieve profile ID from session variable
                    $profileId = $_SESSION['ProfileID'];

                    // Create new media object
                    $media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

                    // Retrieve media associated with current profile
                    $mediaList = $media->getMediaByOwnership($profileId, $conn);

                    // Check for media
                    if ($mediaList) {
                        foreach ($mediaList as $item) {
                            // Display media with view, edit, and delete buttons
                            echo "<li class='list-group-item'>Title: {$item['Title']} | Format: {$item['Format']} | Release Year: {$item['ReleaseYear']} 
                            <a href='viewmedia.php?mediaId={$item['MediaID']}' class='btn btn-info btn-sm mx-1'><i class='fas fa-eye'></i> View</a>
                            <a href='editmedia.php?mediaId={$item['MediaID']}' class='btn btn-primary btn-sm mx-1'><i class='fas fa-edit'></i> Edit</a>
                            <form action='deletemedia.php' method='POST' class='d-inline'>
                                <input type='hidden' name='mediaId' value='{$item['MediaID']}'>
                                <button type='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>
                            </form>
                            </li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No media found.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
</body>

</html>