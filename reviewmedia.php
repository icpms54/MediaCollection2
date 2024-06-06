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

// Check for media id
if (isset($_GET['mediaId'])) {
    $mediaId = $_GET['mediaId'];

    // Initialize variables
    $userRating = '';
    $userReview = '';

    // Create new rating object
    $ratingReview = new RatingReview(null, null, null, null, null, $conn);
    // Store result of method
    $userReviewDetails = $ratingReview->getRatingReviewByMediaId($mediaId, $profileId, $conn);
    // Store each specific field
    if ($userReviewDetails) {
        $userRating = $userReviewDetails['Rating'];
        $userReview = $userReviewDetails['Review'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect input
        $rating = $_POST["Rating"];
        $review = $_POST["Review"];

        // Create new rating object
        $ratingReview = new RatingReview(null, null, null, null, null, $conn);

        // Check if review already exists
        if ($userReviewDetails) {
            // Update the existing review
            $success = $ratingReview->editRatingReview($mediaId, $profileId, $rating, $review, $conn);
        } else {
            // Add new review
            $success = $ratingReview->addRatingReview($mediaId, $profileId, $rating, $review, $conn);
        }

        if ($success) {
            // Redirect
            header("Location: viewmedia.php?mediaId=$mediaId");
            exit;
        } else {
            echo "Failed to create or update review.";
        }
    }
} else {
    // If media id is not passed
    echo "Media ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Media Collection</title>
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
        .create-profile-container {
            max-width: 400px;
            max-height: 1500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
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
        <div class="create-profile-container">
            <div class="px-4 py-5 my-5">
                <img class="d-block mx-auto mb-4 text-center" src="images\placeholder.jpg" alt="" width="72"
                    height="57" />
                <h2 class="display-5 fw-bold text-body-emphasis text-center">
                    Review <span class="blue">This </span><span class="orange">Media</span>
                </h2>
                <p class="mt-3 mb-3 text-center">
                    Enter details to review media
                </p>
                <!-- Form for reviewing media -->
                <form action="reviewmedia.php?mediaId=<?php echo $mediaId; ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <!-- Prompt user for rating out of 5 -->
                        <label for="Rating" class="form-label">Rating</label>
                        <select class="form-select" id="Rating" name="Rating" aria-describedby="ItemCondition"
                            required="">
                            <option <?php if ($userRating == '1')
                                echo 'selected'; ?> value="1">1/5</option>
                            <option <?php if ($userRating == '2')
                                echo 'selected'; ?> value="2">2/5</option>
                            <option <?php if ($userRating == '3')
                                echo 'selected'; ?> value="3">3/5</option>
                            <option <?php if ($userRating == '4')
                                echo 'selected'; ?> value="4">4/5</option>
                            <option <?php if ($userRating == '5')
                                echo 'selected'; ?> value="5">5/5</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for written review -->
                        <label for="Review" class="form-label">Review</label>
                        <input type="text" class="form-control" id="Review" name="Review" placeholder="Review"
                            value="<?php echo $userReview; ?>" />
                    </div>
                    <!-- Submit button to create media and cancel to go back -->
                    <button type="submit" class="btn btn-primary mt-3">
                        Submit
                    </button>
                    <a href="index.php" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>