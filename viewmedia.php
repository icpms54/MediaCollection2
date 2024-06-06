<?php
// Connect to database, media, and rating pages
require_once 'db_connection.php';
require_once 'media.php';
require_once 'ratingreview.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}

// If mediaid passed as a parameter
if (isset($_GET['mediaId'])) {
    $mediaId = $_GET['mediaId'];
}

// Create new media object
$media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);

// store media details
$mediaDetails = $media->getMediaById($mediaId, $conn);

// Store individual fields
$title = $mediaDetails['Title'];
$format = $mediaDetails['Format'];
$releaseYear = $mediaDetails['ReleaseYear'];
$author_Artist = $mediaDetails['Author_Artist'];
$isbn_Upc = $mediaDetails['ISBN_UPC'];
$runtime_Duration = $mediaDetails['Runtime_Duration'];
$genre = $mediaDetails['Genre'];
$language = $mediaDetails['Language'];
$publisher_Label = $mediaDetails['Publisher_Label'];

// Create new rating review object
$userRatingReview = new RatingReview(null, null, null, null, null, $conn);
// Access method to get review information and store it
$userReviewDetails = $userRatingReview->getRatingReviewByMediaId($mediaId, $profileId, $conn);
// Initialize hasreview variable
$hasReview = false;

// If Rating and Review are filled out 
if ($userReviewDetails !== null && $userReviewDetails['Rating'] !== null && $userReviewDetails['Review'] !== null) {
    // Store these values to be displayed
    $userRating = $userReviewDetails['Rating'];
    $userReview = $userReviewDetails['Review'];
    $hasReview = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <style>
        .view-media-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .media-fields-header {
            font-size: 22px;
            color: #333;
            margin-top: 20px;
            font-weight: bold;
        }

        .fieldheader {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        // Load header and footer
        $(function () {
            $("#header").load("header.php");
            $("#footer").load("footer.html");
        });
    </script>
</head>

<body>
    <div id="header"></div>
    <main>
        <div class="view-media-container">
            <div class="px-4 py-5 my-5">
                <div class="text-center">
                    <h2 class="display-5 fw-bold text-body-emphasis">
                        View Media Details
                    </h2>
                </div>
                <p class="mt-3 mb-3"></p>
                <div class="mb-3">
                    <!-- Display media details -->
                    <h3 class="media-fields-header">Title</h3>
                    <div class="fieldheader">
                        <?php echo $title; ?>
                    </div>
                    <h3 class="media-fields-header">Format</h3>
                    <div class="fieldheader">
                        <?php echo $format; ?>
                    </div>
                    <h3 class="media-fields-header">Release Year</h3>
                    <div class="fieldheader">
                        <?php echo $releaseYear; ?>
                    </div>
                    <h3 class="media-fields-header">Author / Artist</h3>
                    <div class="fieldheader">
                        <?php echo $author_Artist; ?>
                    </div>
                    <h3 class="media-fields-header">ISBN / UPC</h3>
                    <div class="fieldheader">
                        <?php echo $isbn_Upc; ?>
                    </div>
                    <h3 class="media-fields-header">Runtime / Duration</h3>
                    <div class="fieldheader">
                        <?php echo $runtime_Duration; ?>
                    </div>
                    <h3 class="media-fields-header">Genre</h3>
                    <div class="fieldheader">
                        <?php echo $genre; ?>
                    </div>
                    <h3 class="media-fields-header">Language</h3>
                    <div class="fieldheader">
                        <?php echo $language; ?>
                    </div>
                    <h3 class="media-fields-header">Publisher / Label</h3>
                    <div class="fieldheader">
                        <?php echo $publisher_Label; ?>
                    </div>
                    <!-- Display user's rating and review if available -->
                    <h3 class="media-fields-header">Your Rating</h3>
                    <div class="fieldheader">
                        <?php echo !empty($userRating) ? $userRating : 'No rating provided'; ?>
                    </div>
                    <h3 class="media-fields-header">Your Review</h3>
                    <div class="fieldheader">
                        <?php echo !empty($userReview) ? $userReview : 'No review provided'; ?>
                    </div>
                    <!-- Button to navigate to review page that also passes parameters -->
                    <a href="reviewmedia.php?mediaId=<?php echo $mediaId; ?>&userRating=<?php echo $userRating; ?>&userReview=<?php echo urlencode($userReview); ?>"
                        class="btn btn-primary">Review</a>
                    <!-- If there is a rating and a review the delete button will be visible -->
                    <?php if ($hasReview): ?>
                        <form action="deleterating.php" method="post">
                            <input type="hidden" name="mediaId" value="<?php echo $mediaId; ?>">
                            <button type="submit" class="btn btn-danger">Delete Review</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
</body>

</html>